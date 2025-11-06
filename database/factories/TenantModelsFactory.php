<?php

namespace Database\Factories;

use App\Models\TenantModels;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TenantModelsFactory extends Factory
{
    protected $model = TenantModels::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->company();
        $slug = Str::slug($name);
        
        return [
            'name' => $name,
            // Don't set slug here - let the model's boot() method generate it from name
            'domain' => $slug . '.localhost',
            'database_name' => 'tenant_' . $slug,
            'db_username' => 'user_' . $slug,
            'db_password_encrypted' => encrypt('password123'),
            'status' => 'active',
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
        ]);
    }
}
