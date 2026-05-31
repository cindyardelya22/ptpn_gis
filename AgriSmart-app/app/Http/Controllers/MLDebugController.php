<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Services\PredictionDebugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MLDebugController extends Controller
{
    public function __construct(
        private PredictionDebugService $debugService
    ) {}

    /**
     * GET /ml-debug/test
     * Test connection to Flask ML API.
     */
    public function testConnection(): JsonResponse
    {
        $result = $this->debugService->testConnection();

        return response()->json([
            'title'  => 'ML Service Connection Test',
            'result' => $result,
        ]);
    }

    /**
     * GET /ml-debug/model-info
     * Get detailed model information from Flask.
     */
    public function modelInfo(): JsonResponse
    {
        $result = $this->debugService->getModelInfo();

        return response()->json([
            'title'  => 'ML Model Information',
            'result' => $result,
        ]);
    }

    /**
     * GET /ml-debug/predict-sample
     * Test prediction with the same sample data as the Flask /test endpoint.
     * You can also POST custom data.
     */
    public function predictSample(Request $request): JsonResponse
    {
        // Default sample — same as Flask /test endpoint
        $input = $request->input('input', [
            'N'  => 138,
            'P'  => 8.6,
            'K'  => 560,
            'pH' => 7.46,
            'EC' => 0.62,
            'OC' => 0.7,
            'S'  => 5.9,
            'Mg' => 1.83,
            'B'  => 0.11,
        ]);

        $expectedLabel    = $request->input('expected_label');
        $expectedKategori = $request->input('expected_kategori');

        $result = $this->debugService->debugPredict(
            $input,
            $expectedLabel !== null ? (int) $expectedLabel : null,
            $expectedKategori
        );

        return response()->json([
            'title'  => 'Sample Prediction Debug',
            'input'  => $input,
            'expected' => [
                'label'    => $expectedLabel,
                'kategori' => $expectedKategori,
            ],
            'result' => $result,
        ]);
    }

    /**
     * GET /ml-debug/compare/{blockId}
     * Compare raw DB values with prediction result for a specific block.
     */
    public function compareBlock(int $blockId): JsonResponse
    {
        $block = Block::with(['nutrients' => function ($q) {
            $q->latest('measured_at');
        }])->find($blockId);

        if (!$block) {
            return response()->json([
                'error' => "Block #{$blockId} not found",
            ], 404);
        }

        $latest = $block->nutrients->first();

        if (!$latest) {
            return response()->json([
                'error' => "Block #{$blockId} has no nutrient data",
                'block' => $block->name,
            ], 404);
        }

        $result = $this->debugService->compareBlockPrediction($latest);

        return response()->json([
            'title'     => "Prediction Comparison for Block: {$block->name}",
            'block_id'  => $block->id,
            'block_name' => $block->name,
            'result'    => $result,
        ]);
    }

    /**
     * GET /ml-debug/compare-all
     * Compare predictions for all blocks.
     */
    public function compareAll(): JsonResponse
    {
        $blocks = Block::with(['nutrients' => function ($q) {
            $q->latest('measured_at');
        }])->get();

        $results = [];
        foreach ($blocks as $block) {
            $latest = $block->nutrients->first();
            if ($latest) {
                $comparison = $this->debugService->compareBlockPrediction($latest);
                $results[] = [
                    'block_id'   => $block->id,
                    'block_name' => $block->name,
                    'prediction' => $comparison['ml_result']['status'] ?? 'N/A',
                    'source'     => $comparison['source'],
                    'raw_values' => $comparison['raw_db_values'],
                ];
            }
        }

        return response()->json([
            'title'   => 'All Block Predictions Comparison',
            'count'   => count($results),
            'results' => $results,
        ]);
    }
}
