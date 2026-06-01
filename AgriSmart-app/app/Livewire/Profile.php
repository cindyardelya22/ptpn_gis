<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Profile extends Component
{
    // Profile fields
    public string $username = '';
    public string $displayName = '';  // ← tambahkan ini
    public string $sap = '';
    public string $role = '';

    // Password change
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';
    public bool $showPasswordForm = false;
    public bool $passwordSuccess = false;
    public bool $nameSuccess = false;  // ← tambahkan ini

    // Tabs
    public string $activeTab = 'overview';

    public function mount(): void
    {
        $user = Auth::user();
        $this->username    = $user->username ?? '';
        $this->displayName = $user->username ?? 'Administrator';  // ← isi displayName
        $this->sap         = $user->sap ?? '-';
        $this->role        = $user->role ?? '-';
    }

    // ← tambahkan method ini (dipanggil blade via wire:click="updateName")
    public function updateName(): void
    {
        $this->validate([
            'displayName' => ['required', 'string', 'min:3', 'max:50'],
        ]);

        Auth::user()->update(['username' => $this->displayName]);

        $this->nameSuccess = true;
    }

    public function changePassword(): void
    {
        $this->validate([
            'current_password'          => ['required'],
            'new_password'              => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'new_password_confirmation' => ['required'],
        ], [
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
            'new_password.min'       => 'Password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        if (! Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password saat ini tidak benar.');
            return;
        }

        $user->update(['password' => Hash::make($this->new_password)]);  // ← jangan lupa Hash::make

        $this->reset(['current_password', 'new_password', 'new_password_confirmation', 'showPasswordForm']);
        $this->passwordSuccess = true;
    }

    // ← nama method disesuaikan dengan yang dipanggil blade
    public function removeDevice(int $deviceId): void
    {
        $device = Auth::user()->devices()->where('id', $deviceId)->first();

        if ($device && ! $device->is_current) {
            $device->delete();
        }
    }

    // ← nama method disesuaikan dengan yang dipanggil blade
    public function terminateAllDevices(): void
    {
        Auth::user()->devices()->where('is_current', false)->delete();
    }

    public function render()
    {
        return view('livewire.profile', [
            'devices' => Auth::user()->devices()->latest('last_activity_at')->get()
        ])->layout('layouts.app');
    }
}