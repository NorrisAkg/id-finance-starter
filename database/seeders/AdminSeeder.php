<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstname' => 'Juste',
            'lastname' => 'Demonde',
            'email' => 'contact@idealepatrimoine.com',
            'country_id' => Country::where('name', 'United States')->first()->id,
            'city' => 'New York',
            'postal_code' => '10001',
            'address' => '1 Avenue of the Americas, New York, NY 10001',
            'telephone' => '+1 302-781-5239',
            'piece_number' => '12345',
            'identifiant' => '12345',
            'password' => Hash::make('Groupede3@26'),
            'piece_number' => '12345',
            'client_code' => '12345',
            'is_admin' => true,
            'balance' => 0,
        ]);
    }
}
