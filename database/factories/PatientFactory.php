<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'emergency_contact' => $this->faker->phoneNumber(),
            'matrimonial_situation' => $this->faker->randomElement(['Célibataire', 'Marié', 'Divorcé', 'Veuf']),
            'place_of_birth' => $this->faker->city(),
            'age' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
