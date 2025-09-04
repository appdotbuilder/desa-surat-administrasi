<?php

namespace Database\Factories;

use App\Models\Disposition;
use App\Models\IncomingLetter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Disposition>
 */
class DispositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'incoming_letter_id' => IncomingLetter::factory(),
            'assigned_to' => User::factory(),
            'assigned_by' => User::factory(),
            'instructions' => fake()->paragraph(2),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
            'due_date' => fake()->dateTimeBetween('now', '+30 days'),
            'notes' => fake()->optional()->sentence(),
            'completion_notes' => null,
            'completed_at' => null,
        ];
    }

    /**
     * Indicate that the disposition is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'completion_notes' => null,
            'completed_at' => null,
        ]);
    }

    /**
     * Indicate that the disposition is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completion_notes' => fake()->paragraph(),
            'completed_at' => fake()->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    /**
     * Indicate that the disposition is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'in_progress',
            'due_date' => fake()->dateTimeBetween('-30 days', '-1 day'),
            'completion_notes' => null,
            'completed_at' => null,
        ]);
    }
}