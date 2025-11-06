# Multi-Tenant E-Commerce Platform

A modern multi-tenant e-commerce platform built with Laravel 12 and Vue 3. This application supports multiple isolated tenant databases with a central administration dashboard for managing tenants and customer requests.

## 🚀 Features

### Core Multi-Tenant Features

-   **Multi-Tenant Architecture**: Isolated databases for each tenant with subdomain-based routing
-   **Automatic Tenant Provisioning**: Database and schema creation on approval
-   **Tenant Status Management**: Active, inactive, and suspended tenant states with automatic access control
-   **Data Isolation**: Complete separation of tenant data with per-tenant PostgreSQL databases
-   **Subdomain Routing**: Automatic tenant identification via subdomain

### Central Administration

-   **Central Admin Dashboard**: Manage all tenants, view statistics, and handle customer requests
-   **Tenant Request System**: Customers can submit requests for new tenant accounts
-   **Tenant Management**: Create, update, activate, suspend, or delete tenants
-   **Statistics Dashboard**: Overview of total tenants, active tenants, and pending requests
-   **Role-Based Access Control**: Differentiated admin and customer experiences

### Tenant Features

-   **E-Commerce Functionality**: Products, categories, shopping cart, and order management per tenant
-   **Product Management Dashboard**: Admin users can manage inventory, categories, and orders
-   **User Profile Dropdown**: Quick access to profile and management dashboard for admin users
-   **Shopping Cart**: Add to cart, update quantities, and checkout functionality
-   **Order Management**: Track orders with status updates (pending, processing, shipped, delivered)
-   **Category System**: Organize products with color-coded categories and icons

### Technical Features

-   **Vue 3 SPA**: Modern single-page application with Vue Router and Composition API
-   **Tailwind CSS**: Beautiful, responsive UI design
-   **Laravel Sanctum**: API authentication for both central and tenant domains
-   **RESTful API**: Clean API design with proper error handling
-   **Comprehensive Testing**: Full test coverage for multi-tenant functionality

## 📋 Requirements

-   **PHP**: ^8.2
-   **Composer**: Latest version
-   **Node.js**: ^18.0 or higher
-   **pnpm** (recommended) or npm
-   **PostgreSQL**: ^14.0 or higher
-   **Laravel**: ^12.0
-   **Vue.js**: ^3.5

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/saymynamenow/tenant-hub.git
cd tenant-hub
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

Using pnpm (recommended):

```bash
pnpm install
```

Or using npm:

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file and configure your settings:

```bash
copy .env.example .env
```

Edit `.env` and configure your database connection:

```env
APP_NAME="Tenant Hub"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

# PostgreSQL Configuration
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=central_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Session Configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Queue Configuration
QUEUE_CONNECTION=database

# Cache Configuration
CACHE_STORE=database

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=localhost,central.localhost,*.localhost
SESSION_DOMAIN=.localhost
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

This will create the following tables in your central database:

-   `users` - Central admin and customer users
-   `tenants` - Tenant information and database credentials
-   `tenant_requests` - Customer tenant application requests
-   `cache`, `jobs`, `sessions`, `personal_access_tokens` - Laravel system tables

### 7. Configure Local Hosts (Development)

For local development with subdomain routing, add entries to your hosts file:

**Windows**: `C:\Windows\System32\drivers\etc\hosts`  
**Linux/Mac**: `/etc/hosts`

```
127.0.0.1    localhost
127.0.0.1    central.localhost
127.0.0.1    www.central.localhost
127.0.0.1    tenant1.localhost
127.0.0.1    mystore.localhost
```

Add additional subdomains as needed for your tenants.

### 8. Build Frontend Assets

Development mode with hot reload:

```bash
npm run dev
```

Production build:

```bash
npm run build
```

### 9. Start the Development Server

```bash
php artisan serve
```

The application will be available at:

-   **Central Dashboard**: http://central.localhost:8000 or http://localhost:8000
-   **Tenant Sites**: http://{subdomain}.localhost:8000

### 10. Create Initial Admin User

1. Register your first user by visiting:

    - http://central.localhost:8000/central/register

2. Update the user role in the database:

```sql
UPDATE users SET role = 'admin' WHERE email = 'your-email@example.com';
```

Or use a database management tool like pgAdmin or TablePlus to update the role field to `admin`.

## 🏗️ Architecture

### Multi-Tenant Structure

```
Central Domain (central.localhost)
├── Admin Dashboard
│   ├── Tenant Management (Create, Update, Delete)
│   ├── Tenant Request Management (Approve, Reject)
│   ├── Statistics (Total Tenants, Active, Pending Requests)
│   └── Admin Profile
└── Customer Portal
    ├── Tenant Request Submission
    ├── Request Status Tracking
    └── User Profile

Tenant Domains (*.localhost)
├── Isolated PostgreSQL Database (tenant_subdomain)
├── E-Commerce Store
│   ├── Homepage with Featured Products
│   ├── Product Catalog with Search
│   ├── Category Browsing
│   ├── Shopping Cart
│   └── Checkout & Orders
├── User Profile
│   ├── My Profile (All Users)
│   └── Management Dashboard (Admin/Manager/Owner Only)
└── Management Dashboard (Admin Access)
    ├── Product Management (CRUD)
    ├── Category Management (CRUD)
    └── Order Management (View, Update Status)
