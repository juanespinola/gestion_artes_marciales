<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MediaNew>
 */
class MediaNewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generar una imagen falsa en la carpeta 'public/news'
        $imagePath = storage_path('app/public/news/');
        $image = $this->faker->image($imagePath, 640, 480, null, false); // Crea una imagen falsa de 640x480

        return [
            'name_file' => 'public/news/' . $image, // Almacenar la ruta relativa en el sistema de archivos
            'route_file' => url('storage/news/' . $image), // Ruta pública para acceder a la imagen
            'type' => $this->faker->randomElement(['banner_new_list', 'banner_new_detail']), // Tipo de imagen
            'new_id' => $this->faker->numberBetween(1, 10), // ID de la noticia, puede ser aleatorio o relacionado
        ];
    }

      /**
     * Método personalizado para crear dos tipos de imágenes por cada new_id.
     */
    public function withBothImageTypes($newId)
    {
        return $this->state(function (array $attributes) use ($newId) {
            return [
                'new_id' => $newId,
                'type' => 'banner_new_list',
            ];
        })->create() && $this->state(function (array $attributes) use ($newId) {
            return [
                'new_id' => $newId,
                'type' => 'banner_new_detail',
            ];
        })->create();
    }
}
