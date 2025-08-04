<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $food = Activity::query()->create(['name' => 'Еда']);
        $meat = Activity::query()->create(['name' => 'Мясная продукция', 'parent_id' => $food->id]);
        $dairy = Activity::query()->create(['name' => 'Молочная продукция', 'parent_id' => $food->id]);

        $cars = Activity::query()->create(['name' => 'Автомобили']);
        $trucks = Activity::query()->create(['name' => 'Грузовые', 'parent_id' => $cars->id]);
        $cars_light = Activity::query()->create(['name' => 'Легковые', 'parent_id' => $cars->id]);
        Activity::query()->create(['name' => 'Запчасти', 'parent_id' => $cars_light->id]);
        Activity::query()->create(['name' => 'Аксессуары', 'parent_id' => $cars_light->id]);
    }
}
