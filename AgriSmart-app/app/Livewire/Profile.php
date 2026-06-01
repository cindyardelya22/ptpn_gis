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
        $device = Auth::user()->devices()->find($deviceId);
        if ($device) {
            $isCurrent = ($device->ip_address === request()->ip() && $device->user_agent === request()->userAgent());
            if (!$isCurrent) {
                $device->delete();
            }
        }
    }

    public function terminateAllDevices(): void
    {
        $currentIp = request()->ip();
        $currentUserAgent = request()->userAgent() ?? '';

        Auth::user()
            ->devices()
            ->where(function ($query) use ($currentIp, $currentUserAgent) {
                $query->where('ip_address', '!=', $currentIp)
                      ->orWhere('user_agent', '!=', $currentUserAgent);
            })
            ->delete();
    }

    public function render()
    {
        $currentIp = request()->ip();
        $currentUserAgent = request()->userAgent() ?? '';

        $devices = Auth::user()->devices()->latest('last_activity_at')->get();

        $devices->transform(function ($device) use ($currentIp, $currentUserAgent) {
            // Override the DB is_current with dynamic check
            $device->is_current = ($device->ip_address === $currentIp && $device->user_agent === $currentUserAgent);
            return $device;
        });

        // Ensure at least one device is current visually if there's a mismatch
        if ($devices->where('is_current', true)->count() === 0 && $devices->count() > 0) {
            $devices->first()->is_current = true;
        }

        return view('livewire.profile', [
            'devices' => $devices,
        ])->layout('layouts.app');
    }
}