```

### User Roles & Permissions

#### Central Domain Roles

**Admin**

-   Access to central dashboard
-   Manage all tenants (create, update, activate, suspend, delete)
-   View tenant statistics
-   Approve/reject tenant requests
-   Access to tenant request management

**Customer (Default Role)**

-   Submit tenant requests
-   View own request status
-   Access to profile
-   No access to admin dashboard

#### Tenant Domain Roles

**Owner**

-   Full access to tenant management dashboard
-   Manage products, categories, orders
-   Access to all admin features

**Manager**

-   Access to tenant management dashboard
-   Manage products, categories, orders
-   Similar permissions to owner

**Admin**

-   Access to tenant management dashboard
-   Manage products and orders

**Customer (Default)**

-   Browse products
-   Add to cart and checkout
-   View orders
-   Manage profile
-   No access to management dashboard

### Database Schema

**Central Database (`central_db`):**

-   `users` - Admin and customer accounts with role field (admin, customer)
-   `tenants` - Tenant records with status (active, inactive, suspended)
-   `tenant_requests` - Customer submissions with status (pending, approved, rejected)
-   `personal_access_tokens` - Sanctum authentication tokens
-   `cache`, `jobs`, `sessions` - Laravel system tables

**Tenant Databases (`tenant_{subdomain}`):**

Each tenant has an isolated database with the following tables:

-   `users` - Tenant-specific user accounts with roles (owner, manager, admin, customer)
-   `products` - Product catalog with pricing, stock, images
-   `categories` - Product categories with icons and colors
-   `carts` - Shopping cart items
-   `cart_items` - Individual cart line items
-   `orders` - Customer orders with shipping info
-   `order_items` - Order line items
-   `personal_access_tokens` - Tenant-specific auth tokens

## 📡 API Endpoints

### Central Domain Endpoints

#### Authentication (Public)

| Method | Endpoint            | Description                   |
| ------ | ------------------- | ----------------------------- |
| POST   | `/central/register` | Register new central user     |
| POST   | `/central/login`    | Login to central dashboard    |
| POST   | `/central/logout`   | Logout from central dashboard |
| GET    | `/central/me`       | Get authenticated user info   |

**Request Body (Register/Login):**

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### Tenant Request Management

| Method | Endpoint                        | Description                    | Auth  |
| ------ | ------------------------------- | ------------------------------ | ----- |
| POST   | `/tenant-requests`              | Submit new tenant request      | No    |
| GET    | `/tenant-requests`              | Get all tenant requests        | Admin |
| POST   | `/tenant-requests/{id}/approve` | Approve and auto-create tenant | Admin |
| PATCH  | `/tenant-requests/{id}/status`  | Update request status          | Admin |
| DELETE | `/tenant-requests/{id}`         | Delete tenant request          | Admin |

**Submit Tenant Request:**

```json
{
    "business_name": "My Store",
    "contact_name": "John Doe",
    "email": "john@example.com",
    "phone": "+1234567890",
    "description": "I need an e-commerce platform for my business"
}
```

**Approve Tenant Request:**

```json
{
    "username": "tenant_admin",
    "password": "secure_password"
}
```

#### Tenant Management

| Method | Endpoint               | Description                | Auth  |
| ------ | ---------------------- | -------------------------- | ----- |
| POST   | `/tenants/register`    | Create new tenant manually | No    |
| GET    | `/getTenant`           | List all tenants           | Admin |
| GET    | `/tenants/stats`       | Get tenant statistics      | Admin |
| POST   | `/tenants`             | Create new tenant          | Admin |
| PATCH  | `/tenants/{id}/status` | Update tenant status       | Admin |
| DELETE | `/tenants/{id}`        | Delete tenant              | Admin |

**Create Tenant:**

```json
{
    "tenant_name": "mystore",
    "database_name": "tenant_mystore",
    "db_username": "mystore_user",
    "db_password": "secure_password",
    "status": "active"
}
```

**Update Tenant Status:**

```json
{
    "status": "active" // or "inactive", "suspended"
}
```

### Tenant Domain Endpoints

#### Authentication (Tenant-Specific)

| Method | Endpoint           | Description                   |
| ------ | ------------------ | ----------------------------- |
| POST   | `/tenant/register` | Register tenant user          |
| POST   | `/tenant/login`    | Login to tenant site          |
| POST   | `/tenant/logout`   | Logout from tenant site       |
| GET    | `/tenant/me`       | Get authenticated tenant user |
| GET    | `/tenant/status`   | Check tenant status           |

#### Product Management

| Method | Endpoint         | Description         |
| ------ | ---------------- | ------------------- |
| GET    | `/products`      | List all products   |
| POST   | `/products`      | Create new product  |
| GET    | `/products/{id}` | Get product details |
| PUT    | `/products/{id}` | Update product      |
| DELETE | `/products/{id}` | Delete product      |

**Create/Update Product:**

```json
{
    "name": "Product Name",
    "description": "Product description",
    "price": 29.99,
    "category_id": 1,
    "stock_quantity": 100,
    "image_url": "https://example.com/image.jpg"
}
```

#### Category Management

| Method | Endpoint      | Description         |
| ------ | ------------- | ------------------- |
| GET    | `/categories` | List all categories |
| POST   | `/categories` | Create new category |

**Create Category:**

```json
{
    "name": "Electronics",
    "description": "Electronic products"
}
```

#### Shopping Cart

| Method | Endpoint                     | Description               |
| ------ | ---------------------------- | ------------------------- |
| POST   | `/cart/add-to-cart`          | Add item to cart          |
| GET    | `/cart/view-cart`            | View cart contents        |
| PUT    | `/cart/update-item/{itemId}` | Update cart item quantity |
| DELETE | `/cart/remove-item/{itemId}` | Remove item from cart     |
| DELETE | `/cart/clear-cart`           | Clear entire cart         |

**Add to Cart:**

```json
{
    "product_id": 1,
    "quantity": 2
}
```

**Update Cart Item:**

```json
{
    "quantity": 5
}
```

#### Order Management

| Method | Endpoint              | Description            |
| ------ | --------------------- | ---------------------- |
| POST   | `/orders/checkout`    | Create order from cart |
| GET    | `/orders`             | Get user's orders      |
| GET    | `/orders/{id}`        | Get order details      |
| PUT    | `/orders/{id}/status` | Update order status    |
| DELETE | `/getallorders`       | Get all orders (admin) |

**Checkout:**

```json
{
    "shipping_address": "123 Main St, City, State 12345",
    "payment_method": "credit_card"
}
```

**Update Order Status:**

```json
{
    "status": "processing" // pending, processing, shipped, delivered, cancelled
}
```

## 🔒 Middleware

### `identify.tenant`

-   Identifies tenant by subdomain
-   Configures database connection to tenant's database
-   Returns 404 if tenant is not active
-   Applied to all tenant domain routes

### `check.tenant.status`

-   Lightweight status check before serving SPA
-   Prevents inactive tenants from accessing the application
-   Applied to catch-all routes

### `auth`

-   Laravel's built-in authentication middleware
-   Protects admin and user-specific endpoints

## 👥 User Roles

### Admin

-   Access to central dashboard
-   Manage all tenants (create, update)
-   View tenant statistics
-   Approve/reject tenant requests
-   Access to tenant request management

### Customer (Regular User)

-   Submit tenant requests
-   View own request status
-   No access to admin dashboard

## 🎨 Frontend Routes

### Central Domain Routes

| Path                 | Component         | Description               | Auth Required | Role Required |
| -------------------- | ----------------- | ------------------------- | ------------- | ------------- |
| `/`                  | Homepage          | Landing page with CTA     | No            | -             |
| `/central/register`  | RegisterCentral   | User registration         | No            | -             |
| `/central/login`     | LoginCentral      | User login                | No            | -             |
| `/central-dashboard` | CentralDashboard  | Admin dashboard           | Yes           | Admin         |
| `/profile`           | CentralProfile    | User profile & requests   | Yes           | -             |
| `/request-tenant`    | TenantRequestForm | Tenant request submission | No            | -             |
| `/404`               | NotFound          | 404 error page            | No            | -             |

### Tenant Domain Routes

| Path                | Component           | Description                       | Auth Required | Role Required       |
| ------------------- | ------------------- | --------------------------------- | ------------- | ------------------- |
| `/`                 | Home                | Store homepage with features      | Yes           | -                   |
| `/login`            | Login               | Tenant user login                 | No            | -                   |
| `/register`         | UserRegister        | Customer registration             | No            | -                   |
| `/products`         | Products            | Product catalog with filters      | Yes           | -                   |
| `/product/:id`      | ProductDetail       | Single product details            | Yes           | -                   |
| `/categories`       | Categories          | Category browsing                 | Yes           | -                   |
| `/cart`             | Cart                | Shopping cart                     | Yes           | -                   |
| `/checkout`         | Checkout            | Checkout page                     | Yes           | -                   |
| `/profile`          | Profile             | User profile & settings           | Yes           | -                   |
| `/dashboard`        | ManagementDashboard | Product/category/order management | Yes           | Manager/Owner/Admin |
| `/dashboard/orders` | Orders              | Order management                  | Yes           | Manager/Owner/Admin |

### Navigation Features

**Tenant Homepage Navigation:**

-   Profile dropdown menu (all users)
    -   **My Profile** - Access user profile
    -   **Management Dashboard** - Only visible to admin/manager/owner users
-   Shopping cart with item count
-   Product search
-   Category navigation
-   Logout button

## 🧪 Testing

This project includes comprehensive test coverage for multi-tenant functionality, data isolation, authentication, tenant management, and admin features. The test suite ensures that tenants are properly isolated, authentication works correctly, and all admin functions operate as expected.

### Setup Testing Environment

#### 1. Create a Test Database

Connect to PostgreSQL and create a testing database:

```sql
CREATE DATABASE testing;
```

Or using psql command line:

```bash
psql -U your_username -c "CREATE DATABASE testing;"
```

#### 2. Configure Test Environment

Create or update `.env.testing` in your project root:

```env
APP_ENV=testing
APP_KEY=base64:your_key_here
APP_DEBUG=true
APP_URL=http://localhost

