<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        // Limitamos la cantidad de tareas por usuario
        if (!$user = User::inRandomOrder()->has('tasks', '<', 5)->first()) {
            $user = User::factory()->create();
        }

        $company = Company::inRandomOrder()->first();

        $startDate = now()->subDays(5);
        $expiredDate = now()->addDays(5);

        return [
            'name' => fake()->name(),
            'description' => fake()->sentence(7),
            'user_id' => $user->id,
            'company_id' => $company->id,
            'user' => $user->name,
            'start_at' => fake()->dateTimeBetween($startDate, now()),
            'expired_at' => fake()->dateTimeBetween(now(), $expiredDate),
            'is_completed' => fake()->boolean(50)
        ];
    }
}
