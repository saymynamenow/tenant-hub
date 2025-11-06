# Central Admin Dashboard - Setup Complete

## Overview

Central admin dashboard for managing the multi-tenant system with separate databases per tenant.

## Features Implemented

### 1. **Backend - TenantController** (`app/Http/Controllers/TenantController.php`)

#### API Endpoints:

-   **GET** `/api/central/tenants` - List all tenants (paginated, searchable, filterable)
-   **GET** `/api/central/tenants/stats` - Get tenant statistics
-   **POST** `/api/central/tenants` - Create new tenant
-   **PATCH** `/api/central/tenants/{id}/status` - Update tenant status
-   **DELETE** `/api/central/tenants/{id}` - Delete tenant

#### Key Features:

-   **Automatic Tenant Provisioning**: Creates database, runs migrations, and seeds owner user
-   **Database Isolation**: Each tenant gets separate MySQL database (`tenant_{slug}`)
-   **Dynamic Connections**: Runtime database connection configuration
-   **Rollback on Failure**: Automatic cleanup if tenant creation fails
-   **Status Management**: Active, Inactive, Suspended states
-   **Search & Filter**: By name, email, slug, and status

### 2. **Frontend - CentralDashboard.vue** (`resources/js/pages/AdminPage/CentralDashboard.vue`)

#### UI Components:

-   **Statistics Cards**: Total, Active, Inactive, This Month counts
-   **Tenant Table**: Display all tenants with details
-   **Search & Filters**: Real-time search by name/email/slug, status filter
-   **Create Modal**: Full form for new tenant registration
-   **Status Dropdown**: In-table status updates
-   **Delete Confirmation**: Confirmation dialog for destructive actions
-   **Toast Notifications**: Success/error feedback
-   **Pagination**: 15 tenants per page

#### Design:

-   Modern gradient background (`from-slate-50 to-slate-100`)
-   Rounded-xl cards with shadows
-   Color-coded status badges (green/gray/red)
-   Responsive grid layout (4-2-1 columns)
-   Smooth transitions and hover effects

### 3. **Database - Tenant Model & Migration**

#### Tenant Model (`app/Models/Tenant.php`):

-   Connection: `mysql` (central database)
-   Fields: name, slug, database_name, domain, email, status, plan, settings
-   Methods:
    -   `getDatabaseConfig()`: Returns config array for dynamic connection
    -   `isActive()`: Boolean status check
    -   `owner()`: Relationship to tenant owner

#### Migration (`database/migrations/2025_01_05_000001_create_tenants_table.php`):

-   Schema: id, name, slug (unique), database_name (unique), domain (nullable unique), email, status (enum), plan, settings (json), timestamps
-   Status enum: active, inactive, suspended (default: active)
-   Plan default: free

### 4. **Routing**

#### API Routes (`routes/api.php`):

```php
Route::prefix('central')->group(function () {
    Route::get('/tenants', [TenantController::class, 'index']);
    Route::get('/tenants/stats', [TenantController::class, 'stats']);
    Route::post('/tenants', [TenantController::class, 'store']);
    Route::patch('/tenants/{id}/status', [TenantController::class, 'updateStatus']);
    Route::delete('/tenants/{id}', [TenantController::class, 'destroy']);
});
```

#### Frontend Route (`resources/js/router/index.js`):

```javascript
{
    path: "/central-dashboard",
    name: "CentralDashboard",
    component: CentralDashboard,
    meta: { requiresAuth: true, requiresManager: true },
}
```

### 5. **Navigation**

-   **Management Dashboard** → "Central Admin" button (purple, top-right)
-   **Central Dashboard** → Back arrow to Management Dashboard

## How to Use

### Access Central Dashboard

1. Login as manager or owner
2. Go to Management Dashboard (`/dashboard`)
3. Click "Central Admin" button (purple) in top-right
4. You'll be redirected to `/central-dashboard`

### Create New Tenant

1. Click "Create New Tenant" button
2. Fill in the form:
    - **Tenant Name** (required): Display name
    - **Slug** (optional): URL-friendly identifier (auto-generated if empty)
    - **Tenant Email** (required): Contact email
    - **Domain** (optional): Custom domain
    - **Plan**: Free, Basic, or Premium
    - **Owner Name** (required): First owner account name
    - **Owner Email** (required): Owner login email
    - **Owner Password** (required): Owner password (min 6 chars)
3. Click "Create Tenant"
4. System will:
    - Create tenant record in central DB
    - Create new MySQL database (`tenant_{slug}`)
    - Run all migrations on new database
    - Create owner user in tenant database
    - Return success/error notification