# PostgreSQL Test Database
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=testing
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Testing Drivers (Use fast in-memory drivers)
CACHE_DRIVER=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync

# Sanctum Configuration
SANCTUM_STATEFUL_DOMAINS=localhost,central.localhost,*.localhost
SESSION_DOMAIN=.localhost
```

#### 3. Generate Application Key for Testing

```bash
php artisan key:generate --env=testing
```

### Running Tests

#### Run All Tests

```bash
# Run all tests with default output
php artisan test

# Run with detailed output
php artisan test --verbose

# Run with parallel execution (faster)
php artisan test --parallel
```

#### Run Specific Test Suites

```bash
# Run only Feature tests
php artisan test --testsuite=Feature

# Run only Unit tests
php artisan test --testsuite=Unit
```

#### Run Specific Test Files

```bash
# Run tenant isolation tests
php artisan test tests/Feature/TenantIsolationTest.php

# Run authentication tests
php artisan test tests/Feature/CentralAuthenticationTest.php

# Run tenant request tests
php artisan test tests/Feature/TenantRequestTest.php

# Run tenant management tests
php artisan test tests/Feature/TenantManagementTest.php
```

#### Run Specific Test Methods

```bash
# Run a single test by method name
php artisan test --filter=it_creates_isolated_tenant_database

