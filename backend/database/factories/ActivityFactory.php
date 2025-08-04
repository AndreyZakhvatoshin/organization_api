<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'parent_id' => null,
            'depth' => 1,
        ];
    }

    public function withParent(?Activity $parent = null): Factory
    {
        return $this->state(function (array $attributes) use ($parent) {
            $parent = $parent ?? Activity::factory()->create();

            // Проверка вложенности
            if ($parent->depth >= 3) {
                throw new \Exception('Максимальная вложенность - 3 уровня');
            }

            return [
                'parent_id' => $parent->id,
                'depth' => $parent->depth + 1,
            ];
        });
    }

    public function child(): Factory
    {
        return $this->withParent();
    }

    public function grandchild(): Factory
    {
        return $this->withParent(
            Activity::factory()->child()->create()
        );
    }
}
