<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(3), // Genera una descripción aleatoria
            'location_id' => $this->faker->numberBetween(1, 2), // Genera un ID de localización aleatorio
            'initial_date' => Carbon::now(), // Fecha aleatoria hasta finales de 2024
            'initial_time' => Carbon::now()->toTimeString(), // Hora actual
            'type_event_id' => $this->faker->numberBetween(1, 3), // Genera un tipo de evento aleatorio
            'status_event_id' => $this->faker->numberBetween(1, 1), // Genera un estado aleatorio
            'inscription_fee' => $this->faker->numberBetween(0, 0), // Cuota de inscripción entre 0 y 500
            'available_slots' => $this->faker->numberBetween(10, 30), // Espacios disponibles entre 10 y 200
            'created_user_id' => $this->faker->numberBetween(3, 4), // ID del usuario que creó el evento
            'federation_id' => 1, // ID de federación aleatorio
            'quantity_quadrilateral' => $this->faker->numberBetween(1, 4), // Cantidad de cuadriláteros entre 1 y 4
            'content' => $this->faker->text()
        ];
    }   
}