# Run tests matching a pattern
php artisan test --filter=tenant

# Run multiple specific tests
php artisan test --filter="admin_can|customer_can"
```

#### Additional Test Options

```bash
# Stop on first failure (useful for debugging)
php artisan test --stop-on-failure

# Show test coverage (requires Xdebug or PCOV)
php artisan test --coverage

# Set minimum coverage threshold
php artisan test --coverage --min=80

# Run tests with profiling to identify slow tests
php artisan test --profile
```

### Test Coverage Overview

The test suite includes **45+ tests** covering all critical functionality:

#### 🔐 Tenant Isolation Tests (`TenantIsolationTest.php`)

Tests the core multi-tenant functionality and data isolation - **7 tests**:

```bash
php artisan test tests/Feature/TenantIsolationTest.php
```

-   ✅ **it_creates_isolated_tenant_database**
    -   Verifies that tenant database is created with correct naming convention
    -   Ensures connection is established successfully
-   ✅ **it_isolates_data_between_tenants**
    -   Creates two separate tenants with different databases
    -   Ensures data written to one tenant is not visible in another
    -   Validates complete data separation
-   ✅ **it_prevents_access_to_inactive_tenant**
    -   Sets tenant status to inactive
    -   Attempts to access tenant subdomain
    -   Verifies 404 response is returned
-   ✅ **it_prevents_access_to_suspended_tenant**
    -   Sets tenant status to suspended
    -   Attempts to access tenant subdomain
    -   Verifies 404 response is returned
-   ✅ **it_allows_access_to_active_tenant**
    -   Sets tenant status to active
    -   Accesses tenant subdomain
    -   Verifies successful response
-   ✅ **it_creates_tenant_with_required_tables**
    -   Creates tenant database
    -   Validates all required tables exist (users, products, categories, etc.)
    -   Ensures proper schema creation
-   ✅ **it_maintains_separate_user_bases_per_tenant**
    -   Creates users in different tenant databases
    -   Confirms user isolation across tenants
    -   Validates authentication boundaries

#### 📝 Tenant Request Tests (`TenantRequestTest.php`)

Tests the customer tenant request submission and approval workflow - **11 tests**:

```bash
php artisan test tests/Feature/TenantRequestTest.php
```

-   ✅ **customer_can_submit_tenant_request**
    -   Validates public submission without authentication
    -   Checks all required fields are saved
    -   Verifies default 'pending' status
-   ✅ **admin_can_view_all_tenant_requests**
    -   Admin authentication check
    -   Retrieves all tenant requests
    -   Validates response structure
-   ✅ **admin_can_approve_tenant_request**
    -   Admin approves pending request
    -   Verifies auto-provisioning of tenant database
    -   Confirms tenant creation and status update
-   ✅ **admin_can_reject_tenant_request**
    -   Admin rejects pending request
    -   Adds admin notes for rejection reason
    -   Validates status change to 'rejected'
-   ✅ **customer_can_view_their_own_requests**
    -   Authenticated customer views only their requests
    -   Ensures no access to other users' requests
    -   Validates user-specific filtering
-   ✅ **guest_cannot_view_tenant_requests**
    -   Unauthenticated access attempt
    -   Verifies 401 or redirect response
-   ✅ **it_validates_required_fields_for_tenant_request**
    -   Tests business_name validation
    -   Tests contact_name validation
    -   Tests email validation
    -   Tests phone validation
-   ✅ **it_validates_email_format**
    -   Rejects invalid email formats
    -   Accepts valid email formats
-   ✅ **admin_can_delete_tenant_request**
    -   Admin deletes a tenant request
    -   Verifies removal from database
-   ✅ **non_admin_cannot_approve_tenant_requests**
    -   Customer attempts approval
    -   Verifies 403 forbidden response
    -   Validates authorization middleware
-   ✅ **it_records_review_timestamp_when_status_changes**
    -   Updates request status
    -   Verifies reviewed_at timestamp is set
    -   Validates audit trail

#### 🏢 Tenant Management Tests (`TenantManagementTest.php`)

Tests admin tenant management functionality - **13 tests**:

```bash
php artisan test tests/Feature/TenantManagementTest.php
```

-   ✅ **admin_can_view_all_tenants**
    -   Admin retrieves full tenant list
    -   Validates response structure and data
-   ✅ **admin_can_view_tenant_statistics**
    -   Fetches dashboard statistics
    -   Validates counts (total, active, pending)
    -   Ensures accurate metrics
-   ✅ **admin_can_update_tenant_status**
    -   Changes tenant from active to inactive
    -   Changes tenant from inactive to suspended
    -   Validates status transitions
-   ✅ **admin_can_delete_tenant**
    -   Admin deletes a tenant
    -   Verifies tenant removal
    -   (Note: Database cleanup is manual)
-   ✅ **non_admin_cannot_manage_tenants**
    -   Regular user attempts tenant management
    -   Verifies 403 forbidden response
-   ✅ **guest_cannot_view_tenants**
    -   Unauthenticated access attempt
    -   Verifies authentication requirement
-   ✅ **tenant_slug_is_generated_correctly**
    -   Creates tenant with name
    -   Verifies slug generation (lowercase, no spaces)
    -   Tests special character handling
-   ✅ **admin_can_create_new_tenant**
    -   Admin creates tenant manually
    -   Provides all required credentials
    -   Validates successful creation
-   ✅ **it_validates_tenant_status_values**
    -   Tests invalid status values
    -   Ensures only valid statuses accepted
    -   Validates enum constraints
-   ✅ **tenant_list_includes_all_required_information**
    -   Checks response includes all fields
    -   Validates data structure
    -   Ensures no sensitive data exposure
-   ✅ **deleting_tenant_does_not_affect_other_tenants**
    -   Creates multiple tenants
    -   Deletes one tenant
    -   Verifies others remain intact

#### 🔑 Central Authentication Tests (`CentralAuthenticationTest.php`)

Tests central domain authentication and user management - **14 tests**:

```bash
php artisan test tests/Feature/CentralAuthenticationTest.php
```

-   ✅ **user_can_register_on_central_domain**
    -   New user registration
    -   Validates user creation in database
    -   Checks password hashing
-   ✅ **user_can_login_on_central_domain**
    -   User login with valid credentials
    -   Verifies authentication token/session
    -   Validates successful response
-   ✅ **user_cannot_login_with_invalid_credentials**
    -   Tests wrong password
    -   Tests non-existent email
    -   Validates error responses
-   ✅ **authenticated_user_can_logout**
    -   User logs out successfully
    -   Verifies session/token invalidation
-   ✅ **authenticated_user_can_get_their_info**
    -   Fetches current user data via /central/me
    -   Validates user object structure
    -   Ensures correct user data returned
-   ✅ **guest_cannot_access_protected_routes**
    -   Attempts to access admin routes
    -   Verifies 401 or redirect response
    -   Validates auth middleware
-   ✅ **it_validates_required_registration_fields**
    -   Tests name field requirement
    -   Tests email field requirement
    -   Tests password field requirement
-   ✅ **it_validates_password_confirmation**
    -   Mismatched password confirmation
    -   Ensures passwords must match
-   ✅ **it_validates_unique_email**
    -   Attempts duplicate email registration
    -   Validates uniqueness constraint
-   ✅ **it_validates_unique_username**
    -   Attempts duplicate username registration
    -   Validates uniqueness constraint
-   ✅ **newly_registered_users_have_customer_role_by_default**
    -   Registers new user
    -   Verifies default role is 'customer'
    -   Ensures proper role assignment
-   ✅ **user_cannot_login_without_email**
    -   Login attempt without email
    -   Validates validation error
-   ✅ **user_cannot_login_without_password**
    -   Login attempt without password
    -   Validates validation error

### Test Database Management

**Automatic Cleanup:**

-   Tests use Laravel's `RefreshDatabase` trait
-   Database is migrated fresh before each test class
-   All changes are rolled back after each test
-   Tenant databases created during tests are automatically dropped in `tearDown()`

**Manual Cleanup (if needed):**

```bash
# Drop all test databases
psql -U your_username -c "DROP DATABASE testing;"
psql -U your_username -c "CREATE DATABASE testing;"

