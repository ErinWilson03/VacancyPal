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
            'name' => 'AccountHolder',
            'email' => 'holder@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::ACCOUNT_HOLDER
        ]);  

        User::create([
            'name' => 'Guest',
            'email' => 'guest@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::GUEST
        ]);

        User::create([
            'name' => 'Author',
            'email' => 'author@mail.com',
            'password' => Hash::make('password'),
            'role' => Role::AUTHOR
        ]);        

        // call the already created company seeder, then create vacancies
        $this->call(CompanySeeder::class);
        $this->call(VacancySeeder::class);
        // create some more random companies and vacancies
        Company::factory(5)->create();
        Vacancy::factory(10)->create();

    }
}
