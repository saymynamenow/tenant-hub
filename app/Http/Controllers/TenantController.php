<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TenantService;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;        
use App\Models\TenantModels as Tenant;
use Illuminate\Database\QueryException;
use PDOException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class TenantController extends Controller
{
    protected $tenantService;
    
    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 15);
            $search = $request->query('search', '');
            $status = $request->query('status', '');

            $query = Tenant::query();

            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('slug', 'like', "%{$search}%");
                });
            }

            if ($status) {
                $query->where('status', $status);
            }

            $tenants = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json($tenants, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load tenants', 'message' => $e->getMessage()], 500);
        }
    }

    public function stats()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $total = Tenant::count();
            $active = Tenant::where('status', 'active')->count();
            $inactive = Tenant::where('status', 'inactive')->count();
            $suspended = Tenant::where('status', 'suspended')->count();

            return response()->json([
                'total' => $total,
                'active' => $active,
                'inactive' => $inactive,
                'suspended' => $suspended,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get statistics', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:tenants,name',
            'status' => 'sometimes|in:active,inactive,suspended',
        ]);

        try {
            $tenant = $this->tenantService->createTenant([
                'name' => $request->input('name'),
                'username' => Str::slug($request->input('name')) . '_user',
                'password' => Str::random(16),
                'status' => $request->input('status', 'active'),
            ]);

            return response()->json([
                'message' => 'Tenant created successfully',
                'tenant' => $tenant
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create tenant', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($tenantId)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $tenant = Tenant::findOrFail($tenantId);
            $tenant->delete();

            return response()->json(['message' => 'Tenant deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete tenant', 'message' => $e->getMessage()], 500);
        }
    }


    public function status(Request $request)
    {

        return response()->json(['status' => 'active'], 200);
    }


    public function register(Request $request)
    {
        if (request()->getHost() !== 'www.central.localhost') {
            abort(403, 'Tenant registration is only allowed from the central domain.');
        }

        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|unique:tenants,name',
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
        
        try {
            $this->tenantService->createTenant([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'password' => $request->input('password'),
                'meta' => $request->input('meta'),
                'status' => $request->input('status', 'active'),
            ]);
            return response()->json(['message' => 'Tenant created successfully'], 201);
        } catch (QueryException $e) {
            $code = $e->getCode();
            if ((string)$code === '1049') {
                return response()->json(['error' => 'Tenant database not found'], 503);
            }
            return response()->json(['error' => 'Database error while creating tenant', 'message' => $e->getMessage()], 500);
        } catch (PDOException $e) {
            return response()->json(['error' => 'Database connection error', 'message' => $e->getMessage()], 503);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to create tenant', 'message' => $th->getMessage()], 500);
        }
    }

    public function UpdateTenantStatus(Request $request, $tenantId)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);

        try {
            $tenant = Tenant::findOrFail($tenantId);
            $tenant->status = $request->input('status');
            $tenant->save();

            return response()->json(['message' => 'Tenant status updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update tenant status', 'message' => $e->getMessage()], 500);
        }
    }
}

