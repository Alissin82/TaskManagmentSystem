<?php

namespace Database\Factories;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->text(100),
            'due_date' => $this->faker->optional()->randomElement([
                fake()->dateTimeBetween('now', '+1 week')->format('Y-m-d H:i:s'),
                fake()->dateTimeBetween('now', '+1 week')->format('Y-m-d'),
            ]),
            'priority' => $this->faker->randomElement(TaskPriority::values()),
            'status' => $this->faker->randomElement(TaskStatus::values()),
        ];
    }
}
