<?php

namespace App\Services;

use App\Models\SoilNutrient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SoilAnalysisService
{
    private string $flaskUrl;

    public function __construct()
    {
        // Set URL Flask di .env: ML_SERVICE_URL=http://127.0.0.1:5000
        $this->flaskUrl = config('services.ml.url', 'http://127.0.0.1:5000');
    }

    /**
     * Prediksi status kesuburan via Flask ML lalu simpan ke database.
     * Dipanggil saat tambah/edit data unsur hara.
     */
    public function predictAndSave(SoilNutrient $nutrient): array
    {
        $result = $this->callFlaskPredict($nutrient);

        // Simpan ke database
        $nutrient->fertility_status = $result['status'];
        $nutrient->fertility_color  = $result['color'];
        $nutrient->fertility_probabilities = $result['probabilities'];
        $nutrient->save();

        Log::info('[ML] Status kesuburan disimpan ke DB', [
            'nutrient_id' => $nutrient->id,
            'block_id'    => $nutrient->block_id,
            'status'      => $result['status'],
        ]);

        return $result;
    }

    /**
     * Ambil status kesuburan. Prioritas: DB → Flask → Fallback.
     * Digunakan saat render halaman (read-only, tidak menyimpan).
     */
    public function analyzeFertility(SoilNutrient $nutrient): array
    {
        // 1. Baca dari DB jika sudah ada
        if ($nutrient->fertility_status) {
            return [
                'status'        => $nutrient->fertility_status,
                'color'         => $nutrient->fertility_color ?? $this->categoryToColor($nutrient->fertility_status),
                'probabilities' => $nutrient->fertility_probabilities ?? [],
                'source'        => 'database',
            ];
        }

        // 2. Belum ada di DB → panggil Flask
        $result = $this->callFlaskPredict($nutrient);
        $result['source'] = $result['source'] ?? 'flask';

        return $result;
    }

    /**
     * Kirim data ke Flask ML API /predict.
     */
    private function callFlaskPredict(SoilNutrient $nutrient): array
    {
        try {
            $payload = [
                'N'  => (float) $nutrient->nitrogen,
                'P'  => (float) $nutrient->phosphorus,
                'K'  => (float) $nutrient->potassium,
                'pH' => (float) $nutrient->ph,
                'EC' => (float) $nutrient->ec,
                'OC' => (float) $nutrient->organic_carbon,
                'S'  => (float) $nutrient->s,
                'Mg' => (float) $nutrient->magnesium,
                'B'  => (float) $nutrient->boron,
            ];

            $response = Http::timeout(5)->post("{$this->flaskUrl}/predict", $payload);

            if ($response->successful()) {
                $data     = $response->json();
                $kategori = $data['kategori'] ?? 'Tidak Subur';
                $probabilities = $data['probabilities'] ?? [];

                return [
                    'status'        => $kategori,
                    'color'         => $this->categoryToColor($kategori),
                    'probabilities' => $probabilities,
                    'source'        => 'flask',
                ];
            }

            Log::warning('Flask ML response error', ['status' => $response->status()]);

        } catch (\Exception $e) {
            Log::error('Flask ML connection failed: ' . $e->getMessage());
        }

        // Fallback jika Flask tidak bisa diakses
        return $this->fallbackAnalysis($nutrient);
    }

    private function categoryToColor(string $kategori): string
    {
        return match ($kategori) {
            'Subur'        => 'emerald',
            'Kurang Subur' => 'amber',
            default        => 'rose',
        };
    }

    /**
     * Fallback sederhana jika Flask tidak jalan
     */
    private function fallbackAnalysis(SoilNutrient $nutrient): array
    {
        $score = 0;

        if ($nutrient->ph >= 5.5 && $nutrient->ph <= 7.5) $score++;
        if ($nutrient->nitrogen > 100)                     $score++;
        if ($nutrient->phosphorus > 10)                    $score++;
        if ($nutrient->potassium > 150)                    $score++;
        if ($nutrient->organic_carbon > 1.0)               $score++;

        if ($score >= 4) {
            return ['status' => 'Subur',        'color' => 'emerald', 'probabilities' => [], 'source' => 'fallback'];
        } elseif ($score >= 2) {
            return ['status' => 'Kurang Subur', 'color' => 'amber',   'probabilities' => [], 'source' => 'fallback'];
        }

        return ['status' => 'Tidak Subur', 'color' => 'rose', 'probabilities' => [], 'source' => 'fallback'];
    }
}