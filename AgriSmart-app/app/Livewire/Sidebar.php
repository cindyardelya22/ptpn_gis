<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Sidebar extends Component
{
    public function render()
    {
        $user = Auth::user();

        $menus = [
            ['id' => 'dashboard',   'label' => 'Dashboard',         'route' => 'dashboard',   'icon' => 'M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z', 'pageKey' => 'dashboard'],
            ['id' => 'unsur-hara',  'label' => 'Data Unsur Hara',   'route' => 'unsur-hara',  'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'pageKey' => 'data-unsur-hara'],
            ['id' => 'peta-blok',   'label' => 'Peta Blok Kebun',   'route' => 'peta-blok',   'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7l5-2.5 5.553 2.776a1 1 0 01.447.894v10.764a1 1 0 01-1.447.894L15 17l-6 3z', 'pageKey' => 'peta-blok'],
            ['id' => 'analytics',   'label' => 'Analisis Kesuburan', 'route' => 'analytics',   'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'pageKey' => 'analisis-kesuburan'],
            ['id' => 'laporan',     'label' => 'Laporan',           'route' => 'reports',     'icon' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z', 'pageKey' => 'laporan'],
            ['id' => 'setting',     'label' => 'Setting',           'route' => 'setting',     'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'pageKey' => 'settings'],
        ];

        if ($user && $user->role !== 'superadmin') {
            $defaultPermissions = [
                'admin' => [
                    'dashboard'            => ['view'],
                    'data-unsur-hara'      => ['view', 'create', 'edit', 'delete'],
                    'peta-blok'            => ['view'],
                    'analisis-kesuburan'   => ['view'],
                    'laporan'              => ['view', 'download_pdf', 'download_excel'],
                    'settings'             => ['view', 'manage_users'],
                ],
                'viewer' => [
                    'dashboard'            => ['view'],
                    'data-unsur-hara'      => ['view'],
                    'peta-blok'            => ['view'],
                    'analisis-kesuburan'   => ['view'],
                    'laporan'              => ['view'],
                    'settings'             => [],
                ],
            ];

            $stored = cache()->remember('role_permissions', now()->addMinutes(10), function () {
                return DB::table('settings')->where('key', 'role_permissions')->value('value');
            });
            $permissions = $stored ? json_decode($stored, true) : $defaultPermissions;
            $rolePerms = $permissions[$user->role] ?? [];

            $menus = array_values(array_filter($menus, function ($menu) use ($rolePerms) {
                return in_array('view', $rolePerms[$menu['pageKey']] ?? []);
            }));
        }

        return view('livewire.sidebar', [
            'menus' => $menus
        ]);
    }
}
