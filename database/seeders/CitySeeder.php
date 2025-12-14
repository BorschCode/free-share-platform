<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'New York', 'postal_code' => '10001'],
            ['name' => 'Los Angeles', 'postal_code' => '90001'],
            ['name' => 'Chicago', 'postal_code' => '60601'],
            ['name' => 'Houston', 'postal_code' => '77001'],
            ['name' => 'Phoenix', 'postal_code' => '85001'],
            ['name' => 'Philadelphia', 'postal_code' => '19019'],
            ['name' => 'San Antonio', 'postal_code' => '78201'],
            ['name' => 'San Diego', 'postal_code' => '92101'],
            ['name' => 'Dallas', 'postal_code' => '75201'],
            ['name' => 'San Jose', 'postal_code' => '95101'],
            ['name' => 'Austin', 'postal_code' => '73301'],
            ['name' => 'Jacksonville', 'postal_code' => '32099'],
            ['name' => 'Fort Worth', 'postal_code' => '76101'],
            ['name' => 'Columbus', 'postal_code' => '43004'],
            ['name' => 'Indianapolis', 'postal_code' => '46201'],
            ['name' => 'Charlotte', 'postal_code' => '28201'],
            ['name' => 'San Francisco', 'postal_code' => '94101'],
            ['name' => 'Seattle', 'postal_code' => '98101'],
            ['name' => 'Denver', 'postal_code' => '80201'],
            ['name' => 'Boston', 'postal_code' => '02101'],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['name' => $city['name'], 'postal_code' => $city['postal_code']], $city);
        }
    }
}
