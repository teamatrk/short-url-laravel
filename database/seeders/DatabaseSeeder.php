<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $roles = [1 => 'SUPER_ADMIN' , 2 => 'ADMIN' , 3 => 'MEMBER'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['role' => $role]);
        }

        // $company = Company::firstOrCreate(['name' => 'Alphabet']); 
        Company::factory(50)->create(); // Creating set of 50 companies

        $email = 'superadmin@email.com';
        $password = 'password';
        $now = now()->toDateTimeString();
        $hashedPassword = Hash::make($password);

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => $email,
            //'company_id' => $company->id,
            'role_id' => 1,
            'password' => $hashedPassword,
        ]);
        // $userId = DB::table('users')->where('email', $email)->value('id');
        // $roleId = DB::table('roles')->where('role', 'SUPER_ADMIN')->value('id');



    }
}
