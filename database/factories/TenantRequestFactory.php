<?php

namespace Database\Factories;

use App\Models\TenantRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantRequestFactory extends Factory
{
    protected $model = TenantRequest::class;

    public function definition(): array
    {
        return [
            'business_name' => $this->faker->company(),
            'contact_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'description' => $this->faker->sentence(10),
            'status' => 'pending',
            'admin_notes' => null,
            'reviewed_at' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'reviewed_at' => null,
            'admin_notes' => null,
        ]);
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
            'reviewed_at' => now(),
            'admin_notes' => 'Approved by admin',
        ]);
    }

    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
            'reviewed_at' => now(),
            'admin_notes' => $this->faker->sentence(),
        ]);
    }
}
