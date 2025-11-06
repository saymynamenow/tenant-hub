<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TenantMigrateAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:tenant-migrate-all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Tenant::chunk(50, function($tenants) {
        foreach ($tenants as $tenant) {
            $dbPass = decrypt($tenant->db_password_encrypted);
            config()->set('database.connections.tenant.database', $tenant->db_name);
            config()->set('database.connections.tenant.username', $tenant->db_username);
            config()->set('database.connections.tenant.password', $dbPass);

            DB::purge('tenant'); DB::reconnect('tenant');

            try {
                Artisan::call('migrate', [
                    '--path' => 'database/migrations/tenant',
                    '--database' => 'tenant',
                    '--force' => true
                ]);
            } catch (\Exception $e) {
                \Log::error("Migrate failed for {$tenant->id}: ".$e->getMessage());
            }
        }
    });
    }
}
