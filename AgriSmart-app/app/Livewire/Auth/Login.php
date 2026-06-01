<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User;
use App\Models\UserDevice;

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
    // Real-time validation saat user mengetik
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

        $credentials = [
            'sap'      => $this->nomor_sap,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials, $this->remember)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();
            
            $user = Auth::user();
            
            // 1. Update last login status
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => request()->ip(),
                'failed_login_attempts' => 0,
            ]);

            // 2. Track Device Session
            // Install jenssegers/agent on demand, or use basic headers if not available
            $userAgent = request()->header('User-Agent');
            $browser = 'Unknown Browser';
            $platform = 'Unknown OS';
            
            if (preg_match('/(Edg|Edge|Chrome|Safari|Firefox|Opera)\/?\s*(\d+)/i', $userAgent, $matches)) {
                $browser = $matches[1] . ' ' . $matches[2];
            }
            if (preg_match('/(Windows NT 10.0|Windows NT 6.3|Windows NT 6.2|Windows NT 6.1|Mac OS X|Linux|Android|iOS)/i', $userAgent, $matches)) {
                $platform = $matches[1];
            }

            // Set all other devices to not current
            $user->devices()->update(['is_current' => false]);

            $user->devices()->create([
                'device_name' => $platform . ' - ' . $browser,
                'browser' => $browser,
                'platform' => $platform,
                'ip_address' => request()->ip(),
                'user_agent' => $userAgent,
                'last_activity_at' => now(),
                'is_current' => true,
            ]);

            $this->redirect(route('dashboard'), navigate: true);
            return;
        }

        RateLimiter::hit($throttleKey, decay: 60);

        $this->addError('nomor_sap', 'Nomor SAP atau password tidak sesuai.');
        $this->reset('password');
    }

    // -------------------------------------------------------
    // Render — pakai ->layout() langsung di sini
    // -------------------------------------------------------
    public function render()
    {
        return view('livewire.auth.login')
            ->layout('layouts.auth', ['title' => 'Login - Sistem GIS']);
    }
}