<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AbUser>
 */
class AbUserFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \App\Models\AbUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'ab_name' => $this->faker->unique()->name(),
            'ab_email' => $this->faker->unique()->safeEmail(),
            'ab_password' => $this->faker->password(),
        ];
    }
}

