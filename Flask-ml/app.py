import os
import logging
from datetime import datetime
from flask import Flask, request, jsonify
import pandas as pd
import numpy as np
import joblib

# ──────────────────────────────────────────────
# Logging Configuration
# ──────────────────────────────────────────────
logging.basicConfig(
    level=logging.DEBUG,
    format='%(asctime)s [%(levelname)s] %(message)s',
    handlers=[
        logging.StreamHandler(),
        logging.FileHandler('flask_ml_debug.log', encoding='utf-8'),
    ]
)
logger = logging.getLogger(__name__)

app = Flask(__name__)

# ──────────────────────────────────────────────
# Feature Configuration (MUST match training order)
# ──────────────────────────────────────────────
FEATURE_COLUMNS = ['N', 'P', 'K', 'pH', 'EC', 'OC', 'S', 'Mg', 'B']

LABEL_MAP = {
    0: 'Tidak Subur',
    1: 'Kurang Subur',
    2: 'Subur',
}

# ──────────────────────────────────────────────
# Load Model & Optional Scaler
# ──────────────────────────────────────────────
MODEL_PATH = os.environ.get('MODEL_PATH', 'model_kesuburan.pkl')
SCALER_PATH = os.environ.get('SCALER_PATH', 'scaler.pkl')

logger.info(f'Loading model from: {MODEL_PATH}')
model = joblib.load(MODEL_PATH)
logger.info(f'Model loaded successfully: {type(model).__name__}')

# Try to detect feature names from model
try:
    if hasattr(model, 'feature_names_in_'):
        logger.info(f'Model feature names: {list(model.feature_names_in_)}')
    if hasattr(model, 'n_features_in_'):
        logger.info(f'Model expects {model.n_features_in_} features')
except Exception as e:
    logger.warning(f'Could not read model feature info: {e}')

# Load scaler if available
scaler = None
if os.path.exists(SCALER_PATH):
    scaler = joblib.load(SCALER_PATH)
    logger.info(f'Scaler loaded: {type(scaler).__name__}')
else:
    logger.info('No scaler.pkl found — raw data will be used directly (OK for tree-based models)')


def validate_input(data: dict) -> tuple:
    """Validate that all required features exist and are numeric."""
    errors = []
    cleaned = {}

    for col in FEATURE_COLUMNS:
        val = data.get(col)
        if val is None:
            errors.append(f"Missing field: '{col}'")
            continue
        try:
            cleaned[col] = float(val)
        except (ValueError, TypeError):
            errors.append(f"Field '{col}' is not numeric: {val!r}")

    return cleaned, errors


def run_prediction(input_dict: dict) -> dict:
    """
    Core prediction pipeline.
    Returns a dict with all debug information.
    """
    # Step 1: Create DataFrame with correct column order
    input_data = pd.DataFrame([input_dict], columns=FEATURE_COLUMNS)

    logger.info('=' * 60)
    logger.info('PREDICTION PIPELINE START')
    logger.info(f'Raw input dict : {input_dict}')
    logger.info(f'DataFrame shape: {input_data.shape}')
    logger.info(f'DataFrame cols : {list(input_data.columns)}')
    logger.info(f'DataFrame vals : {input_data.values.tolist()[0]}')

    # Step 2: Apply scaler if available
    scaled_values = None
    if scaler is not None:
        input_array = scaler.transform(input_data)
        scaled_values = input_array.tolist()[0]
        logger.info(f'Scaled values  : {scaled_values}')
        # Replace the data with scaled version
        input_data = pd.DataFrame(input_array, columns=FEATURE_COLUMNS)
    else:
        logger.info('No scaler applied (using raw values)')

    # Step 3: Predict
    prediction_raw = model.predict(input_data)
    hasil = int(prediction_raw[0])
    kategori = LABEL_MAP.get(hasil, f'Unknown({hasil})')

    logger.info(f'Prediction raw : {prediction_raw}')
    logger.info(f'Prediction int : {hasil}')
    logger.info(f'Category       : {kategori}')

    # Step 4: Get prediction probabilities if available
    probabilities = None
    if hasattr(model, 'predict_proba'):
        try:
            proba = model.predict_proba(input_data)
            probabilities = {
                LABEL_MAP.get(i, f'class_{i}'): round(float(p), 4)
                for i, p in enumerate(proba[0])
            }
            logger.info(f'Probabilities  : {probabilities}')
        except Exception as e:
            logger.warning(f'Could not get probabilities: {e}')

    logger.info('PREDICTION PIPELINE END')
    logger.info('=' * 60)

    return {
        'prediksi': hasil,
        'kategori': kategori,
        'probabilities': probabilities,
        'input_received': input_dict,
        'input_array': input_data.values.tolist()[0],
        'scaled_values': scaled_values,
        'feature_order': FEATURE_COLUMNS,
    }


# ──────────────────────────────────────────────
# ENDPOINTS
# ──────────────────────────────────────────────

@app.route('/')
def index():
    return jsonify({
        'service': 'AgriSmart ML API',
        'status': 'running',
        'model': type(model).__name__,
        'scaler': type(scaler).__name__ if scaler else None,
        'features': FEATURE_COLUMNS,
        'endpoints': ['/predict', '/debug', '/model-info', '/test'],
    })


