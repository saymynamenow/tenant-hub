<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Header -->
        <header class="bg-white shadow-md sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">
                                Central Admin Dashboard
                            </h1>
                            <p class="text-gray-600 mt-1">
                                Multi-Tenant Management System
                            </p>
                        </div>
                    </div>
                    <button
                        @click="showCreateModal = true"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition flex items-center gap-2"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>
                        Create New Tenant
                    </button>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Stats Cards -->
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
            >
                <div
                    class="bg-white rounded-xl shadow-sm p-6 border border-gray-200"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Tenants</p>
                            <p class="text-3xl font-bold text-gray-900">
                                {{ stats.total }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-sm p-6 border border-gray-200"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active</p>
                            <p class="text-3xl font-bold text-green-600">
                                {{ stats.active }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-sm p-6 border border-gray-200"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Inactive</p>
                            <p class="text-3xl font-bold text-gray-600">
                                {{ stats.inactive }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-gray-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                                />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-xl shadow-sm p-6 border border-gray-200"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">This Month</p>
                            <p class="text-3xl font-bold text-blue-600">
                                {{ stats.this_month }}
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div
                class="bg-white rounded-xl shadow-sm mb-6 border border-gray-200"
            >
                <div class="flex border-b border-gray-200">
                    <button
                        @click="activeTab = 'tenants'"
                        :class="[
                            'flex-1 px-6 py-4 text-sm font-semibold transition-colors',
                            activeTab === 'tenants'
                                ? 'text-blue-600 border-b-2 border-blue-600'
                                : 'text-gray-600 hover:text-gray-900',
                        ]"
                    >
                        <div class="flex items-center justify-center gap-2">
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                />
                            </svg>
                            Tenants ({{ stats.total }})
                        </div>
                    </button>
                    <button
                        @click="activeTab = 'requests'"
                        :class="[
                            'flex-1 px-6 py-4 text-sm font-semibold transition-colors',
                            activeTab === 'requests'
                                ? 'text-blue-600 border-b-2 border-blue-600'
                                : 'text-gray-600 hover:text-gray-900',
                        ]"
                    >
                        <div class="flex items-center justify-center gap-2">
                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                            Tenant Requests
                        </div>
                    </button>
                </div>
            </div>

            <!-- Tenants Tab Content -->
            <div v-show="activeTab === 'tenants'">
                <!-- Filters -->
                <div
                    class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200"
                >
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Search by name, email, or slug..."
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        />
                        <select
                            v-model="filters.status"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        >
                            <option value="">All Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                        <button
                            @click="loadTenants"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                        >
                            Apply Filters
                        </button>
                    </div>
                </div>

                <!-- Loading State -->
                <div
                    v-if="loading"
                    class="flex items-center justify-center py-20"
                >
                    <div
                        class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
                    ></div>
                </div>

                <!-- Tenants Table -->
                <div
                    v-else
                    class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200"
                >
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                    >
                                        Tenant
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                    >
                                        Database
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                    >
                                        Status
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                    >
                                        Created
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr
                                    v-for="tenant in tenants.data"
                                    :key="tenant.id"
                                    class="hover:bg-gray-50 transition"
                                >
                                    <td class="px-6 py-4">
                                        <div>
                                            <p
                                                class="font-semibold text-gray-900"
                                            >
                                                {{ tenant.name }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ tenant.email }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ tenant.slug }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <code
                                            class="bg-gray-100 px-2 py-1 rounded"
                                            >{{ tenant.database_name }}</code
                                        >
                                    </td>
                                    <td class="px-6 py-4">
                                        <select
                                            :value="tenant.status"
                                            @change="
                                                updateStatus(
                                                    tenant.id,
                                                    $event.target.value
                                                )
                                            "
                                            :class="[
                                                'px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer border-0 outline-none',
                                                tenant.status === 'active'
                                                    ? 'bg-green-100 text-green-800'
                                                    : tenant.status ===
                                                      'suspended'
                                                    ? 'bg-red-100 text-red-800'
                                                    : 'bg-gray-100 text-gray-800',
                                            ]"
                                        >
                                            <option value="active">
                                                Active
                                            </option>
                                            <option value="inactive">
                                                Inactive
                                            </option>
                                            <option value="suspended">
                                                Suspended
                                            </option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ formatDate(tenant.created_at) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <button
                                                @click="viewTenant(tenant)"
                                                class="text-blue-600 hover:text-blue-800 font-semibold text-sm"
                                            >
                                                View
                                            </button>
                                            <button
                                                @click="deleteTenant(tenant.id)"
                                                class="text-red-600 hover:text-red-800 font-semibold text-sm"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div
                        v-if="tenants.last_page > 1"
                        class="px-6 py-4 border-t border-gray-200 flex items-center justify-between"
                    >
                        <div class="text-sm text-gray-600">
                            Showing {{ tenants.from }} to {{ tenants.to }} of
                            {{ tenants.total }} results
                        </div>
                        <div class="flex gap-2">
                            <button
                                v-for="page in tenants.last_page"
                                :key="page"
                                @click="loadTenants(page)"
                                :class="[
                                    'px-3 py-1 rounded font-semibold text-sm',
                                    page === tenants.current_page
                                        ? 'bg-blue-600 text-white'
                                        : 'bg-gray-200 text-gray-800 hover:bg-gray-300',
                                ]"
                            >
                                {{ page }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requests Tab Content -->
            <div v-show="activeTab === 'requests'">
                <TenantRequestsTable
                    ref="requestsTable"
                    @requestApproved="handleRequestApproved"
                />
            </div>
        </main>

        <!-- Create Tenant Modal -->
        <div
            v-if="showCreateModal"
            @click.self="showCreateModal = false"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-auto"
            >
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-900">
                        Create New Tenant
                    </h2>
                    <p class="text-gray-600 mt-1">
                        Set up a new tenant with isolated database
                    </p>
                </div>

                <form @submit.prevent="createTenant" class="p-6 space-y-6">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Tenant Name *</label
                        >
                        <input
                            v-model="form.name"
                            type="text"
                            required
                            placeholder="Enter tenant name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Username *</label
                        >
                        <input
                            v-model="form.username"
                            type="text"
                            required
                            placeholder="Enter username"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        />
                        <p class="text-xs text-gray-500 mt-1">
                            Username must be unique
                        </p>
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Password *</label
                        >
                        <input
                            v-model="form.password"
                            type="password"
                            required
                            minlength="6"
                            placeholder="Enter password (min. 6 characters)"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Confirm Password *</label
                        >
                        <input
                            v-model="form.password_confirmation"
                            type="password"
                            required
                            minlength="6"
                            placeholder="Re-enter password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            :class="{
                                'border-red-500':
                                    form.password &&
                                    form.password_confirmation &&
                                    form.password !==
                                        form.password_confirmation,
                            }"
                        />
                        <p
                            v-if="
                                form.password &&
                                form.password_confirmation &&
                                form.password !== form.password_confirmation
                            "
                            class="text-xs text-red-500 mt-1"
                        >
                            Passwords do not match
                        </p>
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button
                            type="submit"
                            :disabled="
                                submitting ||
                                form.password !== form.password_confirmation
                            "
                            class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white font-semibold rounded-lg transition"
                        >
                            {{ submitting ? "Creating..." : "Create Tenant" }}
                        </button>
                        <button
                            type="button"
                            @click="showCreateModal = false"
                            class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition"
                        >
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Toast Notification -->
        <Transition name="fade">
            <div
                v-if="showToast"
                :class="[
                    'fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg text-white font-medium',
                    toastType === 'success' ? 'bg-green-500' : 'bg-red-500',
                ]"
            >
                {{ toastMessage }}
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import api from "../../axios";
import { useAuth } from "../../composables/useAuthService";
import TenantRequestsTable from "../../components/TenantRequestsTable.vue";

