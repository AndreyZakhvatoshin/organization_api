<?php

declare(strict_types=1);

namespace Database\Factories;


use App\Models\Activity;
use App\Models\Building;
use App\Models\OrganizationPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'building_id' => Building::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($organization) {
            // Добавляем телефоны
            OrganizationPhone::factory()
                ->count($this->faker->numberBetween(1, 3))
                ->forOrganization($organization)
                ->create();
        });
    }

    public function withActivities($count = 2): Factory
    {
        return $this->afterCreating(function ($organization) use ($count) {
            $activities = Activity::inRandomOrder()
                ->take($count)
                ->get();

            $organization->activities()->attach($activities);
        });
    }
}