# Or reset migrations
php artisan migrate:fresh --env=testing
```

### Writing New Tests

When adding new features, follow these testing best practices:

#### 1. Use Descriptive Test Names

```php
/** @test */
public function admin_can_update_product_inventory()
{
    // Test implementation
}

// Or using PHPUnit 10+ syntax
public function test_admin_can_update_product_inventory()
{
    // Test implementation
}
```

#### 2. Follow Arrange-Act-Assert Pattern

```php
public function test_user_can_add_product_to_cart()
{
    // Arrange - Set up test data
    $user = User::factory()->create();
    $product = Product::factory()->create(['stock' => 10]);

    // Act - Perform the action
    $response = $this->actingAs($user)->postJson('/cart/add-to-cart', [
        'product_id' => $product->id,
        'quantity' => 2
    ]);

    // Assert - Verify the outcome
    $response->assertStatus(200);
    $this->assertDatabaseHas('cart_items', [
        'product_id' => $product->id,
        'quantity' => 2
    ]);
}
```

#### 3. Use Factories for Test Data

```php
use App\Models\User;
use App\Models\Product;

$admin = User::factory()->create(['role' => 'admin']);
$products = Product::factory()->count(5)->create();
```

#### 4. Test Both Success and Failure Cases

```php
// Success case
public function test_admin_can_create_category()
{
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->postJson('/categories', [
        'name' => 'Electronics',
        'description' => 'Electronic products'
    ]);

    $response->assertStatus(201);
}

