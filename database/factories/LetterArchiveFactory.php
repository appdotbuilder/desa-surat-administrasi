<?php

namespace Database\Factories;

use App\Models\LetterArchive;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterArchive>
 */
class LetterArchiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $letterType = fake()->randomElement(['incoming', 'outgoing']);
        
        return [
            'letter_type' => $letterType,
            'letter_id' => random_int(1, 100),
            'archive_number' => 'ARS-' . fake()->year() . '-' . fake()->unique()->numberBetween(1000, 9999),
            'category' => fake()->randomElement(['Surat Keterangan', 'Surat Pengantar', 'Surat Undangan', 'Surat Pemberitahuan']),
            'archive_notes' => fake()->optional()->sentence(),
            'archived_by' => User::factory(),
            'archived_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Indicate that this is an incoming letter archive.
     */
    public function incoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'letter_type' => 'incoming',
        ]);
    }

    /**
     * Indicate that this is an outgoing letter archive.
     */
    public function outgoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'letter_type' => 'outgoing',
        ]);
    }
}