const router = useRouter();
const { user, isAuthenticated } = useAuth();

const activeTab = ref("tenants");
const requestsTable = ref(null);

const tenants = ref({
    data: [],
    current_page: 1,
    last_page: 1,
    from: 0,
    to: 0,
    total: 0,
});
const stats = ref({
    total: 0,
    active: 0,
    inactive: 0,
    suspended: 0,
    this_month: 0,
});
const loading = ref(false);
const submitting = ref(false);
const showCreateModal = ref(false);
const showToast = ref(false);
const toastMessage = ref("");
const toastType = ref("success");

const filters = ref({
    search: "",
    status: "",
});

const form = ref({
    name: "",
    username: "",
    password: "",
    password_confirmation: "",
});

const loadStats = async () => {
    try {
        const response = await api.get("/tenants/stats", {
            withCredentials: true,
        });
        stats.value = response.data;
    } catch (error) {
        console.error("Failed to load stats:", error);
    }
};

const loadTenants = async (page = 1) => {
    loading.value = true;
    try {
        const response = await api.get("/getTenant", {
            params: {
                page,
                per_page: 15,
                search: filters.value.search,
                status: filters.value.status,
            },
            withCredentials: true,
        });
        tenants.value = response.data;
    } catch (error) {
        console.error("Failed to load tenants:", error);
        showNotification("Failed to load tenants", "error");
    } finally {
        loading.value = false;
    }
};

