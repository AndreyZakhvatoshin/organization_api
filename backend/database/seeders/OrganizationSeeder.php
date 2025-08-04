<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\OrganizationPhone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildingIds = DB::table('buildings')->pluck('id')->toArray();
        $activityIds = DB::table('activities')->pluck('id')->toArray();

        if (empty($activityIds)) {
            throw new \Exception('No activities found. Run ActivitySeeder first!');
        }

        $organizationsData = [
            [
                'name' => 'ООО "Рога и Копыта"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-923-666-13-13', '8-495-123-45-67'],
                'activities' => [1, 2] // Еда, Мясная продукция
            ],
            [
                'name' => 'ЗАО "Молочный комбинат"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-800-555-35-35', '8-499-999-88-77', '8-499-111-22-33'],
                'activities' => [1, 3] // Еда, Молочная продукция
            ],
            [
                'name' => 'ИП "Автосервис"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-495-555-55-55'],
                'activities' => [4, 5] // Автомобили, Грузовые
            ],
            [
                'name' => 'ООО "Грузоперевозки"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-800-200-30-40', '8-495-777-88-99'],
                'activities' => [4, 6] // Автомобили, Легковые
            ],
            [
                'name' => 'ИП "Мясной дворик"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-916-111-22-33', '8-916-444-55-66'],
                'activities' => [2] // Мясная продукция
            ],
            [
                'name' => 'ООО "Сырный рай"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-495-333-44-55', '8-495-666-77-88'],
                'activities' => [3] // Молочная продукция
            ],
            [
                'name' => 'Автосалон "Люкс"',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-800-777-88-99'],
                'activities' => [4, 7, 8] // Автомобили, Легковые, Запчасти
            ],
            [
                'name' => 'Магазин автозапчастей',
                'building_id' => $buildingIds[array_rand($buildingIds)],
                'phones' => ['8-495-222-33-44', '8-495-555-66-77'],
                'activities' => [8] // Запчасти
            ],
        ];

        foreach ($organizationsData as $data) {
            // Создаем организацию
            $organization = Organization::create([
                'name' => $data['name'],
                'building_id' => $data['building_id']
            ]);

            // Добавляем телефоны
            foreach ($data['phones'] as $phone) {
                OrganizationPhone::create([
                    'organization_id' => $organization->id,
                    'phone' => $phone
                ]);
            }

            // Привязываем виды деятельности
            $organization->activities()->attach($data['activities']);
        }
    }
}
