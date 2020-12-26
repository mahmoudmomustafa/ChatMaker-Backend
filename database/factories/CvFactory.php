<?php

namespace Database\Factories;

use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cv::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'number' => $this->faker->phoneNumber,
            'location' => $this->faker->country,
            'title' => $this->faker->title,
            'summary' => $this->faker->paragraph,
            'website' => $this->faker->url,
            'website2' => $this->faker->url,
        ];
    }
}
