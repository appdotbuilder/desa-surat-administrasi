<?php

namespace Database\Factories;

use App\Models\IncomingLetter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncomingLetter>
 */
class IncomingLetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'letter_number' => 'SM-' . fake()->year() . '-' . fake()->unique()->numberBetween(1000, 9999),
            'sender' => fake()->company(),
            'subject' => fake()->sentence(6),
            'letter_date' => fake()->dateTimeBetween('-6 months', '-1 day'),
            'received_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'status' => fake()->randomElement(['new', 'processed', 'disposed', 'archived']),
            'description' => fake()->paragraph(3),
            'file_path' => null,
            'notes' => fake()->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the letter is high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => 'high',
        ]);
    }

    /**
     * Indicate that the letter is new status.
     */
    public function newStatus(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
        ]);
    }

    /**
     * Indicate that the letter needs disposition.
     */
    public function needsDisposition(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processed',
            'priority' => 'high',
        ]);
    }
}