<template>
    <div class="min-h-screen bg-gray-50">
        <Navigation />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">My Profile</h1>
                <p class="text-gray-600 mt-2">
                    Manage your account information and preferences
                </p>
            </div>

            <!-- Profile Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-center">
                            <div
                                class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-4"
                            >
                                <span class="text-4xl font-bold text-white">
                                    {{ userInitials }}
                                </span>
                            </div>
                            <h2 class="text-xl font-semibold text-gray-900">
                                {{ user?.name || "User" }}
                            </h2>
                            <p class="text-gray-600 mt-1">
                                {{ user?.email || "" }}
                            </p>
                            <div
                                class="mt-4 inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium"
                            >
                                Central Admin
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="bg-white rounded-lg shadow p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Quick Stats
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Total Tenants</span>
                                <span class="font-semibold text-gray-900"
                                    >--</span
                                >
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Active Since</span>
                                <span class="font-semibold text-gray-900">
                                    {{ formatDate(user?.created_at) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <!-- My Tenant Requests Section (for non-admin users) -->
                    <div
                        v-if="!isAdmin"
                        class="bg-white rounded-lg shadow p-6 mt-6"
                    >
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-semibold text-gray-900">
                                My Tenant Requests
                            </h3>
                            <button
                                @click="loadTenantRequests"
                                class="text-blue-600 hover:text-blue-700 font-medium text-sm"
                            >
                                <svg
                                    class="w-4 h-4 inline-block mr-1"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                                    />
                                </svg>
                                Refresh
                            </button>
                        </div>

                        <!-- Loading State -->
                        <div
                            v-if="requestsLoading"
                            class="flex justify-center py-8"
                        >
                            <div
                                class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"
                            ></div>
                        </div>

                        <!-- Requests List -->
                        <div
                            v-else-if="myRequests.length > 0"
                            class="space-y-4"
                        >
                            <div
                                v-for="request in myRequests"
                                :key="request.id"
                                class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div
                                            class="flex items-center gap-3 mb-2"
                                        >
                                            <h4
                                                class="text-lg font-semibold text-gray-900"
                                            >
                                                {{ request.business_name }}
                                            </h4>
                                            <span
                                                :class="[
                                                    'px-3 py-1 text-xs font-semibold rounded-full',
                                                    request.status === 'pending'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : request.status ===
                                                          'approved'
                                                        ? 'bg-green-100 text-green-800'
                                                        : 'bg-red-100 text-red-800',
                                                ]"
                                            >
                                                {{
                                                    request.status
                                                        .charAt(0)
                                                        .toUpperCase() +
                                                    request.status.slice(1)
                                                }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <strong>Contact:</strong>
                                            {{ request.contact_name }}
                                        </p>
                                        <p class="text-sm text-gray-600 mb-2">
                                            <strong>Email:</strong>
                                            {{ request.email }}
                                        </p>
                                        <p
                                            v-if="request.phone"
                                            class="text-sm text-gray-600 mb-2"
                                        >
                                            <strong>Phone:</strong>
                                            {{ request.phone }}
                                        </p>
                                        <p
                                            v-if="request.description"
                                            class="text-sm text-gray-600 mb-2"
                                        >
                                            <strong>Description:</strong>
                                            {{ request.description }}
                                        </p>
                                        <p class="text-sm text-gray-500 mt-2">
                                            <strong>Submitted:</strong>
                                            {{
                                                formatRequestDate(
                                                    request.created_at
                                                )
                                            }}
                                        </p>
                                        <p
                                            v-if="request.reviewed_at"
                                            class="text-sm text-gray-500"
                                        >
                                            <strong>Reviewed:</strong>
                                            {{
                                                formatRequestDate(
                                                    request.reviewed_at
                                                )
                                            }}
                                        </p>
                                        <div
                                            v-if="request.admin_notes"
                                            class="mt-3 p-3 bg-gray-50 rounded-lg"
                                        >
                                            <p
                                                class="text-sm font-medium text-gray-700 mb-1"
                                            >
                                                Admin Notes:
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                {{ request.admin_notes }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status Messages -->
                                <div
                                    v-if="request.status === 'pending'"
                                    class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg"
                                >
                                    <div class="flex items-start">
                                        <svg
                                            class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0 mt-0.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <p class="text-sm text-yellow-800">
                                            Your request is being reviewed.
                                            We'll notify you via email once it's
                                            processed.
                                        </p>
                                    </div>
                                </div>
                                <div
                                    v-else-if="request.status === 'approved'"
                                    class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg"
                                >
                                    <div class="flex items-start">
                                        <svg
                                            class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5"
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
                                        <p class="text-sm text-green-800">
                                            Congratulations! Your tenant account
                                            has been created. Check your email
                                            for login credentials.
                                        </p>
                                    </div>
                                </div>
                                <div
                                    v-else-if="request.status === 'rejected'"
                                    class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg"
                                >
                                    <div class="flex items-start">
                                        <svg
                                            class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>
                                        <p class="text-sm text-red-800">
                                            Unfortunately, your request was not
                                            approved. Please contact support for
                                            more information.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- No Requests -->
                        <div v-else class="text-center py-12">
                            <svg
                                class="w-16 h-16 text-gray-400 mx-auto mb-4"
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
                            <p class="text-gray-600 mb-4">
                                You haven't submitted any tenant requests yet.
                            </p>
                            <router-link
                                to="/request-tenant"
                                class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                            >
                                Submit a Request
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Navigation from "../../components/Navigation.vue";
import { useAuth } from "../../composables/useAuthService";

const { user } = useAuth();

const formData = ref({
    name: "",
    email: "",
});

const passwordData = ref({
    currentPassword: "",
    newPassword: "",
    confirmPassword: "",
});

const loading = ref(false);
const passwordLoading = ref(false);
const successMessage = ref("");
const errorMessage = ref("");
const passwordSuccess = ref("");
const passwordError = ref("");

const myRequests = ref([]);
const requestsLoading = ref(false);

const userInitials = computed(() => {
    if (!user.value?.name) return "U";
    return user.value.name
        .split(" ")
        .map((n) => n[0])
        .join("")
        .toUpperCase()
        .substring(0, 2);
});

const isAdmin = computed(() => user.value?.role === "admin");

const formatDate = (date) => {
    if (!date) return "Recently";
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "long",
    });
};

const formatRequestDate = (date) => {
    if (!date) return "N/A";
    return new Date(date).toLocaleDateString("en-US", {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

const loadTenantRequests = async () => {
    if (isAdmin.value) return; // Admins don't need to see their own requests

    requestsLoading.value = true;
    try {
        const response = await axios.get("/tenant-requests");
        // Filter requests by current user's email
        const allRequests = response.data.data || response.data;
        myRequests.value = Array.isArray(allRequests)
            ? allRequests.filter((req) => req.email === user.value?.email)
            : [];
    } catch (error) {
        console.error("Failed to load tenant requests:", error);
    } finally {
        requestsLoading.value = false;
    }
};

const updateProfile = async () => {
    loading.value = true;
    successMessage.value = "";
    errorMessage.value = "";

    try {
        // Add your profile update API call here
        // await api.updateProfile(formData.value);
        successMessage.value = "Profile updated successfully!";
        setTimeout(() => {
            successMessage.value = "";
        }, 3000);
    } catch (error) {
        errorMessage.value =
            error.response?.data?.message || "Failed to update profile";
    } finally {
        loading.value = false;
    }
};

const updatePassword = async () => {
    passwordLoading.value = true;
    passwordSuccess.value = "";
    passwordError.value = "";

    if (passwordData.value.newPassword !== passwordData.value.confirmPassword) {
        passwordError.value = "New passwords do not match";
        passwordLoading.value = false;
        return;
    }

    try {
        // Add your password update API call here
        // await api.updatePassword(passwordData.value);
        passwordSuccess.value = "Password updated successfully!";
        passwordData.value = {
            currentPassword: "",
            newPassword: "",
            confirmPassword: "",
        };
        setTimeout(() => {
            passwordSuccess.value = "";
        }, 3000);
    } catch (error) {
        passwordError.value =
            error.response?.data?.message || "Failed to update password";
    } finally {
        passwordLoading.value = false;
    }
};

onMounted(() => {
    if (user.value) {
        formData.value.name = user.value.name || "";
        formData.value.email = user.value.email || "";
    }

    // Load tenant requests for non-admin users
    if (!isAdmin.value) {
        loadTenantRequests();
    }
});
</script>
