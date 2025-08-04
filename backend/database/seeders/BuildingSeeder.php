<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = [
            [
                'address' => 'г. Москва, Красная площадь, 1',
                'latitude' => 55.7539,
                'longitude' => 37.6208
            ],
            [
                'address' => 'г. Москва, Тверская ул., 13',
                'latitude' => 55.7617,
                'longitude' => 37.6066
            ],
            [
                'address' => 'г. Москва, Ленинский просп., 100',
                'latitude' => 55.6936,
                'longitude' => 37.5333
            ],
            [
                'address' => 'г. Санкт-Петербург, Невский просп., 28',
                'latitude' => 59.9343,
                'longitude' => 30.3351
            ],
            [
                'address' => 'г. Екатеринбург, ул. Белинского, 153',
                'latitude' => 56.8389,
                'longitude' => 60.6057
            ],
            [
                'address' => 'г. Казань, ул. Баумана, 45',
                'latitude' => 55.7907,
                'longitude' => 49.1256
            ],
            [
                'address' => 'г. Новосибирск, Красный просп., 32',
                'latitude' => 55.0282,
                'longitude' => 82.9219
            ],
            [
                'address' => 'г. Ростов-на-Дону, Театральная пл., 50',
                'latitude' => 47.2313,
                'longitude' => 39.7233
            ],
        ];

        foreach ($buildings as $building) {
            Building::query()->create($building);
        }
    }
}
