<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Setting extends Component
{
    use WithPagination;

    // ── Search & Filter ──────────────────────────────────────────
    public string $search      = '';
    public string $filterRole   = '';
    public string $filterStatus = '';

    // ── Modal state ──────────────────────────────────────────────
    public bool  $showModal       = false;
    public bool  $showDeleteModal = false;
    public bool  $isEdit          = false;
    public ?int  $editingUserId   = null;
    public int|string $deleteTargetId   = 0;
    public string     $deleteTargetName = '';

    // ── Form fields ──────────────────────────────────────────────
    public array $form = [
        'name'     => '',
        'email'    => '',
        'no_sap'   => '',
        'password' => '',
        'role'     => '',
    ];

    // ── Permissions matrix ───────────────────────────────────────
    // Shape: ['admin' => ['dashboard' => ['view'], ...], 'viewer' => [...]]
    public array $permissions = [];

    // ── Computed stats ───────────────────────────────────────────
    public int $activeCount   = 0;
    public int $inactiveCount = 0;

    // ── Default permission presets ───────────────────────────────
    protected array $defaultPermissions = [
        'admin' => [
            'dashboard'       => ['view'],
            'data-unsur-hara' => ['view', 'create', 'edit', 'delete'],
            'peta-blok'       => ['view'],
            'peta-analisis'   => ['view', 'rekomendasi'],
            'laporan'         => ['view', 'download_pdf', 'download_excel'],
            'settings'        => ['view', 'manage_users'],
        ],
        'viewer' => [
            'dashboard'       => ['view'],
            'data-unsur-hara' => ['view'],
            'peta-blok'       => ['view'],
            'peta-analisis'   => ['view'],
            'laporan'         => ['view'],
            'settings'        => [],
        ],
    ];

    // ── Listeners ────────────────────────────────────────────────
    protected $listeners = [
        'openEditModal'   => 'openEdit',
        'openDeleteModal' => 'openDelete',
    ];

    // ── Lifecycle ────────────────────────────────────────────────
    public function mount(): void
    {
        $this->loadPermissions();
        $this->refreshStats();
    }

    public function updatingSearch(): void   { $this->resetPage(); }
    public function updatingFilterRole(): void   { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    // ── Permissions ──────────────────────────────────────────────

    protected function loadPermissions(): void
    {
        // Load from DB / config / cache — here we use a simple settings table
        // fallback to defaults if not set yet
        $stored = \DB::table('settings')
            ->where('key', 'role_permissions')
            ->value('value');

        $this->permissions = $stored
            ? json_decode($stored, true)
            : $this->defaultPermissions;
    }

    public function savePermissions(array $permissions): void
    {
        // Superadmin is always full access — we don't store it
        unset($permissions['superadmin']);

        \DB::table('settings')->updateOrInsert(
            ['key' => 'role_permissions'],
            ['value' => json_encode($permissions), 'updated_at' => now()]
        );

        $this->permissions = $permissions;

        session()->flash('toast', [
            'type'    => 'success',
            'message' => 'Hak akses berhasil disimpan.',
        ]);
    }

    // ── Stats ─────────────────────────────────────────────────────
    protected function refreshStats(): void
    {
        $this->activeCount   = User::where('is_active', true)->count();
        $this->inactiveCount = User::where('is_active', false)->count();
    }

    // ── Query ─────────────────────────────────────────────────────
    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) =>
                $q->where(fn($q) =>
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhere('no_sap', 'like', "%{$this->search}%")
                      ->orWhere('role', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterRole,   fn($q) => $q->where('role', $this->filterRole))
            ->latest()
            ->paginate(10);

        return view('livewire.setting', [
            'users' => $users,
        ]);
    }

    // ── CRUD ──────────────────────────────────────────────────────
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEdit    = false;
        $this->showModal = true;
    }

    public function openEdit(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->form = [
            'name'     => $user->name,
            'email'    => $user->email,
            'no_sap'   => $user->no_sap ?? '',
            'password' => '',
            'role'     => $user->role,
        ];
        $this->editingUserId = $userId;
        $this->isEdit        = true;
        $this->showModal     = true;
    }

    public function openDelete(int $userId, string $userName): void
    {
        $this->deleteTargetId   = $userId;
        $this->deleteTargetName = $userName;
        $this->showDeleteModal  = true;
    }

    public function closeModal(): void
    {
        $this->showModal       = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $rules = [
            'form.name'   => 'required|string|max:255',
            'form.email'  => 'required|email|unique:users,email' . ($this->isEdit ? ",{$this->editingUserId}" : ''),
            'form.no_sap' => 'nullable|string|max:50',
            'form.role'   => 'required|in:superadmin,admin,viewer',
        ];

        if (! $this->isEdit) {
            $rules['form.password'] = ['required', Password::min(8)];
        } else {
            $rules['form.password'] = ['nullable', Password::min(8)];
        }

        $this->validate($rules);

        $data = [
            'name'   => $this->form['name'],
            'email'  => $this->form['email'],
            'no_sap' => $this->form['no_sap'] ?: null,
            'role'   => $this->form['role'],
        ];

        if ($this->form['password']) {
            $data['password'] = Hash::make($this->form['password']);
        }

        if ($this->isEdit) {
            User::findOrFail($this->editingUserId)->update($data);
            $message = 'User berhasil diperbarui.';
        } else {
            User::create($data);
            $message = 'User baru berhasil dibuat.';
        }

        $this->closeModal();
        $this->refreshStats();

        session()->flash('toast', ['type' => 'success', 'message' => $message]);
    }

    public function deleteUser(): void
    {
        User::findOrFail($this->deleteTargetId)->delete();
        $this->closeModal();
        $this->refreshStats();
        session()->flash('toast', ['type' => 'success', 'message' => 'User berhasil dihapus.']);
    }

    // ── Helpers ───────────────────────────────────────────────────
    protected function resetForm(): void
    {
        $this->form          = ['name' => '', 'email' => '', 'no_sap' => '', 'password' => '', 'role' => ''];
        $this->isEdit        = false;
        $this->editingUserId = null;
        $this->resetErrorBag();
    }
}