// Failure case
public function test_customer_cannot_create_category()
{
    $user = User::factory()->create(['role' => 'customer']);

    $response = $this->actingAs($user)->postJson('/categories', [
        'name' => 'Electronics'
    ]);

    $response->assertStatus(403);
}
```

#### 5. Test Validation Rules

```php
public function test_product_creation_requires_valid_data()
{
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->postJson('/products', [
        'name' => '', // Invalid: empty name
        'price' => -10, // Invalid: negative price
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['name', 'price']);
}
```

### Continuous Integration

For CI/CD pipelines, use these commands:

```bash
# GitHub Actions / GitLab CI
php artisan test --parallel --coverage --min=80

# Stop on first failure (fail fast)
php artisan test --stop-on-failure

# Output JUnit XML for CI tools
php artisan test --log-junit results.xml
```

### Test Performance

To identify slow tests and optimize performance:

```bash
# Profile tests to find slowest ones
php artisan test --profile

# Run only quick tests during development
php artisan test --group=quick

# Skip slow integration tests
php artisan test --exclude-group=slow
```

### Coverage Goals

Current test coverage targets:

-   **Overall**: 80%+ code coverage
-   **Critical paths**: 100% coverage (authentication, tenant isolation, payment)
-   **API endpoints**: Full request/response testing
-   **Authorization**: All permission scenarios covered

## 📦 Building for Production

### 1. Environment Configuration

Update your `.env` file for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Use strong, unique keys
APP_KEY=base64:your_production_key_here

# Production database
DB_CONNECTION=pgsql
DB_HOST=your_db_host
DB_PORT=5432
DB_DATABASE=central_db
DB_USERNAME=your_username
DB_PASSWORD=your_strong_password

# Production cache/session
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 2. Optimize Laravel

```bash
# Cache configuration files
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

### 3. Build Frontend Assets

```bash
# Production build with minification
npm run build

# Or with pnpm
pnpm run build
```

### 4. Set Proper Permissions

**Linux/Mac:**

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

**Windows (as Administrator):**

```powershell
icacls storage /grant "IIS AppPool\DefaultAppPool:(OI)(CI)F" /T
icacls bootstrap\cache /grant "IIS AppPool\DefaultAppPool:(OI)(CI)F" /T
```

### 5. Web Server Configuration

#### Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com *.yourdomain.com;
    root /var/www/tenant-hub/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Apache Configuration

```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias *.yourdomain.com
    DocumentRoot /var/www/tenant-hub/public

    <Directory /var/www/tenant-hub/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

### 6. Enable SSL/TLS

```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d yourdomain.com -d *.yourdomain.com

# Auto-renewal
sudo certbot renew --dry-run
```

### 7. Setup Supervisor for Queue Workers

Create `/etc/supervisor/conf.d/tenant-hub.conf`:

```ini
[program:tenant-hub-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/tenant-hub/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/tenant-hub/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start tenant-hub-worker:*
```

### 8. Setup Cron Jobs

Add to crontab:

```bash
* * * * * cd /var/www/tenant-hub && php artisan schedule:run >> /dev/null 2>&1
```

### 9. Security Checklist

-   ✅ Set `APP_DEBUG=false`
-   ✅ Use HTTPS everywhere
-   ✅ Set secure session cookies (`SESSION_SECURE_COOKIE=true`)
-   ✅ Enable CSRF protection
-   ✅ Use strong database passwords
-   ✅ Restrict file permissions (755 for directories, 644 for files)
-   ✅ Keep Laravel and dependencies updated
-   ✅ Configure firewall rules
-   ✅ Regular database backups
-   ✅ Monitor error logs

### 10. Performance Optimization

```bash
# Use OPcache
sudo apt-get install php8.2-opcache

# Use Redis for cache and sessions
sudo apt-get install redis-server php8.2-redis

# Enable HTTP/2
# Already enabled in modern Nginx/Apache with SSL

# Optimize database
# Add indexes to frequently queried columns
# Use database query caching
```

## 🔧 Development Commands

### Laravel Commands

```bash
# Start development server
php artisan serve

# Start on specific port
php artisan serve --port=8080

# Clear all caches
php artisan optimize:clear

# Individual cache clearing
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Database operations
php artisan migrate
php artisan migrate:fresh
php artisan migrate:fresh --seed
php artisan migrate:rollback
php artisan migrate:status

# Run queue worker (for background jobs)
php artisan queue:work
php artisan queue:listen

# View logs in real-time
php artisan pail

# Generate application key
php artisan key:generate

# List all routes
php artisan route:list

# Create model with migration and factory
php artisan make:model ModelName -mf

# Create controller
php artisan make:controller ControllerName

# Create middleware
php artisan make:middleware MiddlewareName
```

### Frontend Commands

```bash
# Start Vite development server with hot reload
npm run dev
# or
pnpm run dev

# Build for production
npm run build

# Build and watch for changes
npm run build -- --watch
```

### Composer Scripts

```bash
# Full setup (install, migrate, build)
composer setup

# Run development with concurrent servers
composer dev

# Run tests
composer test
```

### Database Management

```bash
# Access PostgreSQL
psql -U your_username -d central_db

# List all databases
psql -U your_username -l

# Drop a tenant database
psql -U your_username -c "DROP DATABASE tenant_subdomain;"

# Backup database
pg_dump -U your_username central_db > backup.sql

# Restore database
psql -U your_username central_db < backup.sql
```

### Common Development Tasks

**Create a new tenant manually:**

```bash
# Via API (as admin)
curl -X POST http://central.localhost:8000/tenants \
  -H "Content-Type: application/json" \
  -d '{
    "tenant_name": "mystore",
    "database_name": "tenant_mystore",
    "db_username": "mystore_user",
    "db_password": "secure_password"
  }'
```

**Check tenant status:**

```bash
curl http://mystore.localhost:8000/tenant/status
```

**Approve tenant request:**

```bash
# Via API (as admin)
curl -X POST http://central.localhost:8000/tenant-requests/{id}/approve \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "password123"
  }'
