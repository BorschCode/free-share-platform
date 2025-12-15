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
            // Major US Cities - East Coast
            ['name' => 'New York', 'postal_code' => '10001'],
            ['name' => 'Boston', 'postal_code' => '02101'],
            ['name' => 'Philadelphia', 'postal_code' => '19019'],
            ['name' => 'Baltimore', 'postal_code' => '21201'],
            ['name' => 'Washington DC', 'postal_code' => '20001'],
            ['name' => 'Atlanta', 'postal_code' => '30301'],
            ['name' => 'Miami', 'postal_code' => '33101'],
            ['name' => 'Orlando', 'postal_code' => '32801'],
            ['name' => 'Charlotte', 'postal_code' => '28201'],
            ['name' => 'Raleigh', 'postal_code' => '27601'],

            // Midwest
            ['name' => 'Chicago', 'postal_code' => '60601'],
            ['name' => 'Detroit', 'postal_code' => '48201'],
            ['name' => 'Cleveland', 'postal_code' => '44101'],
            ['name' => 'Columbus', 'postal_code' => '43004'],
            ['name' => 'Indianapolis', 'postal_code' => '46201'],
            ['name' => 'Milwaukee', 'postal_code' => '53201'],
            ['name' => 'Minneapolis', 'postal_code' => '55401'],
            ['name' => 'St. Louis', 'postal_code' => '63101'],
            ['name' => 'Kansas City', 'postal_code' => '64101'],

            // South
            ['name' => 'Houston', 'postal_code' => '77001'],
            ['name' => 'Dallas', 'postal_code' => '75201'],
            ['name' => 'Austin', 'postal_code' => '78701'],
            ['name' => 'San Antonio', 'postal_code' => '78201'],
            ['name' => 'Nashville', 'postal_code' => '37201'],
            ['name' => 'Memphis', 'postal_code' => '38101'],
            ['name' => 'New Orleans', 'postal_code' => '70112'],

            // West Coast
            ['name' => 'Los Angeles', 'postal_code' => '90001'],
            ['name' => 'San Francisco', 'postal_code' => '94101'],
            ['name' => 'San Diego', 'postal_code' => '92101'],
            ['name' => 'San Jose', 'postal_code' => '95101'],
            ['name' => 'Seattle', 'postal_code' => '98101'],
            ['name' => 'Portland', 'postal_code' => '97201'],
            ['name' => 'Las Vegas', 'postal_code' => '89101'],

            // Mountain & Southwest
            ['name' => 'Denver', 'postal_code' => '80201'],
            ['name' => 'Phoenix', 'postal_code' => '85001'],
            ['name' => 'Salt Lake City', 'postal_code' => '84101'],
            ['name' => 'Albuquerque', 'postal_code' => '87101'],
            ['name' => 'Tucson', 'postal_code' => '85701'],
        ];

        foreach ($cities as $city) {
            City::firstOrCreate(['name' => $city['name'], 'postal_code' => $city['postal_code']], $city);
        }
    }
}
