<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\New>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'torneos' => 1,
            'charlas' => 2,
            'avisos' => 3,
            'otros' => 4
        ];

        return [
            'title' => $this->faker->sentence(3), // Genera un título aleatorio
            'content' => $this->faker->paragraph, // Genera un contenido aleatorio
            'created_user_id' => 3, // id 3 es el de federation@gmail.com
            'federation_id' => 1, // Genera un ID de federación aleatorio
            'new_category_id' => $this->faker->randomElement(array_values($categories)), // Selecciona aleatoriamente el ID de categoría
        ];
    }
}
