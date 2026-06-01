<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
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

    // ── Form fields (sesuai model User: username, sap, is_active) ─
    public array $form = [
        'username'  => '',
        'sap'       => '',
        'password'  => '',
        'role'      => '',
        'is_active' => '1',
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
            'analisis-kesuburan'   => ['view'],
            'laporan'         => ['view', 'rekap_kesuburan', 'rekomendasi_pemupukan', 'riwayat_pengukuran'],
            'detail-blok'     => ['view', 'rekomendasi'],
            'settings'        => ['view', 'manage_users'],
        ],
        'viewer' => [
            'dashboard'       => ['view'],
            'data-unsur-hara' => ['view'],
            'peta-blok'       => ['view'],
            'analisis-kesuburan'   => ['view'],
            'laporan'         => ['view'],
            'detail-blok'     => ['view'],
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

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterRole(): void
    {
        $this->resetPage();
    }
    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    // ── Permissions ──────────────────────────────────────────────

    protected function loadPermissions(): void
    {
        // Load from settings table, fallback to defaults
        $stored = \DB::table('settings')
            ->where('key', 'role_permissions')
            ->value('value');

        $this->permissions = $stored
            ? json_decode($stored, true)
            : $this->defaultPermissions;
    }

    public function savePermissions(array $permissions): void
    {
        unset($permissions['superadmin']);

        DB::table('settings')->updateOrInsert(
            ['key' => 'role_permissions'],
            ['value' => json_encode($permissions), 'updated_at' => now()]
        );

        cache()->forget('role_permissions'); // ← tambahkan ini

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
            ->when(
                $this->search,
                fn($q) =>
                $q->where(
                    fn($q) =>
                    $q->where('username', 'like', "%{$this->search}%")
                        ->orWhere('sap', 'like', "%{$this->search}%")
                        ->orWhere('role', 'like', "%{$this->search}%")
                )
            )
            ->when($this->filterRole,   fn($q) => $q->where('role', $this->filterRole))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', (bool) $this->filterStatus))
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
            'username'  => $user->username,
            'sap'       => $user->sap ?? '',
            'password'  => '',
            'role'      => $user->role,
            'is_active' => $user->is_active ? '1' : '0',
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
            'form.username'  => 'required|string|max:255',
            'form.sap'       => 'required|string|max:50|unique:users,sap' . ($this->isEdit ? ",{$this->editingUserId}" : ''),
            'form.role'      => 'required|in:superadmin,admin,viewer',
            'form.is_active' => 'required|in:0,1',
        ];

        if (! $this->isEdit) {
            $rules['form.password'] = ['required', Password::min(8)];
        } else {
            $rules['form.password'] = ['nullable', Password::min(8)];
        }

        $this->validate($rules);

        $data = [
            'username'  => $this->form['username'],
            'sap'       => $this->form['sap'],
            'role'      => $this->form['role'],
            'is_active' => (bool) $this->form['is_active'],
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

    public function toggleActive(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update([
            'is_active'      => ! $user->is_active,
            'deactivated_at' => $user->is_active ? now() : null,
        ]);
        $this->refreshStats();
        session()->flash('toast', [
            'type'    => 'success',
            'message' => $user->fresh()->is_active ? 'User berhasil diaktifkan.' : 'User berhasil dinonaktifkan.',
        ]);
    }

    // ── Helpers ───────────────────────────────────────────────────
    protected function resetForm(): void
    {
        $this->form          = ['username' => '', 'sap' => '', 'password' => '', 'role' => '', 'is_active' => '1'];
        $this->isEdit        = false;
        $this->editingUserId = null;
        $this->resetErrorBag();
    }
}
