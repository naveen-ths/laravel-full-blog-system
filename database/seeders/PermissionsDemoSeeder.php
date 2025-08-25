<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder {

  public function run(): void
  {
      // Reset cached roles and permissions
      app()[PermissionRegistrar::class]->forgetCachedPermissions();

      // Create roles
      $superAdminRole = Role::create(['name' => 'superadmin']);
      $adminRole = Role::create(['name' => 'admin']);
      $writerRole = Role::create(['name' => 'writer']);

      // Create permissions
      $permissions = [
          'publish articles',
          'edit articles',
          'delete articles',
          'create articles',
          'unpublish articles',
      ];

      foreach ($permissions as $permission) {
          Permission::create(['name' => $permission]);
      }

      // Assign permissions to roles
      $writerRole->givePermissionTo(['delete articles', 'edit articles', 'create articles']);
      $adminRole->givePermissionTo(['publish articles', 'unpublish articles']);
      $superAdminRole->givePermissionTo(Permission::all());

      // create demo users
        $user = \App\Models\User::factory()->create([
            'name' => 'Example User',
            'email' => 'tester@example.com',
        ]);
        $user->assignRole($writerRole);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($adminRole);

        $user = \App\Models\User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $user->assignRole($superAdminRole);
  }
}