<?php

namespace Database\Factories;

use App\Models\ReadingList;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReadingListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReadingList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->catchPhrase,
        ];
    }
}
