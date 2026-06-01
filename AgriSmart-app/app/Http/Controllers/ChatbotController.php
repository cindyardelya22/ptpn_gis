<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    private string $systemPrompt = <<<PROMPT
Kamu adalah asisten AI bernama "AgriBot" untuk sistem AgriSmart — Sistem Informasi Geografis (GIS) untuk perkebunan kelapa sawit PTPN.

**Tugasmu:**
Membantu pengguna memahami dan menggunakan fitur-fitur dalam sistem AgriSmart. Kamu bisa menjawab pertanyaan seputar:

1. **Dashboard** — Menampilkan ringkasan data keseluruhan perkebunan, statistik blok, dan status kesuburan tanah.
2. **Data Unsur Hara** — Mengelola data sampel tanah per blok kebun, termasuk nilai N, P, K, Mg, pH, dan lain-lain. Pengguna dapat menambah, mengedit, menghapus data, serta melihat status kesuburan (Subur/Kurang Subur/Tidak Subur).
3. **Peta Blok Kebun** — Visualisasi peta interaktif semua blok kebun menggunakan OpenLayers. Setiap blok ditampilkan dengan warna berdasarkan status kesuburannya.
4. **Analisis Kesuburan (Peta Analisis)** — Analisis prediksi kesuburan menggunakan model Machine Learning. Menampilkan probabilitas kesuburan dan rekomendasi pemupukan per blok.
5. **Laporan** — Mengunduh laporan data unsur hara dalam format PDF dan Excel, bisa difilter per blok, periode, dan status.
6. **Setting** — Khusus untuk admin/superadmin: mengelola pengguna (tambah, edit, hapus, aktifkan/nonaktifkan) dan mengatur hak akses per role.
7. **Profil** — Mengubah username, password, dan melihat/menghentikan sesi perangkat yang login.

**Role Pengguna:**
- **Superadmin** — Akses penuh ke semua fitur.
- **Admin** — Akses ke fitur operasional termasuk manajemen user.
- **Viewer** — Hanya bisa melihat data, tidak bisa mengubah.

**Aturan:**
- Jawab HANYA dalam Bahasa Indonesia.
- Jika pertanyaan di luar konteks sistem AgriSmart atau perkebunan kelapa sawit, tolak dengan sopan dan arahkan kembali ke topik sistem.
- Jawaban singkat, jelas, dan mudah dipahami.
- Gunakan emoji sesekali untuk membuat percakapan lebih ramah 🌿
PROMPT;

    public function chat(Request $request)
    {
        $request->validate([
            'message'  => 'required|string|max:1000',
            'history'  => 'nullable|array',
            'history.*.role' => 'required|in:user,model',
            'history.*.text' => 'required|string',
        ]);

        $apiKey = config('services.gemini.api_key');

        if (!$apiKey) {
            return response()->json(['error' => 'API key tidak dikonfigurasi.'], 500);
        }

        // Build conversation contents for Gemini
        $contents = [];

        // Inject system prompt as first user/model exchange
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $this->systemPrompt]],
        ];
        $contents[] = [
            'role'  => 'model',
            'parts' => [['text' => 'Baik! Saya AgriBot, siap membantu Anda menggunakan sistem AgriSmart. Ada yang bisa saya bantu? 🌿']],
        ];

        // Add conversation history
        foreach ($request->input('history', []) as $msg) {
            $contents[] = [
                'role'  => $msg['role'],
                'parts' => [['text' => $msg['text']]],
            ];
        }

        // Add current user message
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $request->input('message')]],
        ];

        $response = Http::timeout(30)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
            [
                'contents'         => $contents,
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 1024,
                ],
            ]
        );

        if ($response->failed()) {
            return response()->json([
                'error' => 'Gagal menghubungi layanan AI. Coba lagi.',
            ], 500);
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat menjawab saat ini.';

        return response()->json(['reply' => $text]);
    }
}
