<?php

namespace Database\Factories;
use App\Models\Division;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'image' => $this->faker->imageUrl(),
            'phone' => $this->faker->unique()->phoneNumber,
            'name' => $this->faker->name,
            'division_id' => Division::inRandomOrder()->first()->id,
            'position' => $this->faker->jobTitle,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
