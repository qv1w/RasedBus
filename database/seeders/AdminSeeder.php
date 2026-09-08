<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
       
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Admin::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Admin::create([
            'name' => 'جار الله الجار الله',
            'username' => 'lalo',
            'email' => 'jarallahx@gmail.com',
            'password' => Hash::make('jojo123'),
            'role' => 'super_admin',
            'status' => 'active',
        ]);
        Admin::create([
            'name' => '   عمر',
            'username' => 'omar',
            'email' => 'omar@gmail.com',
            'password' => Hash::make('oror123'),
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
