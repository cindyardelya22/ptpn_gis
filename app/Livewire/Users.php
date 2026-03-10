<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Users extends Component
{
    use WithPagination;

    // ── Filter & Search ──
    public string $search = '';
    public string $filterRole = '';
    public string $filterStatus = '';

    // ── Modal State ──
    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $isEdit = false;
    public ?int $editTargetId = null;
    public ?int $deleteTargetId = null;
    public string $deleteTargetName = '';

    // ── Form Fields ──
    public array $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => '',
        'status' => 'active',
    ];

    // ── Reset halaman saat filter berubah ──
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    public function updatedFilterRole(): void
    {
        $this->resetPage();
    }
    public function updatedFilterStatus(): void
    {
        $this->resetPage();
    }

    // ── Buka modal Create ──
    public function openCreate(): void
    {
        $this->reset('form', 'isEdit', 'editTargetId');
        $this->form['status'] = 'active'; // default
        $this->showModal = true;
    }

    // ── Buka modal Edit ──
    #[On('openEditModal')]
    public function openEdit(int $userId): void
    {
        $user = User::findOrFail($userId);

        $this->form = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
            'role' => $user->role,
            'status' => $user->status, // 'active' / 'inactive'
        ];

        $this->editTargetId = $userId;
        $this->isEdit = true;
        $this->showModal = true;
    }

    // ── Buka modal Delete ──
    #[On('openDeleteModal')]
    public function openDelete(int $userId, string $userName): void
    {
        $this->deleteTargetId = $userId;
        $this->deleteTargetName = $userName;
        $this->showDeleteModal = true;
    }

    // ── Tutup semua modal ──
    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetValidation();
    }

    // ── Simpan (Create / Edit) ──
    public function save(): void
    {
        $emailRule = 'required|email|unique:users,email';
        if ($this->isEdit) {
            $emailRule .= ',' . $this->editTargetId;
        }

        $rules = [
            'form.name' => 'required|string|max:255',
            'form.email' => $emailRule,
            'form.role' => 'required|in:admin,editor,user',
            'form.status' => 'required|in:active,inactive',
        ];

        // Password wajib saat create, opsional saat edit
        if (!$this->isEdit) {
            $rules['form.password'] = 'required|min:8';
        } elseif (!empty($this->form['password'])) {
            $rules['form.password'] = 'min:8';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'role' => $this->form['role'],
            'status' => $this->form['status'],
        ];

        if (!empty($this->form['password'])) {
            $data['password'] = bcrypt($this->form['password']);
        }

        if ($this->isEdit) {
            User::findOrFail($this->editTargetId)->update($data);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'User berhasil diperbarui.',
            ]);
        } else {
            User::create($data);
            session()->flash('toast', [
                'type' => 'success',
                'message' => 'User baru berhasil dibuat.',
            ]);
        }

        $this->closeModal();
    }

    // ── Hapus User ──
    public function deleteUser(): void
    {
        User::findOrFail($this->deleteTargetId)->delete();

        session()->flash('toast', [
            'type' => 'success',
            'message' => "\"{$this->deleteTargetName}\" berhasil dihapus.",
        ]);

        $this->closeModal();
    }

    // ── Render ──
    public function render()
    {
        $users = User::query()
            ->when(
                $this->search,
                fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                    ->orWhere('email', 'like', "%{$this->search}%")
                    ->orWhere('role', 'like', "%{$this->search}%")
            )
            ->when(
                $this->filterRole,
                fn($q) =>
                $q->where('role', $this->filterRole)
            )
            ->when(
                $this->filterStatus !== '',
                fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->latest()
            ->paginate(5);

        return view('livewire.users', [
            'users' => $users,
            'activeCount' => User::where('status', 'active')->count(),
            'inactiveCount' => User::where('status', 'inactive')->count(), // ← fix bug: tadi 'active' dua kali
        ])->layout('layouts.app');
    }
}