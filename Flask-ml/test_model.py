import joblib
import pandas as pd
import numpy as np

model = joblib.load('model_kesuburan.pkl')
cols = ['N', 'P', 'K', 'pH', 'EC', 'OC', 'S', 'Mg', 'B']

label_map = {0: 'Tidak Subur', 1: 'Kurang Subur', 2: 'Subur'}

tests = [
    # Flask /test hardcoded values
    {'N': 138, 'P': 8.6, 'K': 560, 'pH': 7.46, 'EC': 0.62, 'OC': 0.7, 'S': 5.9, 'Mg': 1.83, 'B': 0.11},
    # High fertility
    {'N': 300, 'P': 20, 'K': 800, 'pH': 6.5, 'EC': 1.0, 'OC': 3.0, 'S': 8, 'Mg': 3.0, 'B': 0.5},
    # Low fertility
    {'N': 50, 'P': 3, 'K': 100, 'pH': 4.0, 'EC': 0.1, 'OC': 0.3, 'S': 1, 'Mg': 0.5, 'B': 0.02},
    # Medium
    {'N': 200, 'P': 15, 'K': 600, 'pH': 7.0, 'EC': 0.8, 'OC': 1.5, 'S': 6, 'Mg': 2.0, 'B': 0.3},
    # Very high
    {'N': 500, 'P': 50, 'K': 1000, 'pH': 6.8, 'EC': 1.5, 'OC': 5.0, 'S': 15, 'Mg': 5.0, 'B': 1.0},
    # Extreme low
    {'N': 10, 'P': 1, 'K': 10, 'pH': 3.5, 'EC': 0.05, 'OC': 0.1, 'S': 0.5, 'Mg': 0.1, 'B': 0.01},
]

print("=" * 80)
print("MODEL PREDICTION SWEEP TEST")
print(f"Model: {type(model).__name__}, Features: {cols}")
print(f"Classes: {model.classes_}")
print("=" * 80)

for i, t in enumerate(tests):
    df = pd.DataFrame([t], columns=cols)
    pred = model.predict(df)[0]
    proba = model.predict_proba(df)[0]
    
    print(f"\nTest {i+1}: N={t['N']}, P={t['P']}, K={t['K']}, pH={t['pH']}, EC={t['EC']}, OC={t['OC']}, S={t['S']}, Mg={t['Mg']}, B={t['B']}")
    print(f"  Prediction: {pred} => {label_map.get(pred, 'Unknown')}")
    print(f"  Probabilities: ", end="")
    for cls_idx, p in enumerate(proba):
        print(f"{label_map.get(cls_idx)}: {p:.4f}  ", end="")
    print()

# Also check what the training data distribution might have looked like
print("\n" + "=" * 80)
print("FEATURE IMPORTANCES:")
print("=" * 80)
for col, imp in zip(cols, model.feature_importances_):
    bar = "#" * int(imp * 50)
    print(f"  {col:>3}: {imp:.4f} {bar}")
