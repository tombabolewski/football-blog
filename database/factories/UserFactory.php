<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Support\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public const PASSWORD = 'youshallnotpass';

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::PASSWORD,
            'remember_token' => Str::random(10),
        ];
    }

    public function configure(): static
    {
        return $this->user();
    }

    public function admin(): static
    {
        return $this->afterCreating(fn (User $user) => $user->syncRoles(Role::ADMIN->value));
    }

    public function user(): static
    {
        return $this->afterCreating(fn (User $user) => $user->syncRoles(Role::USER->value));
    }

    public function journalist(): static
    {
        return $this->afterCreating(fn (User $user) => $user->syncRoles(Role::JOURNALIST->value));
    }
}
