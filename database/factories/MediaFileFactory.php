<?php

namespace Database\Factories;

use App\Models\MediaFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MediaFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'file_name' => $this->faker->word,
        'file_path' => $this->faker->word,
        'file_resize_200' => $this->faker->word,
        'file_resize_250' => $this->faker->word,
        'file_resize_400' => $this->faker->word,
        'file_size' => $this->faker->word,
        'file_type' => $this->faker->word,
        'file_extension' => $this->faker->word,
        'create_user' => $this->faker->randomDigitNotNull,
        'update_user' => $this->faker->randomDigitNotNull,
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'app_id' => $this->faker->randomDigitNotNull,
        'app_user_id' => $this->faker->randomDigitNotNull,
        'file_width' => $this->faker->randomDigitNotNull,
        'file_height' => $this->faker->randomDigitNotNull,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
