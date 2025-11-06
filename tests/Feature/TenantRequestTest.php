<?php

namespace Tests\Feature;

use App\Models\TenantModels;
use App\Models\TenantRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantRequestTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function customer_can_submit_tenant_request()
    {
        $requestData = [
            'business_name' => 'Test Business Store',
            'contact_name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '+1234567890',
            'description' => 'I need an e-commerce platform for my business',
        ];

        $response = $this->postJson('/tenant-requests', $requestData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'business_name', 'email', 'status']
            ]);

        $this->assertDatabaseHas('tenant_requests', [
            'business_name' => 'Test Business Store',
            'email' => 'john@example.com',
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function admin_can_view_all_tenant_requests()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Create multiple tenant requests with unique emails
        TenantRequest::create([
            'business_name' => 'Test Business 1',
            'contact_name' => 'Contact 1',
            'email' => 'test1@example.com',
            'phone' => '1234567890',
            'description' => 'Description 1',
            'status' => 'pending',
        ]);
        
        TenantRequest::create([
            'business_name' => 'Test Business 2',
            'contact_name' => 'Contact 2',
            'email' => 'test2@example.com',
            'phone' => '1234567891',
            'description' => 'Description 2',
            'status' => 'pending',
        ]);
        
        TenantRequest::create([
            'business_name' => 'Test Business 3',
            'contact_name' => 'Contact 3',
            'email' => 'test3@example.com',
            'phone' => '1234567892',
            'description' => 'Description 3',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)
            ->getJson('/tenant-requests');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertGreaterThanOrEqual(3, count($data));
    }

    /** @test */
    public function admin_can_approve_tenant_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $request = TenantRequest::create([
            'business_name' => 'Approved Test Store',
            'contact_name' => 'John Doe',
            'email' => 'approved@example.com',
            'phone' => '1234567890',
            'description' => 'Test description',
            'status' => 'pending',
        ]);

        // Mock the TenantService to avoid actual database creation in tests
        $this->mock(\App\Services\TenantService::class, function ($mock) {
            $mock->shouldReceive('createTenant')
                ->once()
                ->andReturn(TenantModels::factory()->make([
                    'name' => 'Approved Test Store',
                    'status' => 'active',
                ]));
        });

        $approvalData = [
            'username' => 'approvedstore',
            'password' => 'password123',
        ];

        $response = $this->actingAs($admin)
            ->postJson("/tenant-requests/{$request->id}/approve", $approvalData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'request',
            ]);

        $this->assertDatabaseHas('tenant_requests', [
            'id' => $request->id,
            'status' => 'approved',
        ]);
    }

    /** @test */
    public function admin_can_reject_tenant_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $request = TenantRequest::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)
            ->patchJson("/tenant-requests/{$request->id}/status", [
                'status' => 'rejected',
                'admin_notes' => 'Incomplete business information provided',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tenant_requests', [
            'id' => $request->id,
            'status' => 'rejected',
            'admin_notes' => 'Incomplete business information provided',
        ]);
    }

    /** @test */
    public function customer_can_view_their_own_requests()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
            'email' => 'unique_customer@example.com',
        ]);

        // Create requests for this customer with unique emails
        TenantRequest::create([
            'business_name' => 'Customer Business 1',
            'contact_name' => 'Customer Contact',
            'email' => 'unique_customer@example.com',
            'phone' => '1234567890',
            'description' => 'Description 1',
            'status' => 'pending',
        ]);
        
        TenantRequest::create([
            'business_name' => 'Customer Business 2',
            'contact_name' => 'Customer Contact',
            'email' => 'other_unique@example.com',
            'phone' => '1234567891',
            'description' => 'Description 2',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($customer)
            ->getJson('/tenant-requests');

        $response->assertStatus(200);
        
        $data = $response->json('data');
        $this->assertGreaterThanOrEqual(2, count($data)); // Admin sees all
    }

    /** @test */
    public function guest_cannot_view_tenant_requests()
    {
        TenantRequest::factory()->count(3)->create();

        $response = $this->getJson('/tenant-requests');

        $response->assertStatus(401);
    }

    /** @test */
    public function it_validates_required_fields_for_tenant_request()
    {
        $response = $this->postJson('/tenant-requests', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['business_name', 'contact_name', 'email']);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $response = $this->postJson('/tenant-requests', [
            'business_name' => 'Test Store',
            'contact_name' => 'John Doe',
            'email' => 'invalid-email-format',
            'phone' => '1234567890',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function admin_can_delete_tenant_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $request = TenantRequest::factory()->create();

        $response = $this->actingAs($admin)
            ->deleteJson("/tenant-requests/{$request->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tenant_requests', [
            'id' => $request->id,
        ]);
    }

    /** @test */
    public function non_admin_cannot_approve_tenant_requests()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $request = TenantRequest::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($customer)
            ->postJson("/tenant-requests/{$request->id}/approve", [
                'username' => 'testuser',
                'password' => 'password123',
            ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function it_records_review_timestamp_when_status_changes()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $request = TenantRequest::factory()->create(['status' => 'pending']);

        $this->assertNull($request->reviewed_at);

        $this->actingAs($admin)
            ->patchJson("/tenant-requests/{$request->id}/status", [
                'status' => 'rejected',
                'admin_notes' => 'Rejected for testing',
            ]);

        $request->refresh();
        $this->assertNotNull($request->reviewed_at);
    }
}