const createTenant = async () => {
    if (form.value.password !== form.value.password_confirmation) {
        showNotification("Passwords do not match", "error");
        return;
    }

    submitting.value = true;
    try {
        await api.post("/tenants/register", form.value, {
            withCredentials: true,
        });
        showNotification("Tenant created successfully!", "success");
        showCreateModal.value = false;
        resetForm();
        await loadTenants();
        await loadStats();
    } catch (error) {
        console.error("Failed to create tenant:", error);
        const message =
            error.response?.data?.error ||
            error.response?.data?.message ||
            "Failed to create tenant";
        showNotification(message, "error");
    } finally {
        submitting.value = false;
    }
};

const updateStatus = async (tenantId, status) => {
    try {
        await api.patch(
            `/tenants/${tenantId}/status`,
            {
                status,
            },
            {
                withCredentials: true,
            }
        );
        showNotification("Status updated successfully", "success");
        await loadStats();
    } catch (error) {
        console.error("Failed to update status:", error);
        showNotification("Failed to update status", "error");
        await loadTenants();
    }
};

const deleteTenant = async (tenantId) => {
    if (
        !confirm(
            "Are you sure? This will delete the tenant and all its data permanently!"
        )
    ) {
        return;
    }

    try {
        await api.delete(`/tenants/${tenantId}`, {
            withCredentials: true,
        });
        showNotification("Tenant deleted successfully", "success");
        await loadTenants();
        await loadStats();
    } catch (error) {
        console.error("Failed to delete tenant:", error);
        showNotification("Failed to delete tenant", "error");
    }
};

const viewTenant = (tenant) => {
    alert(
        `View tenant: ${tenant.name}\nDatabase: ${tenant.database_name}\nSlug: ${tenant.slug}`
    );
};

const resetForm = () => {
    form.value = {
        name: "",
        username: "",
        password: "",
        password_confirmation: "",
    };
};

const formatDate = (date) => {
    if (!date) return "N/A";
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
    });
};

const showNotification = (message, type = "success") => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;

    setTimeout(() => {
        showToast.value = false;
    }, 3000);
};

const handleRequestApproved = () => {
    loadStats();
    loadTenants();
    if (requestsTable.value) {
        requestsTable.value.loadRequests();
    }
};

onMounted(async () => {
    if (!isAuthenticated.value) {
        router.push("/central/login");
        return;
    }

    if (!user.value) {
        router.push("/central/login");
        return;
    }

    loadStats();
    loadTenants();
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
