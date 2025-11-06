<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Models\TenantModels as Tenant;
use Illuminate\Support\Str;


class TenantService
{
    public function createTenant(array $data): Tenant
    {
        $dbName = 'tenant_' . Str::slug($data['name']);
        $dbUsername = 'tenant_' . Str::slug($data['username']);
        $dbPass = Str::random(16);

        $tenant = Tenant::create([
            'name' => $data['name'],
            'database_name' => $dbName,
            'db_username' => $dbUsername,
            'db_password_encrypted' => encrypt($dbPass),
            'slug' => Str::slug($data['username']),
            'domain' => Str::slug($data['username']) . '.localhost',
        ]);

        $rootConn = DB::connection('pgsql');
        $exists = $rootConn->select("SELECT 1 FROM pg_database WHERE datname = ?", [$dbName]);
        if (!$exists) {
            $rootConn->statement("CREATE DATABASE \"$dbName\"");
        config()->set("database.connections.tenant_temp", [
                'driver' => 'pgsql',
                'host' => env('DB_HOST'),
                'port' => env('DB_PORT'),
                'database' => $dbName,
                'username' => env('DB_USERNAME'),
                'password' => env('DB_PASSWORD'),
                'charset' => 'UTF8',
                'schema' => 'public',
                'sslmode' => 'prefer',
            ]);

    $tenantSuperConn = DB::connection('tenant_temp');
        }
        $userExists = $rootConn->select("SELECT 1 FROM pg_roles WHERE rolname = ?", [$dbUsername]);
        if (!$userExists) {
            $rootConn->statement("CREATE USER \"$dbUsername\" WITH PASSWORD '$dbPass'");
        } else {
            $rootConn->statement("ALTER USER \"$dbUsername\" WITH PASSWORD '$dbPass'");
        }
        $tenantSuperConn->statement("GRANT ALL PRIVILEGES ON DATABASE \"$dbName\" TO \"$dbUsername\"");
        $tenantSuperConn->statement("GRANT ALL ON SCHEMA public TO \"$dbUsername\"");
        config()->set('database.connections.tenant', [
            'driver' => 'pgsql',
            'host' => env('DB_HOST'),
            'port' => env('DB_PORT'),
            'database' => $dbName,
            'username' => $dbUsername,
            'password' => $dbPass,
            'charset' => 'UTF8', 
            'schema' => 'public',
            'sslmode' => 'prefer',
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');
                Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--database' => 'tenant',
            '--force' => true,
        ]);
        return $tenant;
    }
}