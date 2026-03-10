function app() {
    const gradients = ['#818cf8,#a78bfa', '#f472b6,#fb7185', '#34d399,#10b981', '#fb923c,#f59e0b', '#22d3ee,#0891b2'];
    const today = new Date();
    const fmt = d => d.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'short',
        year: 'numeric'
    });

    return {
        // ── Data ──────────────────────────────────────────
        users: [{
            id: 1,
            name: 'ver ad',
            email: 'andi@mail.com',
            role: 'admin',
            active: true,
            date: '01 Jan 2025'
        },
        {
            id: 2,
            name: 'Budi Santoso',
            email: 'budi@mail.com',
            role: 'manager',
            active: true,
            date: '15 Feb 2025'
        },
        {
            id: 3,
            name: 'Citra Dewi',
            email: 'citra@mail.com',
            role: 'user',
            active: false,
            date: '03 Mar 2025'
        },
        {
            id: 4,
            name: 'Dian Pratama',
            email: 'dian@mail.com',
            role: 'manager',
            active: true,
            date: '20 Mar 2025'
        },
        {
            id: 5,
            name: 'Eka Wulandari',
            email: 'eka@mail.com',
            role: 'user',
            active: true,
            date: '05 Apr 2025'
        },
        {
            id: 6,
            name: 'Fajar Nugroho',
            email: 'fajar@mail.com',
            role: 'user',
            active: false,
            date: '12 Apr 2025'
        },
        {
            id: 7,
            name: 'Gita Rahayu',
            email: 'gita@mail.com',
            role: 'admin',
            active: true,
            date: '28 Apr 2025'
        },
        {
            id: 8,
            name: 'Hendra Kusuma',
            email: 'hendra@mail.com',
            role: 'user',
            active: true,
            date: '10 May 2025'
        },
        {
            id: 9,
            name: 'Indah Permata',
            email: 'indah@mail.com',
            role: 'manager',
            active: true,
            date: '22 May 2025'
        },
        {
            id: 10,
            'name': 'Joko Widodo',
            email: 'joko@mail.com',
            role: 'user',
            active: false,
            date: '01 Jun 2025'
        },
        {
            id: 11,
            name: 'Kartika Sari',
            email: 'kartika@mail.com',
            role: 'user',
            active: true,
            date: '14 Jun 2025'
        },
        {
            id: 12,
            name: 'Lukman Hakim',
            email: 'lukman@mail.com',
            role: 'manager',
            active: true,
            date: '25 Jun 2025'
        },
        ],
        // ── State ──────────────────────────────────────────
        search: '',
        filterRole: '',
        filterStatus: '',
        sortField: '',
        sortDir: 'asc',
        page: 1,
        perPage: 5,
        showModal: false,
        showDeleteModal: false,
        editMode: false,
        editId: null,
        deleteTarget: null,
        saving: false,
        toast: null,
        form: {
            name: '',
            email: '',
            password: '',
            role: 'user',
            active: true
        },
        errors: {},
        nextId: 13,

        // ── Computed ───────────────────────────────────────

        get filteredUsers() {
            let list = [...this.users];
            if (this.search) {
                const q = this.search.toLowerCase();
                list = list.filter(u => u.name.toLowerCase().includes(q) || u.email.toLowerCase().includes(q) || u.role.includes(q));
            }
            if (this.filterRole) list = list.filter(u => u.role === this.filterRole);
            if (this.filterStatus) list = list.filter(u => this.filterStatus === 'active' ? u.active : !u.active);
            if (this.sortField === 'name') list.sort((a, b) => this.sortDir === 'asc' ? a.name.localeCompare(b.name) : b.name.localeCompare(a.name));
            if (this.sortField === 'date') list.sort((a, b) => this.sortDir === 'asc' ? a.id - b.id : b.id - a.id);
            return list;
        },
        get paginatedUsers() {
            const s = (this.page - 1) * this.perPage;
            return this.filteredUsers.slice(s, s + this.perPage);
        },
        get totalPages() {
            return Math.max(1, Math.ceil(this.filteredUsers.length / this.perPage));
        },

        // ── Helpers ────────────────────────────────────────
        avatarGradient(i) {
            return gradients[i % gradients.length];
        },
        roleStyle(role) {
            return {
                admin: 'background:rgba(244,114,182,.15);color:#f472b6;border:1px solid rgba(244,114,182,.3)',
                manager: 'background:rgba(129,140,248,.15);color:#818cf8;border:1px solid rgba(129,140,248,.3)',
                user: 'background:rgba(99,102,241,.10);color:#a5b4fc;border:1px solid rgba(99,102,241,.2)',
            }[role] || '';
        },
        toggleSort(f) {
            if (this.sortField === f) this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
            else {
                this.sortField = f;
                this.sortDir = 'asc';
            }
        },
        showToast(msg, type = 'success') {
            this.toast = {
                message: msg,
                type
            };
            setTimeout(() => this.toast = null, 3000);
        },

        // ── CRUD ──────────────────────────────────────────
        openCreate() {
            this.form = {
                name: '',
                email: '',
                password: '',
                role: 'user',
                active: true
            };
            this.errors = {};
            this.editMode = false;
            this.editId = null;
            this.showModal = true;
        },
        openEdit(user) {
            this.form = {
                name: user.name,
                email: user.email,
                password: '',
                role: user.role,
                active: user.active
            };
            this.errors = {};
            this.editMode = true;
            this.editId = user.id;
            this.showModal = true;
        },
        confirmDelete(user) {
            this.deleteTarget = user;
            this.showDeleteModal = true;
        },
        closeModal() {
            this.showModal = false;
            this.showDeleteModal = false;
            this.errors = {};
        },
        toggleStatus(user) {
            user.active = !user.active;
            this.showToast(`Status ${user.name} diperbarui.`);
        },

        validate() {
            const e = {};
            if (!this.form.name.trim()) e.name = 'Nama wajib diisi.';
            if (!this.form.email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) e.email = 'Format email tidak valid.';
            if (!this.editMode && this.form.password.length < 8) e.password = 'Password minimal 8 karakter.';
            if (this.form.password && this.form.password.length < 8) e.password = 'Password minimal 8 karakter.';
            if (!this.form.role) e.role = 'Role wajib dipilih.';
            // email uniqueness
            const dup = this.users.find(u => u.email === this.form.email && u.id !== this.editId);
            if (dup) e.email = 'Email sudah digunakan.';
            this.errors = e;
            return Object.keys(e).length === 0;
        },

        save() {
            if (!this.validate()) return;
            this.saving = true;
            setTimeout(() => {
                if (this.editMode) {
                    const u = this.users.find(u => u.id === this.editId);
                    if (u) {
                        u.name = this.form.name;
                        u.email = this.form.email;
                        u.role = this.form.role;
                        u.active = this.form.active;
                    }
                    this.showToast('User berhasil diperbarui!');
                } else {
                    this.users.push({
                        id: this.nextId++,
                        name: this.form.name,
                        email: this.form.email,
                        role: this.form.role,
                        active: this.form.active,
                        date: fmt(today)
                    });
                    this.showToast('User baru berhasil ditambahkan!');
                }
                this.saving = false;
                this.closeModal();
            }, 700);
        },

        deleteUser() {
            this.users = this.users.filter(u => u.id !== this.deleteTarget.id);
            this.showToast(`${this.deleteTarget.name} berhasil dihapus.`, 'error');
            this.closeModal();
            if (this.page > this.totalPages) this.page = this.totalPages;
        },
    }
}