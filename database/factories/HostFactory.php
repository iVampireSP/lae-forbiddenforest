<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'user_id' => $this->faker->randomNumber(),
            'host_id' => $this->faker->randomNumber(),
            'price' => $this->faker->randomFloat(),
            'managed_price' => $this->faker->randomFloat(),
            'configuration' => $this->faker->words(),
            'status' => $this->faker->word(),
            'suspended_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
