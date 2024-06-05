<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create roles
        $admin = Role::create(['name' => 'admin']);
        $csr = Role::create(['name' => 'csr']);
        $teller = Role::create(['name' => 'teller']);

        // create permissions
        $adminModule = Permission::create(['name' => 'admin module']);
        $csrModule = Permission::create(['name' => 'csr module']);
        $csrJobOrders = Permission::create(['name' => 'job orders']);
        $tellerModule = Permission::create(['name' => 'teller module']);

        // assign permissions to role
        $admin->givePermissionTo($adminModule);
        $csr->givePermissionTo([$csrModule, $csrJobOrders]);
        $teller->givePermissionTo($tellerModule);

        // assign role to user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@sample.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('test1234')
        ]);
        $adminUser->assignRole($admin);

        $csrUser = User::create([
            'name' => 'CSR User',
            'email' => 'csr@sample.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('test1234')
        ]);
        $csrUser->assignRole($csr);

        $tellerUser = User::create([
            'name' => 'Teller User',
            'email' => 'teller@sample.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('test1234')
        ]);
        $tellerUser->assignRole($teller);
    }
}
