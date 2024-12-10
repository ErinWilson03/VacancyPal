<?php

namespace Database\Seeders;

use App\Enums\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company; 
use App\Models\Vacancy; 


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::ADMIN
        ]);

        User::create([
            'name' => 'Guest',
            'email' => 'guest@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::GUEST
        ]);

        User::create([
            'name' => 'Author',
            'email' => 'company@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR
        ]);        

        // call the already created company seeder, then create vacancies
        $this->call(CompanySeeder::class);
        $this->call(VacancySeeder::class);
    }
}