@app.route('/model-info')
def model_info():
    """Return detailed information about the loaded model."""
    info = {
        'model_type': type(model).__name__,
        'model_path': MODEL_PATH,
        'scaler_type': type(scaler).__name__ if scaler else None,
        'scaler_path': SCALER_PATH if scaler else None,
        'feature_columns': FEATURE_COLUMNS,
        'label_map': LABEL_MAP,
    }

    # Extract model-specific info
    if hasattr(model, 'feature_names_in_'):
        info['model_feature_names'] = list(model.feature_names_in_)
    if hasattr(model, 'n_features_in_'):
        info['n_features'] = int(model.n_features_in_)
    if hasattr(model, 'classes_'):
        info['classes'] = [int(c) for c in model.classes_]
    if hasattr(model, 'n_estimators'):
        info['n_estimators'] = model.n_estimators
    if hasattr(model, 'get_params'):
        try:
            params = model.get_params()
            # Filter out non-serializable params
            info['params'] = {
                k: str(v) for k, v in params.items()
                if isinstance(v, (str, int, float, bool, type(None)))
            }
        except Exception:
            pass

    # Scaler info
    if scaler is not None:
        if hasattr(scaler, 'mean_'):
            info['scaler_mean'] = scaler.mean_.tolist()
        if hasattr(scaler, 'scale_'):
            info['scaler_scale'] = scaler.scale_.tolist()
        if hasattr(scaler, 'data_min_'):
            info['scaler_min'] = scaler.data_min_.tolist()
        if hasattr(scaler, 'data_max_'):
            info['scaler_max'] = scaler.data_max_.tolist()

    return jsonify(info)


@app.route('/test')
def test():
    """Quick test with hardcoded sample data."""
    sample = {
        'N': 138, 'P': 8.6, 'K': 560,
        'pH': 7.46, 'EC': 0.62, 'OC': 0.7,
        'S': 5.9, 'Mg': 1.83, 'B': 0.11
    }
    result = run_prediction(sample)
    return jsonify({
        'test_input': sample,
        'success': True,
        **result
    })


@app.route('/predict', methods=['POST'])
def predict():
    """Main prediction endpoint — called by Laravel."""
    try:
        data = request.json
        logger.info(f'[/predict] Request received: {data}')

        if data is None:
            return jsonify({
                'success': False,
                'error': 'Request body kosong atau bukan JSON. Pastikan Content-Type: application/json'
            }), 400

        # Validate input
        cleaned, errors = validate_input(data)
        if errors:
            logger.error(f'[/predict] Validation errors: {errors}')
            return jsonify({
                'success': False,
                'error': 'Validation failed',
                'details': errors,
                'received_fields': list(data.keys()),
                'required_fields': FEATURE_COLUMNS,
            }), 400

        # Run prediction
        result = run_prediction(cleaned)

        return jsonify({
            'success': True,
            'prediksi': result['prediksi'],
            'kategori': result['kategori'],
            'probabilities': result['probabilities'],
            'debug': {
                'input_received': result['input_received'],
                'input_array': result['input_array'],
                'scaled_values': result['scaled_values'],
                'feature_order': result['feature_order'],
                'scaler_used': scaler is not None,
                'model_type': type(model).__name__,
                'timestamp': datetime.now().isoformat(),
            }
        })

    except Exception as e:
        logger.exception(f'[/predict] Unhandled error: {e}')
        return jsonify({
            'success': False,
            'error': str(e),
            'error_type': type(e).__name__,
        }), 500


@app.route('/debug', methods=['POST'])
def debug_predict():
    """
    Debug endpoint — send the EXACT same data as Google Colab
    and compare results. Include your expected result in the request.

    Example POST body:
    {
        "input": {"N": 138, "P": 8.6, "K": 560, "pH": 7.46, "EC": 0.62, "OC": 0.7, "S": 5.9, "Mg": 1.83, "B": 0.11},
        "expected_label": 2,
        "expected_kategori": "Subur"
    }
    """
    try:
        data = request.json
        input_data = data.get('input', {})
        expected_label = data.get('expected_label')
        expected_kategori = data.get('expected_kategori')

        logger.info(f'[/debug] Input: {input_data}')
        logger.info(f'[/debug] Expected: label={expected_label}, kategori={expected_kategori}')

        cleaned, errors = validate_input(input_data)
        if errors:
            return jsonify({'success': False, 'errors': errors}), 400

        result = run_prediction(cleaned)

        # Compare with expected
        match_label = (expected_label is None) or (result['prediksi'] == expected_label)
        match_kategori = (expected_kategori is None) or (result['kategori'] == expected_kategori)

        comparison = {
            'label_match': match_label,
            'kategori_match': match_kategori,
            'flask_prediksi': result['prediksi'],
            'flask_kategori': result['kategori'],
            'expected_label': expected_label,
            'expected_kategori': expected_kategori,
        }

        if not match_label or not match_kategori:
            logger.warning(f'[/debug] MISMATCH DETECTED! {comparison}')
        else:
            logger.info(f'[/debug] Results MATCH! {comparison}')

        return jsonify({
            'success': True,
            'match': match_label and match_kategori,
            'comparison': comparison,
            'prediction_detail': result,
        })

    except Exception as e:
        logger.exception(f'[/debug] Error: {e}')
        return jsonify({'success': False, 'error': str(e)}), 500


if __name__ == '__main__':
    logger.info('Starting AgriSmart ML API...')
    app.run(debug=True, host='0.0.0.0', port=5000)