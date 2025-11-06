<?php

namespace Tests\Feature;

use App\Models\TenantModels;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_all_tenants()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        TenantModels::factory()->count(5)->create();

        $response = $this->actingAs($admin)
            ->getJson('/getTenant');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'slug', 'domain', 'status', 'database_name'],
                ],
            ]);
    }

    /** @test */
    public function admin_can_view_tenant_statistics()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        TenantModels::factory()->create(['status' => 'active']);
        TenantModels::factory()->create(['status' => 'active']);
        TenantModels::factory()->create(['status' => 'inactive']);
        TenantModels::factory()->create(['status' => 'suspended']);

        $response = $this->actingAs($admin)
            ->getJson('/tenants/stats');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'total',
                'active',
                'inactive',
                'suspended',
            ]);

        // Verify the counts are at least what we created
        $data = $response->json();
        $this->assertGreaterThanOrEqual(4, $data['total']);
        $this->assertGreaterThanOrEqual(2, $data['active']);
        $this->assertGreaterThanOrEqual(1, $data['inactive']);
        $this->assertGreaterThanOrEqual(1, $data['suspended']);
    }

    /** @test */
    public function admin_can_update_tenant_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $tenant = TenantModels::factory()->create(['status' => 'active']);

        $response = $this->actingAs($admin)
            ->patchJson("/tenants/{$tenant->id}/status", [
                'status' => 'suspended',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'status' => 'suspended',
        ]);
    }

    /** @test */
    public function admin_can_delete_tenant()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $tenant = TenantModels::factory()->create();

        $response = $this->actingAs($admin)
            ->deleteJson("/tenants/{$tenant->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tenants', [
            'id' => $tenant->id,
        ]);
    }

    /** @test */
    public function non_admin_cannot_manage_tenants()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $tenant = TenantModels::factory()->create();

        $response = $this->actingAs($customer)
            ->patchJson("/tenants/{$tenant->id}/status", [
                'status' => 'suspended',
            ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function guest_cannot_view_tenants()
    {
        $response = $this->getJson('/getTenant');

        $response->assertStatus(401);
    }

    /** @test */
    public function tenant_slug_is_generated_correctly()
    {
        $tenant = TenantModels::factory()->create([
            'name' => 'Test Store Name',
        ]);

        $this->assertEquals('test-store-name', $tenant->slug);
    }

    /** @test */
    public function admin_can_create_new_tenant()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Mock TenantService to avoid actual database creation
        $this->mock(\App\Services\TenantService::class, function ($mock) {
            $mock->shouldReceive('createTenant')
                ->once()
                ->andReturn(TenantModels::factory()->make([
                    'name' => 'New Test Store',
                    'slug' => 'new-test-store',
                    'status' => 'active',
                ]));
        });

        $tenantData = [
            'name' => 'New Test Store',
            'username' => 'newteststore',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->actingAs($admin)
            ->postJson('/tenants', $tenantData);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Tenant created successfully',
            ]);
    }

    /** @test */
    public function it_validates_tenant_status_values()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $tenant = TenantModels::factory()->create(['status' => 'active']);

        $response = $this->actingAs($admin)
            ->patchJson("/tenants/{$tenant->id}/status", [
                'status' => 'invalid_status',
            ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function tenant_list_includes_all_required_information()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        TenantModels::factory()->create([
            'name' => 'Complete Info Tenant',
            'slug' => 'complete-info',
            'domain' => 'complete-info.localhost',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)
            ->getJson('/getTenant');

        $response->assertStatus(200);
        
        $tenant = $response->json('data.0');
        
        $this->assertArrayHasKey('id', $tenant);
        $this->assertArrayHasKey('name', $tenant);
        $this->assertArrayHasKey('slug', $tenant);
        $this->assertArrayHasKey('domain', $tenant);
        $this->assertArrayHasKey('status', $tenant);
        $this->assertArrayHasKey('database_name', $tenant);
    }

    /** @test */
    public function deleting_tenant_does_not_affect_other_tenants()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        
        $tenant1 = TenantModels::factory()->create(['name' => 'Tenant to Delete']);
        $tenant2 = TenantModels::factory()->create(['name' => 'Tenant to Keep']);

        $this->actingAs($admin)
            ->deleteJson("/tenants/{$tenant1->id}");

        $this->assertDatabaseMissing('tenants', [
            'id' => $tenant1->id,
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant2->id,
            'name' => 'Tenant to Keep',
        ]);
    }
}
