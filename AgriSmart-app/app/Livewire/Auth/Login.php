<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends Component
{
    public string $nomor_sap = '';
    public string $password  = '';
    public bool   $remember  = false;

    // -------------------------------------------------------
    // Validation rules
    // -------------------------------------------------------
    protected function rules(): array
    {
        return [
            'nomor_sap' => ['required', 'string', 'min:5', 'max:20', 'regex:/^[0-9]+$/'],
            'password'  => ['required', 'string', 'min:6'],
        ];
    }

    protected function messages(): array
    {
        return [
            'nomor_sap.required' => 'Nomor SAP wajib diisi.',
            'nomor_sap.min'      => 'Nomor SAP minimal 5 digit.',
            'nomor_sap.max'      => 'Nomor SAP maksimal 20 digit.',
            'nomor_sap.regex'    => 'Nomor SAP hanya boleh berisi angka.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
        ];
    }

    // -------------------------------------------------------
    // Real-time validation
    // -------------------------------------------------------
    public function updated(string $field): void
    {
        $this->validateOnly($field);
    }

    // -------------------------------------------------------
    // Submit login
    // -------------------------------------------------------
    public function login(): void
    {
        $this->validate();

        // Rate limiting — maks 5 percobaan per menit per IP
        $throttleKey = 'login.' . request()->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, maxAttempts: 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->addError('nomor_sap', "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.");
            return;
        }

        // Cari user berdasarkan field 'sap' di database
        $user = User::where('sap', $this->nomor_sap)->first();

        // Validasi user tidak ditemukan atau password salah
        if (! $user || ! Hash::check($this->password, $user->password)) {
            RateLimiter::hit($throttleKey, decay: 60);

            // Increment failed attempts jika user ditemukan
            if ($user) {
                $user->increment('failed_login_attempts');
            }

            $this->addError('nomor_sap', 'Nomor SAP atau password tidak sesuai.');
            $this->reset('password');
            return;
        }

        // Cek akun aktif
        if (! $user->is_active) {
            $this->addError('nomor_sap', 'Akun Anda telah dinonaktifkan. Hubungi administrator.');
            $this->reset('password');
            return;
        }

        // Cek account lock
        if ($user->locked_until && $user->locked_until->isFuture()) {
            $menit = now()->diffInMinutes($user->locked_until) + 1;
            $this->addError('nomor_sap', "Akun terkunci. Coba lagi dalam {$menit} menit.");
            $this->reset('password');
            return;
        }

        // Login manual — Auth::attempt() pakai field 'sap' sebagai username
        Auth::login($user, $this->remember);
        RateLimiter::clear($throttleKey);
        session()->regenerate();

        // Update last login & reset failed attempts
        $user->update([
            'last_login_at'         => now(),
            'last_login_ip'         => request()->ip(),
            'failed_login_attempts' => 0,
            'locked_until'          => null,
        ]);

        // Track device session
        $this->trackDevice($user);

        $this->redirect(route('dashboard'));
    }

    // -------------------------------------------------------
    // Track device helper
    // -------------------------------------------------------
    private function trackDevice(User $user): void
    {
        $userAgent = request()->userAgent() ?? '';
        $browser   = $this->parseBrowser($userAgent);
        $platform  = $this->parsePlatform($userAgent);

        // Set semua device lama menjadi bukan current
        $user->devices()->update(['is_current' => false]);

        // Update jika kombinasi user_agent + ip sudah ada, buat baru jika belum
        $user->devices()->updateOrCreate(
            [
                'user_agent' => $userAgent,
                'ip_address' => request()->ip(),
            ],
            [
                'device_name'      => $platform . ' - ' . $browser,
                'browser'          => $browser,
                'platform'         => $platform,
                'last_activity_at' => now(),
                'is_current'       => true,
            ]
        );
    }

    private function parseBrowser(string $userAgent): string
    {
        $browsers = [
            'Edg'     => 'Edge',
            'Chrome'  => 'Chrome',
            'Firefox' => 'Firefox',
            'Safari'  => 'Safari',
            'Opera'   => 'Opera',
        ];

        foreach ($browsers as $key => $name) {
            if (str_contains($userAgent, $key)) {
                if (preg_match('/' . $key . '[\/\s](\d+)/i', $userAgent, $m)) {
                    return $name . ' ' . $m[1];
                }
                return $name;
            }
        }

        return 'Unknown Browser';
    }

    private function parsePlatform(string $userAgent): string
    {
        $platforms = [
            'Windows NT 10.0' => 'Windows 10/11',
            'Windows NT 6.3'  => 'Windows 8.1',
            'Windows NT 6.1'  => 'Windows 7',
            'Mac OS X'        => 'macOS',
            'Android'         => 'Android',
            'iPhone'          => 'iOS',
            'iPad'            => 'iPadOS',
            'Linux'           => 'Linux',
        ];

        foreach ($platforms as $key => $name) {
            if (str_contains($userAgent, $key)) {
                return $name;
            }
        }

        return 'Unknown OS';
    }

    // -------------------------------------------------------
    // Render
    // -------------------------------------------------------
    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth', ['title' => 'Login - Sistem GIS']);
    }
}
