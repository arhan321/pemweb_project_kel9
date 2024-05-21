<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
    
        $user_permissions = $admin_permissions->filter(function ($permission) {
            return substr($permission->title, 0, 5) != 'user_' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($user_permissions);
    
        // Menambahkan izin untuk manager_umum
        $manager_permissions = $admin_permissions->filter(function ($permission) {
            $allowed_permissions = [
                 58,59,60,61,62,63,
                //bisa pake name nya atau id nya 
                // 'fn_b_access',
                // 'dapur_create',
                // 'dapur_access',
                // 'dapur_delete',
                // 'dapur_edit',
                // 'dapur_show',
            ];
        
            // return in_array($permission->title, $allowed_permissions); //jika ingin menggunakan nama nya bisa pake ini 
            //tapi jika ingin pake id bisa pake ini : 
            return in_array($permission->id, $allowed_permissions);
        });
        Role::findOrFail(3)->permissions()->sync($manager_permissions);
    }
}
