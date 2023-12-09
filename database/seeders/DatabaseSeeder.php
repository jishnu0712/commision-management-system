<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'mobile' => '7407602125',
            'type' => 'admin',
            'password' => bcrypt('admin'),
            'permissions' => '["dashboard_view","users_view","users_add","users_edit","department_view","department_add","department_edit","doctor_view","doctor_add","doctor_edit","tranaction_view","tranaction_add"]'
        ]);
    }
}