```

## 🐛 Troubleshooting

### Common Issues and Solutions

#### Issue: "SQLSTATE[08006] Could not connect to database"

**Solution:**

1. Verify PostgreSQL is running:

```bash
# Windows
Get-Service -Name postgresql*

# Linux/Mac
sudo systemctl status postgresql
```

2. Check database credentials in `.env`
3. Ensure database exists:

```bash
psql -U your_username -l
```

#### Issue: "Vite manifest not found"

**Solution:**

```bash
# Rebuild frontend assets
npm run build

# Or start dev server
npm run dev
```

#### Issue: "419 Page Expired" on form submission

**Solution:**

1. Clear config cache:

```bash
php artisan config:clear
```

2. Ensure CSRF token is included in forms
3. Check `SESSION_DOMAIN` in `.env` matches your domain

#### Issue: Subdomain routing not working

**Solution:**

1. Check hosts file includes subdomain entries:

```
127.0.0.1    tenant1.localhost
```

2. Restart browser after hosts file change
3. Clear browser cache
4. Verify `SESSION_DOMAIN=.localhost` in `.env`

#### Issue: "Class not found" errors

**Solution:**

```bash
# Regenerate autoload files
composer dump-autoload

# Clear config cache
php artisan config:clear
```

#### Issue: Tests failing with database errors

**Solution:**

1. Ensure test database exists:

```bash
psql -U your_username -c "CREATE DATABASE testing;"
```

2. Verify `.env.testing` configuration
3. Run migrations on test database:

```bash
php artisan migrate --env=testing
```

#### Issue: Permission denied on storage directory

**Solution:**

```bash
# Windows (run as Administrator)
icacls storage /grant "Everyone:(OI)(CI)F" /T
icacls bootstrap\cache /grant "Everyone:(OI)(CI)F" /T

# Linux/Mac
chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

#### Issue: Queue jobs not processing

**Solution:**

1. Start queue worker:

```bash
php artisan queue:work
```

2. Check failed jobs:

```bash
php artisan queue:failed
```

3. Retry failed jobs:

```bash
php artisan queue:retry all
```

#### Issue: Tenant database not created on approval

**Solution:**

1. Check PostgreSQL user has CREATE DATABASE privilege:

```sql
ALTER USER your_username CREATEDB;
```

2. Verify database credentials in tenant record
3. Check Laravel logs for errors:

```bash
tail -f storage/logs/laravel.log
```

### Performance Issues

**Slow page loads:**

```bash
# Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Use Redis for sessions/cache
# Update .env:
CACHE_DRIVER=redis
SESSION_DRIVER=redis
```

**High memory usage:**

