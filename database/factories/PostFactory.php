<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'community_id'=>rand(1,50),
            'author_id'=>rand(1,100),
            'title'=>$this->faker->text(20),
            'post_text'=>$this->faker->text(50),

        ];
    }
}
