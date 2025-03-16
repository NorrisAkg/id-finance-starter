<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'firstname' => 'Juste',
        //     'lastname' => 'Demonde',
        //     'email' => 'contact@idealepatrimoine.com',
        //     'country_id' => Country::where('name', 'United States')->first()->id,
        //     'city' => 'New York',
        //     'postal_code' => '10001',
        //     'address' => '1 Avenue of the Americas, New York, NY 10001',
        //     'telephone' => '+1 302-781-5239',
        //     'piece_number' => '12345',
        //     'identifiant' => '12345',
        //     'password' => Hash::make('Admin@ideale25'),
        //     'piece_number' => '12345',
        //     'client_code' => '12345',

        // ]);

        $this->call([
            CountrySeeder::class,
            AdminSeeder::class,
            // UserSeeder::class
        ]);
    }
}
