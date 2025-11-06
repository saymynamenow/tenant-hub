<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantRequest;
use App\Services\TenantService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TenantRequestController extends Controller
{
    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Store a new tenant request from a customer
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenant_requests,email',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $tenantRequest = TenantRequest::create([
                'business_name' => $request->business_name,
                'contact_name' => $request->contact_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'description' => $request->description,
                'status' => 'pending',
            ]);

            return response()->json([
                'message' => 'Your tenant request has been submitted successfully. We will review it and get back to you soon.',
                'request' => $tenantRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to submit tenant request',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get all tenant requests (for admin)
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->query('per_page', 15);
            $status = $request->query('status', '');

            $query = TenantRequest::query();

            if ($status) {
                $query->where('status', $status);
            }

            $requests = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json($requests, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load tenant requests', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Approve a tenant request and auto-create the tenant
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $tenantRequest = TenantRequest::findOrFail($id);
            
            if ($tenantRequest->status === 'approved') {
                return response()->json([
                    'error' => 'This request has already been approved'
                ], 400);
            }

            // Create the tenant using TenantService
            $this->tenantService->createTenant([
                'name' => $tenantRequest->business_name,
                'username' => $request->username,
                'password' => $request->password,
                'email' => $tenantRequest->email,
                'phone' => $tenantRequest->phone,
            ]);

            // Update request status
            $tenantRequest->update([
                'status' => 'approved',
                'admin_notes' => $request->admin_notes,
                'reviewed_at' => now(),
            ]);

            return response()->json([
                'message' => 'Tenant request approved and tenant created successfully',
                'request' => $tenantRequest
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to approve tenant request',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update tenant request status (approve/reject)
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $tenantRequest = TenantRequest::findOrFail($id);
            
            $tenantRequest->update([
                'status' => $request->status,
                'admin_notes' => $request->admin_notes,
                'reviewed_at' => now(),
            ]);

            return response()->json([
                'message' => 'Tenant request updated successfully',
                'request' => $tenantRequest
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update tenant request',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a tenant request
     */
    public function destroy($id)
    {
        try {
            $tenantRequest = TenantRequest::findOrFail($id);
            $tenantRequest->delete();

            return response()->json(['message' => 'Tenant request deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete tenant request',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
