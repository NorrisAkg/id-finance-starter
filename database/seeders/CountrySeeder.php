<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Afghanistan', 'code' => 'AF', 'flag' => '🇦🇫'],
            ['name' => 'Albania', 'code' => 'AL', 'flag' => '🇦🇱'],
            ['name' => 'Algeria', 'code' => 'DZ', 'flag' => '🇩🇿'],
            ['name' => 'Andorra', 'code' => 'AD', 'flag' => '🇦🇩'],
            ['name' => 'Angola', 'code' => 'AO', 'flag' => '🇦🇴'],
            ['name' => 'Argentina', 'code' => 'AR', 'flag' => '🇦🇷'],
            ['name' => 'Armenia', 'code' => 'AM', 'flag' => '🇦🇲'],
            ['name' => 'Australia', 'code' => 'AU', 'flag' => '🇦🇺'],
            ['name' => 'Austria', 'code' => 'AT', 'flag' => '🇦🇹'],
            ['name' => 'Azerbaijan', 'code' => 'AZ', 'flag' => '🇦🇿'],
            ['name' => 'Bahamas', 'code' => 'BS', 'flag' => '🇧🇸'],
            ['name' => 'Bahrain', 'code' => 'BH', 'flag' => '🇧🇭'],
            ['name' => 'Bangladesh', 'code' => 'BD', 'flag' => '🇧🇩'],
            ['name' => 'Belgium', 'code' => 'BE', 'flag' => '🇧🇪'],
            ['name' => 'Benin', 'code' => 'BJ', 'flag' => '🇧🇯'],
            ['name' => 'Brazil', 'code' => 'BR', 'flag' => '🇧🇷'],
            ['name' => 'Burkina Faso', 'code' => 'BF', 'flag' => '🇧🇫'],
            ['name' => 'Cameroon', 'code' => 'CM', 'flag' => '🇨🇲'],
            ['name' => 'Canada', 'code' => 'CA', 'flag' => '🇨🇦'],
            ['name' => 'China', 'code' => 'CN', 'flag' => '🇨🇳'],
            ['name' => 'Côte d\'Ivoire', 'code' => 'CI', 'flag' => '🇨🇮'],
            ['name' => 'Denmark', 'code' => 'DK', 'flag' => '🇩🇰'],
            ['name' => 'Egypt', 'code' => 'EG', 'flag' => '🇪🇬'],
            ['name' => 'France', 'code' => 'FR', 'flag' => '🇫🇷'],
            ['name' => 'Germany', 'code' => 'DE', 'flag' => '🇩🇪'],
            ['name' => 'Ghana', 'code' => 'GH', 'flag' => '🇬🇭'],
            ['name' => 'India', 'code' => 'IN', 'flag' => '🇮🇳'],
            ['name' => 'Italy', 'code' => 'IT', 'flag' => '🇮🇹'],
            ['name' => 'Japan', 'code' => 'JP', 'flag' => '🇯🇵'],
            ['name' => 'Kenya', 'code' => 'KE', 'flag' => '🇰🇪'],
            ['name' => 'Mexico', 'code' => 'MX', 'flag' => '🇲🇽'],
            ['name' => 'Nigeria', 'code' => 'NG', 'flag' => '🇳🇬'],
            ['name' => 'Russia', 'code' => 'RU', 'flag' => '🇷🇺'],
            ['name' => 'South Africa', 'code' => 'ZA', 'flag' => '🇿🇦'],
            ['name' => 'Spain', 'code' => 'ES', 'flag' => '🇪🇸'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'flag' => '🇬🇧'],
            ['name' => 'United States', 'code' => 'US', 'flag' => '🇺🇸'],
        ];

        if (DB::table('countries')->count() > 0) {
            return;
        }
        DB::table('countries')->insert($countries);
    }
}
