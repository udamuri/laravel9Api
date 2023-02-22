<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayData = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make("12345678"),
                'role' => "admin"
            ],
			[
                'name' => 'Kurir',
                'email' => 'kurir@gmail.com',
                'password' => Hash::make("12345678"),
                'role' => "kurir"
            ],
            [
                'name' => 'dinola',
                'email' => 'dinola@gmail.com',
                'password' => Hash::make("12345678"),
                'role' => "user"
            ],
        ];
        
        foreach($arrayData as $key => $value) {
			User::create($value);
        }
    }
}
