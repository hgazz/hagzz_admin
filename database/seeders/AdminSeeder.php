<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'first_name' => 'Mohamed',
            'last_name' => 'Aly',
            'email' => 'admin@admin.com',
            'password' => bcrypt(123456),
            'phone' => '01144166700'
        ]);
    }
}
