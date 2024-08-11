<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('users')->insert([
            'username' => 'admin',
            'name' => 'Aksa Media',
            'phone' => '081234567890',
            'email' => 'aksamedia@gmail.com',     
            'password' => Hash::make('pastibisa'),
        ]);

        DB::table('divisions')->insert([
            ['id' => Str::uuid(), 'name' => 'Mobile Apps'],
            ['id' => Str::uuid(), 'name' => 'QR'],
            ['id' => Str::uuid(), 'name' => 'Full Stack'],
            ['id' => Str::uuid(), 'name' => 'Backend'],
            ['id' => Str::uuid(), 'name' => 'Frontend'],
            ['id' => Str::uuid(), 'name' => 'UI/UX Designer'],
        ]);

        //call the EmployeeFactory
        \App\Models\Employee::factory(50)->create();
    }
}
