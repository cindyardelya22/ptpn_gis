<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PredictionDebugService
{
    /**
     * Test connection to Flask ML API.
     */
    public function testConnection(): array
    {
        try {
            $url = config('services.ml.url');
            $response = Http::timeout(5)->get($url . '/');

            return [
                'connected' => $response->successful(),
                'status'    => $response->status(),
                'data'      => $response->json(),
                'url'       => $url,
            ];
        } catch (\Throwable $e) {
            return [
                'connected' => false,
                'error'     => $e->getMessage(),
                'url'       => config('services.ml.url'),
            ];
        }
    }

    /**
     * Get model info from Flask.
     */
    public function getModelInfo(): array
    {
        try {
            $url = config('services.ml.url') . '/model-info';
            $response = Http::timeout(5)->get($url);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'info'    => $response->json(),
                ];
            }

            return [
                'success' => false,
                'status'  => $response->status(),
                'body'    => $response->body(),
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Send a sample prediction to Flask and compare with expected result.
     *
     * @param array  $input            Key-value pairs matching feature columns
     * @param int|null $expectedLabel   Expected prediction label (0, 1, 2)
     * @param string|null $expectedKategori Expected category string
     */
    public function debugPredict(array $input, ?int $expectedLabel = null, ?string $expectedKategori = null): array
    {
        try {
            $url = config('services.ml.url') . '/debug';

            $payload = [
                'input'              => $input,
                'expected_label'     => $expectedLabel,
                'expected_kategori'  => $expectedKategori,
            ];

            Log::channel('single')->info('[ML-DEBUG] Sending debug request:', $payload);

            $response = Http::timeout(10)
                ->withHeaders(['Accept' => 'application/json'])
                ->post($url, $payload);

            $result = $response->json();

            Log::channel('single')->info('[ML-DEBUG] Response:', $result ?? []);

            return [
                'success'  => $response->successful(),
                'status'   => $response->status(),
                'result'   => $result,
            ];
        } catch (\Throwable $e) {
            Log::channel('single')->error('[ML-DEBUG] Error: ' . $e->getMessage());

            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    /**
     * Compare prediction for a block: show raw DB values, payload sent, and result.
     */
    public function compareBlockPrediction($nutrient): array
    {
        $analysisService = app(SoilAnalysisService::class);

        // Get raw values from DB
        $rawValues = [
            'nitrogen'       => (float) ($nutrient->nitrogen ?? 0),
            'phosphorus'     => (float) ($nutrient->phosphorus ?? 0),
            'potassium'      => (float) ($nutrient->potassium ?? 0),
            'ph'             => (float) ($nutrient->ph ?? 0),
            'ec'             => (float) ($nutrient->ec ?? 0),
            'organic_carbon' => (float) ($nutrient->organic_carbon ?? 0),
            's'              => (float) ($nutrient->s ?? 0),
            'magnesium'      => (float) ($nutrient->magnesium ?? 0),
            'boron'          => (float) ($nutrient->boron ?? 0),
        ];

        // Get ML result
        $mlResult = $analysisService->analyzeFertility($nutrient);

        return [
            'raw_db_values'  => $rawValues,
            'ml_result'      => $mlResult,
            'source'         => $mlResult['source'] ?? 'unknown',
            'debug_info'     => $mlResult['debug'] ?? null,
        ];
    }
}
