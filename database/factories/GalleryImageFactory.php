<?php

namespace Database\Factories;

use App\Models\GalleryImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GalleryImage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'imageUrl' => $this->faker->imageUrl(640, 480, 'cats'),
            'gallery_id' => $this->faker->numberBetween(1, 20),
        ];
    }
}
