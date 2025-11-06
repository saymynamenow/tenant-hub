<?php

namespace Tests\Feature;

use App\Models\TenantModels;
use App\Models\User;
use App\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected $tenantService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tenantService = app(TenantService::class);
    }

    /** @test */
    public function it_creates_isolated_tenant_database()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        $tenantData = [
            'name' => 'Test Tenant One',
            'username' => 'testtenant1',
            'password' => 'password123',
        ];

        $tenant = $this->tenantService->createTenant($tenantData);

        $this->assertDatabaseHas('tenants', [
            'name' => 'Test Tenant One',
            'slug' => 'test-tenant-one',
            'status' => 'active',
        ]);

        // Check tenant database exists
        $dbName = $tenant->database_name;
        $databases = DB::select("SELECT datname FROM pg_database WHERE datname = ?", [$dbName]);
        $this->assertNotEmpty($databases, "Database {$dbName} was not created");
    }

    /** @test */
    public function it_isolates_data_between_tenants()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        // Create two tenants
        $tenant1 = $this->tenantService->createTenant([
            'name' => 'Tenant One Data Test',
            'username' => 'tenant1data',
            'password' => 'password123',
        ]);

        $tenant2 = $this->tenantService->createTenant([
            'name' => 'Tenant Two Data Test',
            'username' => 'tenant2data',
            'password' => 'password123',
        ]);

        // Configure tenant 1 connection
        config([
            'database.connections.tenant' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => $tenant1->database_name,
                'username' => $tenant1->db_username,
                'password' => decrypt($tenant1->db_password_encrypted),
            ]
        ]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Create a user in tenant 1
        DB::connection('tenant')->table('users')->insert([
            'name' => 'Tenant 1 User',
            'email' => 'user1@tenant1.com',
            'username' => 'user1tenant1',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tenant1Users = DB::connection('tenant')->table('users')->count();
        $this->assertEquals(1, $tenant1Users, 'Tenant 1 should have 1 user');

        // Switch to tenant 2 connection
        config([
            'database.connections.tenant' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => $tenant2->database_name,
                'username' => $tenant2->db_username,
                'password' => decrypt($tenant2->db_password_encrypted),
            ]
        ]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Verify tenant 2 doesn't see tenant 1's user
        $tenant2Users = DB::connection('tenant')->table('users')->get();
        $this->assertCount(0, $tenant2Users, 'Tenant 2 should not see Tenant 1 users');

        // Create user in tenant 2
        DB::connection('tenant')->table('users')->insert([
            'name' => 'Tenant 2 User',
            'email' => 'user2@tenant2.com',
            'username' => 'user2tenant2',
            'password' => bcrypt('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Verify tenant 2 only sees its own user
        $tenant2Users = DB::connection('tenant')->table('users')->get();
        $this->assertCount(1, $tenant2Users);
        $this->assertEquals('Tenant 2 User', $tenant2Users[0]->name);
    }

    /** @test */
    public function it_prevents_access_to_inactive_tenant()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        $tenant = $this->tenantService->createTenant([
            'name' => 'Inactive Tenant Test',
            'username' => 'inactivetenant',
            'password' => 'password123',
        ]);

        // Set tenant to inactive
        $tenant->update(['status' => 'inactive']);

        // Simulate request to inactive tenant subdomain
        $response = $this->get('/', [
            'HTTP_HOST' => 'inactivetenant.localhost:8000'
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_prevents_access_to_suspended_tenant()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        $tenant = $this->tenantService->createTenant([
            'name' => 'Suspended Tenant Test',
            'username' => 'suspendedtenant',
            'password' => 'password123',
        ]);

        // Set tenant to suspended
        $tenant->update(['status' => 'suspended']);

        // Simulate request to suspended tenant subdomain
        $response = $this->get('/', [
            'HTTP_HOST' => 'suspendedtenant.localhost:8000'
        ]);

        $response->assertStatus(404);
    }

    /** @test */
    public function it_allows_access_to_active_tenant()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        $tenant = $this->tenantService->createTenant([
            'name' => 'Active Tenant Test',
            'username' => 'activetenant',
            'password' => 'password123',
        ]);

        // Simulate request to active tenant subdomain
        $response = $this->get('/tenant/status', [
            'HTTP_HOST' => 'activetenant.localhost:8000'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_tenant_with_required_tables()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        $tenant = $this->tenantService->createTenant([
            'name' => 'Table Check Tenant',
            'username' => 'tablechecktenant',
            'password' => 'password123',
        ]);

        // Configure tenant connection
        config([
            'database.connections.tenant' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => $tenant->database_name,
                'username' => $tenant->db_username,
                'password' => decrypt($tenant->db_password_encrypted),
            ]
        ]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        // Check required tables exist
        $requiredTables = ['users', 'categories', 'carts', 'orders'];

        foreach ($requiredTables as $table) {
            $this->assertTrue(
                Schema::connection('tenant')->hasTable($table),
                "Table {$table} does not exist in tenant database"
            );
        }
    }

    /** @test */
    public function it_maintains_separate_user_bases_per_tenant()
    {
        $this->markTestSkipped('This test requires actual database creation which cannot run inside transactions. Run as integration test.');

        // Create two tenants
        $tenant1 = $this->tenantService->createTenant([
            'name' => 'Multi User Tenant 1',
            'username' => 'multiuser1',
            'password' => 'password123',
        ]);

        $tenant2 = $this->tenantService->createTenant([
            'name' => 'Multi User Tenant 2',
            'username' => 'multiuser2',
            'password' => 'password123',
        ]);

        // Add users to tenant 1
        config([
            'database.connections.tenant' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => $tenant1->database_name,
                'username' => $tenant1->db_username,
                'password' => decrypt($tenant1->db_password_encrypted),
            ]
        ]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        for ($i = 1; $i <= 3; $i++) {
            DB::connection('tenant')->table('users')->insert([
                'name' => "Tenant 1 User {$i}",
                'email' => "user{$i}@tenant1.com",
                'username' => "user{$i}tenant1",
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add users to tenant 2
        config([
            'database.connections.tenant' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => $tenant2->database_name,
                'username' => $tenant2->db_username,
                'password' => decrypt($tenant2->db_password_encrypted),
            ]
        ]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        for ($i = 1; $i <= 5; $i++) {
            DB::connection('tenant')->table('users')->insert([
                'name' => "Tenant 2 User {$i}",
                'email' => "user{$i}@tenant2.com",
                'username' => "user{$i}tenant2",
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $tenant2UserCount = DB::connection('tenant')->table('users')->count();
        $this->assertEquals(5, $tenant2UserCount);

        // Switch back to tenant 1 and verify count
        config([
            'database.connections.tenant' => [
                'driver' => 'pgsql',
                'host' => env('DB_HOST', '127.0.0.1'),
                'port' => env('DB_PORT', '5432'),
                'database' => $tenant1->database_name,
                'username' => $tenant1->db_username,
                'password' => decrypt($tenant1->db_password_encrypted),
            ]
        ]);
        DB::purge('tenant');
        DB::reconnect('tenant');

        $tenant1UserCount = DB::connection('tenant')->table('users')->count();
        $this->assertEquals(3, $tenant1UserCount);
    }

    protected function tearDown(): void
    {
        // Clean up test tenant databases
        $tenants = TenantModels::whereIn('slug', [
            'test-tenant-one',
            'tenant-one-data-test',
            'tenant-two-data-test',
            'inactive-tenant-test',
            'suspended-tenant-test',
            'active-tenant-test',
            'table-check-tenant',
            'multi-user-tenant-1',
            'multi-user-tenant-2',
        ])->get();
        
        foreach ($tenants as $tenant) {
            try {
                DB::statement("DROP DATABASE IF EXISTS {$tenant->database_name}");
                DB::statement("DROP USER IF EXISTS {$tenant->db_username}");
                $tenant->delete();
            } catch (\Exception $e) {
                // Ignore errors during cleanup
            }
        }

        parent::tearDown();
    }
}
