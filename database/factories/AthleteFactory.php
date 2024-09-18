<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Athlete>
 */
class AthleteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('123456'),  // Puedes cambiarlo si quieres contraseñas aleatorias
            'country_id' => $this->faker->numberBetween(1, 1),
            'city_id' => $this->faker->numberBetween(1, 10), // Similar a country_id, ajusta según tu necesidad
            'type_document_id' => $this->faker->randomElement([1, 2]), // Puedes agregar más tipos de documentos
            'document' => $this->faker->numerify('########'), // Genera un número aleatorio de 8 dígitos
            'phone' => $this->faker->phoneNumber, // Genera un número de teléfono aleatorio
            'gender' => $this->faker->randomElement(['masculino', 'femenino']), // Elige entre masculino o femenino
            'birthdate' => $this->faker->date('Y-m-d', '2005-12-31'), // Genera una fecha aleatoria de nacimiento antes del 2005
            'belt_id' => $this->faker->numberBetween(1, 5), // Supongamos que tienes 10 tipos de cinturones
        ];
    }
}
