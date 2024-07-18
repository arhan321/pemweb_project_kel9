<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
  public function run()
    {
        // Menambahkan izin untuk owner full access
        $owner_permissions = Permission::all();
        Role::findOrFail(1)->permissions()->sync($owner_permissions->pluck('id'));

        // Menambahkan izin untuk manager umum full access
        $manager_umum_permissions = Permission::all();
        Role::findOrFail(2)->permissions()->sync($manager_umum_permissions->pluck('id'));

        // Menambahkan izin untuk kasir fnb access & frontend access & history_order
        $kasir_permissions = Permission::where(function ($query) {
            $query->whereBetween('id', [74, 104])
                  ->orWhereBetween('id', [23, 73])
                  ->orWhereBetween('id', [105, 107])
                  ->orWhere('id', 108);
        })->get();
        Role::findOrFail(3)->permissions()->sync($kasir_permissions->pluck('id'));

        // Menambahkan izin untuk waiter fnb access & history_order
        $waiter_permissions = Permission::where(function ($query) {
            $query->whereBetween('id', [74, 104])
                  ->orWhereBetween('id', [105, 107])
                  ->orWhere('id', 108);
        })->get();
        Role::findOrFail(4)->permissions()->sync($waiter_permissions->pluck('id'));

        // Menambahkan izin untuk kepala_cheff fnb access & history_order
        $kepalachef_permissions = Permission::where(function ($query) {
            $query->whereBetween('id', [74, 104])
                  ->orWhereBetween('id', [105, 107])
                  ->orWhere('id', 108);
        })->get();
        Role::findOrFail(5)->permissions()->sync($kepalachef_permissions->pluck('id'));

        // Menambahkan izin untuk bartender fnb access & history_order
        $bartender_permissions = Permission::where(function ($query) {
            $query->whereBetween('id', [74, 104])
                  ->orWhereBetween('id', [105, 107])
                  ->orWhere('id', 108);
        })->get();
        Role::findOrFail(6)->permissions()->sync($bartender_permissions->pluck('id'));
            
    }
}