### Manage Tenants

-   **Search**: Type in search box and click "Apply Filters"
-   **Filter by Status**: Select status from dropdown
-   **Change Status**: Click status dropdown in table row
-   **View Details**: Click "View" button (shows alert with details)
-   **Delete Tenant**: Click "Delete" button → Confirm → Database and record deleted

## Technical Architecture

### Multi-Tenant Flow

```
1. User visits tenant subdomain/domain
2. IdentifyTenant middleware identifies tenant
3. Config::set() updates database connection
4. DB::reconnect('tenant') switches to tenant DB
5. All queries now run on tenant database
```

### Tenant Creation Flow

```
1. Validate input (name, email unique, slug unique, domain unique)
2. Generate slug from name if not provided
3. Check if database already exists
4. Create tenant record in central DB
5. Execute CREATE DATABASE statement
6. Configure tenant connection dynamically
7. Run migrations on new tenant DB
8. Insert owner user with 'owner' role
9. Return success (or rollback on error)
```

### Database Structure

```
Central DB (mysql):
  - tenants table (metadata)
  - migrations table

Tenant DB (tenant_{slug}):
  - users table
  - products table
  - categories table
  - orders table
  - order_items table
  - carts table
  - cart_items table
  - migrations table
```

## Security Considerations

1. **Route Protection**: Central dashboard requires authentication and manager role
2. **Validation**: All inputs validated (unique constraints on email, slug, domain)
3. **Database Isolation**: Each tenant has completely separate database
4. **Rollback**: Failed tenant creation rolls back (drops DB, deletes record)
5. **Confirmation**: Destructive actions (delete) require confirmation

## Next Steps (Optional Enhancements)

1. **Super Admin Role**: Create dedicated super_admin role for central dashboard access
2. **Tenant Settings**: Expand settings JSON field for feature toggles
3. **Billing Integration**: Connect plan field to payment gateway
4. **Usage Metrics**: Track storage, users, orders per tenant
5. **Backup System**: Automated tenant database backups
6. **Subdomain Routing**: Map domains to tenants automatically
7. **Tenant Onboarding**: Welcome email, setup wizard
8. **Audit Logging**: Track who created/modified/deleted tenants
9. **API Rate Limiting**: Per-tenant API rate limits
10. **Database Migrations**: UI for running migrations on specific tenants

## Testing

### Manual Testing Steps:

1. Navigate to `/central-dashboard`
2. Verify statistics cards show correct counts
3. Create test tenant: "Test Company"
4. Check database: `SHOW DATABASES LIKE 'tenant_%'`
5. Verify tenant appears in table
6. Change status to "inactive"
7. Search for tenant by name
8. Filter by status
9. Delete tenant and confirm database is dropped

## Troubleshooting

### Issue: "SQLSTATE[HY000] [1007] Can't create database"

-   **Cause**: Database already exists
-   **Solution**: Check `SHOW DATABASES` and drop manually: `DROP DATABASE tenant_{slug}`

### Issue: "401 Unauthorized" when accessing endpoints

-   **Cause**: Not authenticated or not manager role
-   **Solution**: Login as manager/owner user

### Issue: Stats not updating after create/delete

-   **Cause**: Frontend not reloading stats
-   **Solution**: Check browser console for errors, verify `/api/central/tenants/stats` endpoint

### Issue: Tenant creation fails but database created

-   **Cause**: Error during migration or user seeding
-   **Solution**: Check Laravel logs, manually drop database, retry

## Files Modified/Created

### Created:

-   `app/Models/Tenant.php`
-   `database/migrations/2025_01_05_000001_create_tenants_table.php`
-   `resources/js/pages/AdminPage/CentralDashboard.vue`
-   `routes/api.php`
-   `CENTRAL_DASHBOARD_SETUP.md` (this file)

### Modified:

-   `app/Http/Controllers/TenantController.php` (complete rewrite)
-   `resources/js/router/index.js` (added route)
-   `resources/js/pages/ProductManagement/ManagementDashboard.vue` (added nav button)

## Summary

You now have a fully functional central admin dashboard for managing your multi-tenant eCommerce platform. Super admins can:

-   View all tenants at a glance
-   Create new tenants with automatic database provisioning
-   Manage tenant status (active/inactive/suspended)
-   Search and filter tenants
-   Delete tenants with database cleanup

The system handles all the complexity of multi-tenant database management automatically!
