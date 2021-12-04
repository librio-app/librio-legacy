<?php

namespace Database\Seeds;

use App\Models\Auth\Role;
use App\Models\Auth\Permission;
use App\Models\Model;
use Illuminate\Database\Seeder;
use Schema;
use DB;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateLaratrustTables();

        $this->create($this->roles(), $this->map());

        Model::reguard();
    }

    private function roles()
    {
        $rows = [
            'admin' => [
                'admin-panel' => 'r',
                'admin-users' => 'c,r,u,d',
                'admin-roles' => 'c,r,u,d',
                'admin-permissions' => 'c,r,u,d',
                'admin-profile' => 'c,r,u,d',
                'catalog-panel' => 'r',
                'catalog-categories' => 'c,r,u,d',
                'catalog-authors' => 'c,r,u,d',
                'catalog-books' => 'c,r,u,d',
                'catalog-barcodes' => 'c,r,u,d',
                'catalog-publishers' => 'c,r,u,d',
                'catalog-series' => 'c,r,u,d',
                'catalog-themes' => 'c,r,u,d',
                'catalog-types' => 'c,r,u,d',
                'common-notes' => 'c,r,u,d',
                'common-quicksearch' => 'r',
                'administration-panel' => 'r',
                'administration-members' => 'c,r,u,d',
                'administration-subscriptions' => 'c,r,u,d',
                'administration-export' => 'c,r',
                'take-in-panel' => 'r',
                'member-lend' => 'c,r,u,d',
                'member-takein' => 'c,r,u,d',
                'member-reservations' => 'c,r,u,d',
                'member-pay' => 'c,r,u',
                'member-history' => 'c,r,u',
                'statistics-panel' => 'r',
                'statistics-books' => 'r',
            ],
            'manager' => [
                'admin-panel' => 'r',
                'admin-profile' => 'r,u',
                'catalog-panel' => 'r',
                'catalog-categories' => 'c,r,u,d',
                'catalog-authors' => 'c,r,u,d',
                'catalog-books' => 'c,r,u,d',
                'catalog-barcodes' => 'c,r,u,d',
                'catalog-publishers' => 'c,r,u,d',
                'catalog-series' => 'c,r,u,d',
                'catalog-themes' => 'c,r,u,d',
                'common-notes' => 'c,r,u,d',
                'common-quicksearch' => 'r',
                'administration-panel' => 'r',
                'administration-members' => 'c,r,u,d',
                'administration-subscriptions' => 'r,u,d',
                'administration-export' => 'c,r',
                'take-in-panel' => 'r',
                'member-lend' => 'c,r,u,d',
                'member-takein' => 'c,r,u,d',
                'member-reservations' => 'c,r,u,d',
                'member-pay' => 'c,r,u',
                'member-history' => 'c,r,u',
                'statistics-panel' => 'r',
                'statistics-books' => 'r',
            ],
            'user' => [
                'catalog-panel' => 'r',
                'catalog-categories' => 'c,r,u',
                'catalog-authors' => 'c,r,u',
                'catalog-books' => 'c,r,u,d',
                'catalog-barcodes' => 'c',
                'catalog-publishers' => 'c,r,u,d',
                'catalog-series' => 'c,r,u,d',
                'common-notes' => 'c,r,u,d',
                'common-quicksearch' => 'r',
                'administration-panel' => 'r',
                'administration-members' => 'c,r',
                'administration-subscriptions' => 'r',
                'take-in-panel' => 'r',
                'member-lend' => 'c,r,u,d',
                'member-takein' => 'c,r,u,d',
                'member-reservations' => 'c,r,u,d',
                'member-pay' => 'c,r,u',
                'member-history' => 'c,r,u',
                'statistics-panel' => 'r',
            ],
        ];

        return $rows;
    }

    private function map()
    {
        $rows = [
            'c' => 'create',
            'r' => 'read',
            'u' => 'update',
            'd' => 'delete'
        ];

        return $rows;
    }

    private function create($roles, $map)
    {
        $mapPermission = collect($map);

        foreach ($roles as $key => $modules) {
            // Create a new role
            $role = Role::create([
                'name' => $key,
                'display_name' => ucwords(str_replace("_", " ", $key)),
                'description' => ucwords(str_replace("_", " ", $key))
            ]);

            $this->command->info('Creating Role '. strtoupper($key));

            // Reading role permission modules
            foreach ($modules as $module => $value) {
                $permissions = explode(',', $value);

                foreach ($permissions as $p => $perm) {
                    $permissionValue = $mapPermission->get($perm);

                    $moduleName = ucwords(str_replace("-", " ", $module));

                    $permission = Permission::firstOrCreate([
                        'name' => $permissionValue . '-' . $module,
                        'display_name' => ucfirst($permissionValue) . ' ' . $moduleName,
                        'description' => ucfirst($permissionValue) . ' ' . $moduleName,
                    ]);

                    $this->command->info('Creating Permission to '.$permissionValue.' for '. $moduleName);

                    if (!$role->hasPermission($permission->name)) {
                        $role->attachPermission($permission);
                    } else {
                        $this->command->info($key . ': ' . $p . ' ' . $permissionValue . ' already exist');
                    }
                }
            }
        }
    }

    /**
     * Truncates all the laratrust tables and the users table
     *
     * @return  void
     */
    public function truncateLaratrustTables()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('role_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
