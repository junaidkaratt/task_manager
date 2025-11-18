<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Task::class;
    public function definition(): array
    {
        $statuses = ['pending', 'completed'];
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement($statuses),
            'user_id' => User::factory(),
        ];
    }
}
