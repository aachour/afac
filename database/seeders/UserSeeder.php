<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=[
            //['admin','admin','admin','admin','admin@afac.com'],//Super Admin
            ['admin','fsuser','fsuser','fsuser','fsuser@afac.com'],//FS User
        ];

        foreach($users as $u){
            $user = User::create([
                'username' => $u[1],
                'first_name' => $u[2],
                'last_name' => $u[3],
                'email' => $u[4],
                'phone' => '000',
                'password' => Hash::make('fusionsecond0831'),
            ]);
            $user->assignRole($u[0]);
        }
    }
}
