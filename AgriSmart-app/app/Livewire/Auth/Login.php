<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

class Login extends Component
{
    public string $nomor_sap = '';
    public string $password  = '';

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
            'nomor_sap' => $this->nomor_sap,
            'password'  => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            RateLimiter::clear($throttleKey);
            session()->regenerate();

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