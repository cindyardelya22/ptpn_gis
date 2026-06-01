<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Component
{
    // Profile fields
    public string $username    = '';
    public string $displayName = '';
    public string $sap         = '';
    public string $role        = '';

    // Password change
    public string $current_password          = '';
    public string $new_password              = '';
    public string $new_password_confirmation = '';
    public bool $accountSuccess = false;

    // Tabs
    public string $activeTab = 'overview';

    public function mount(): void
    {
        $user              = Auth::user();
        $this->username    = $user->username ?? '';
        $this->displayName = $user->username ?? '';
        $this->sap         = $user->sap ?? '-';
        $this->role        = $user->role ?? '-';
    }

    public function updateAccount(): void
    {
        $rules = [
            'displayName' => ['required', 'string', 'min:3', 'max:50'],
        ];

        // Validasi password hanya jika user mengisi password baru
        if ($this->new_password !== '') {
            $rules['current_password'] = ['required'];

            $rules['new_password'] = [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers(),
            ];

            $rules['new_password_confirmation'] = ['required'];
        }

        $this->validate($rules, [
            'displayName.required' => 'Username wajib diisi.',
            'displayName.min'      => 'Username minimal 3 karakter.',
            'displayName.max'      => 'Username maksimal 50 karakter.',

            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        // Update Username
        if ($user->username !== $this->displayName) {
            $user->update([
                'username' => $this->displayName,
            ]);

            $this->username = $this->displayName;
        }

        // Update Password jika diisi
        if ($this->new_password !== '') {

            if (! Hash::check($this->current_password, $user->password)) {
                $this->addError(
                    'current_password',
                    'Password saat ini tidak benar.'
                );

                return;
            }

            $user->update([
                'password' => $this->new_password,
            ]);
        }

        $this->reset([
            'current_password',
            'new_password',
            'new_password_confirmation',
        ]);
        $this->accountSuccess = true;
    }

    // ── Device Management ──────────────────────────────────────────
    public function removeDevice(int $deviceId): void
    {
        Auth::user()
            ->devices()
            ->where('id', $deviceId)
            ->where('is_current', false) // tidak bisa hapus device aktif
            ->delete();
    }

    public function terminateAllDevices(): void
    {
        Auth::user()
            ->devices()
            ->where('is_current', false)
            ->delete();
    }

    public function render()
    {
        return view('livewire.profile', [
            'devices' => Auth::user()->devices()->latest('last_activity_at')->get(),
        ])->layout('layouts.app');
    }
}
