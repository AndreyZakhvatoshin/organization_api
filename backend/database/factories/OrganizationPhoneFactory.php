<?php

declare(strict_types=1);

namespace Database\Factories;


use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationPhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone' => $this->generatePhoneNumber(),
            'organization_id' => Organization::factory(),
        ];
    }

    public function forOrganization(Organization $organization): Factory
    {
        return $this->state([
            'organization_id' => $organization->id,
        ]);
    }

    private function generatePhoneNumber(): string
    {
        $formats = [
            '###-##-##',
            '###-###',
            '(###) ###-##-##',
            '+7 (###) ###-##-##',
            '8-###-###-####',
        ];

        return $this->faker->numerify($this->faker->randomElement($formats));
    }
}
