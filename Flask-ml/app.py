from flask import Flask, request, jsonify
import pandas as pd
import joblib


app = Flask(__name__)

@app.route('/test')
def test():

    input_data = pd.DataFrame([{
        'N': 138,
        'P': 8.6,
        'K': 560,
        'pH': 7.46,
        'EC': 0.62,
        'OC': 0.7,
        'S': 5.9,
        'Mg': 1.83,
        'B': 0.11
    }])

    hasil = model.predict(input_data)[0]

    return jsonify({
        "hasil": int(hasil)
    })

# Load model
model = joblib.load('model_kesuburan.pkl')

@app.route('/predict', methods=['POST'])
def predict():

    try:

        # Ambil data dari Laravel
        data = request.json

        # Buat dataframe sesuai urutan fitur
        input_data = pd.DataFrame([{
            'N': float(data['N']),
            'P': float(data['P']),
            'K': float(data['K']),
            'pH': float(data['pH']),
            'EC': float(data['EC']),
            'OC': float(data['OC']),
            'S': float(data['S']),
            'Mg': float(data['Mg']),
            'B': float(data['B'])
        }])

        # Prediksi model
        hasil = model.predict(input_data)[0]

        # Konversi label
        kategori = ""

        if hasil == 0:
            kategori = "Tidak Subur"

        elif hasil == 1:
            kategori = "Kurang Subur"

        elif hasil == 2:
            kategori = "Subur"

        # Return JSON
        return jsonify({
            "success": True,
            "prediksi": int(hasil),
            "kategori": kategori
        })

    except Exception as e:

        return jsonify({
            "success": False,
            "error": str(e)
        })


if __name__ == '__main__':
    app.run(debug=True)