```bash
# Optimize composer autoloader
composer dump-autoload --optimize

# Use OPcache (requires php-opcache extension)
```

### Getting Help

1. **Check logs:**

    - Laravel: `storage/logs/laravel.log`
    - PostgreSQL: Check PostgreSQL logs
    - Web server: Check Nginx/Apache error logs

2. **Enable debug mode temporarily:**

```env
APP_DEBUG=true
```

3. **Run Laravel's built-in debugger:**

```bash
php artisan tinker
```

4. **Database connection test:**

```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

## � Tech Stack

### Backend

-   **Laravel 12** - PHP Framework
-   **PostgreSQL 14+** - Relational Database
-   **Laravel Sanctum** - API Authentication
-   **PHPUnit** - Testing Framework

### Frontend

-   **Vue 3** - Progressive JavaScript Framework
-   **Vue Router 4** - Client-side routing
-   **Vite** - Build tool and dev server
-   **Tailwind CSS 3** - Utility-first CSS framework
-   **Axios** - HTTP client

### Development Tools

-   **Composer** - PHP dependency management
-   **pnpm/npm** - JavaScript package management
-   **Laravel Pail** - Log viewer
-   **Concurrently** - Run multiple commands

## �📝 Project Structure

```
tenant-hub/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # API Controllers
│   │   └── Middleware/       # Custom middleware (identify.tenant, etc.)
│   ├── Models/               # Eloquent models
│   └── Services/             # Business logic (TenantService)
├── database/
│   ├── factories/            # Model factories for testing
│   ├── migrations/           # Database migrations
│   │   └── tenant/          # Tenant-specific migrations
│   └── seeders/             # Database seeders
├── resources/
│   ├── js/
│   │   ├── components/      # Vue components
│   │   ├── composables/     # Vue composables (useAuth, etc.)
│   │   ├── pages/           # Vue pages
│   │   │   ├── AdminPage/   # Central admin pages
│   │   │   └── TenantPage/  # Tenant pages
│   │   └── router/          # Vue Router config
│   ├── css/                 # Stylesheets
│   └── views/               # Blade templates
├── routes/
│   ├── api.php              # API routes
│   └── web.php              # Web routes
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
└── public/                  # Public assets
```

## 🎯 Key Features Explained

### Multi-Tenant Isolation

Each tenant has:

-   **Separate PostgreSQL database** (tenant\_{subdomain})
-   **Isolated user authentication** (no shared sessions)
-   **Independent data** (products, orders, users)
-   **Status-based access control** (active/inactive/suspended)

### Profile Dropdown with Role-Based Access

The tenant homepage includes a smart profile dropdown that:

-   Shows **My Profile** link for all authenticated users
-   Displays **Management Dashboard** link only for admin/manager/owner roles
-   Provides quick navigation between user and admin contexts
-   Includes smooth animations and click-outside detection

### Automatic Tenant Provisioning

When an admin approves a tenant request:

1. Creates new PostgreSQL database
2. Runs tenant-specific migrations
3. Creates initial admin user
4. Updates tenant status to active
5. Sends notification (if configured)

## 🔐 Security Features

-   ✅ **CSRF Protection** - All forms protected
-   ✅ **SQL Injection Prevention** - Eloquent ORM parameterization
-   ✅ **XSS Protection** - Output escaping
-   ✅ **Mass Assignment Protection** - Model fillable/guarded
-   ✅ **Password Hashing** - Bcrypt hashing
-   ✅ **Session Security** - HTTP-only cookies
-   ✅ **Rate Limiting** - API throttling
-   ✅ **Role-Based Authorization** - Middleware protection
-   ✅ **Database Isolation** - Per-tenant databases

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards

-   Follow PSR-12 coding standards for PHP
-   Use ESLint and Prettier for JavaScript
-   Write tests for new features
-   Update documentation as needed

### Pull Request Guidelines

-   Ensure all tests pass (`php artisan test`)
-   Update README if adding new features
-   Keep PRs focused on a single feature/fix
-   Write clear commit messages

## 📞 Support

For support and questions:

-   **Issues**: [GitHub Issues](https://github.com/saymynamenow/tenant-hub/issues)
-   **Discussions**: [GitHub Discussions](https://github.com/saymynamenow/tenant-hub/discussions)
-   **Email**: support@tenanathub.com

## 🙏 Acknowledgments

Built with:

-   [Laravel](https://laravel.com)
-   [Vue.js](https://vuejs.org)
-   [Tailwind CSS](https://tailwindcss.com)
-   [Vite](https://vitejs.dev)

## 📈 Roadmap

Future enhancements planned:

-   [ ] Multi-language support (i18n)
-   [ ] Payment gateway integration (Stripe, PayPal)
-   [ ] Email notifications for tenant events
-   [ ] Advanced analytics dashboard
-   [ ] Custom domain support for tenants
-   [ ] Tenant-specific themes and branding
-   [ ] API documentation with Swagger/OpenAPI
-   [ ] Docker containerization
-   [ ] Automated backups
-   [ ] CDN integration for assets

---

**Built with ❤️ using Laravel and Vue.js**
