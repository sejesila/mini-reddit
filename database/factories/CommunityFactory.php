<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class CommunityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->text(20);
        return [
            'name'=>$name,
            'user_id'=>rand(1,100),
            'description'=>$this->faker->text(50),
            'slug'=>Str::slug($name)
        ];
    }
}
