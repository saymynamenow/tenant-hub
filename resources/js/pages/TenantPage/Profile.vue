<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Header with Navigation -->
        <header class="bg-white shadow-md sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <RouterLink
                            to="/"
                            class="inline-flex items-center text-gray-600 hover:text-blue-600 transition"
                        >
                            <svg
                                class="w-5 h-5 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 19l-7-7 7-7"
                                ></path>
                            </svg>
                            Back
                        </RouterLink>
                        <div class="border-l border-gray-300 pl-4">
                            <h1
                                class="text-2xl sm:text-3xl font-bold text-gray-900"
                            >
                                My Profile
                            </h1>
                            <p class="text-gray-600 text-sm">
                                Manage your account and preferences
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Sidebar -->
                <aside class="lg:col-span-1">
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24"
                    >
                        <!-- User Avatar -->
                        <div class="text-center mb-6">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full mx-auto flex items-center justify-center text-white text-3xl font-bold"
                            >
                                {{ userInitials }}
                            </div>
                            <h3 class="mt-4 text-lg font-bold text-gray-900">
                                {{ user?.name || "User" }}
                            </h3>
                            <p class="text-sm text-gray-600">
                                {{ user?.email }}
                            </p>
                            <span
                                class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full"
                            >
                                {{ user?.role || "Customer" }}
                            </span>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="space-y-1">
                            <button
                                v-for="tab in tabs"
                                :key="tab.id"
                                @click="activeTab = tab.id"
                                :class="[
                                    'w-full text-left px-4 py-3 rounded-lg transition flex items-center gap-3',
                                    activeTab === tab.id
                                        ? 'bg-blue-50 text-blue-700 font-semibold'
                                        : 'text-gray-700 hover:bg-gray-50',
                                ]"
                            >
                                <component :is="tab.icon" class="w-5 h-5" />
                                <span>{{ tab.label }}</span>
                            </button>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="lg:col-span-3">
                    <!-- Account Info Tab -->

                    <!-- Orders Tab -->
                    <div
                        v-if="activeTab === 'orders'"
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
                    >
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">
                            Order History
                        </h2>

                        <!-- Loading State -->
                        <div v-if="loadingOrders" class="text-center py-12">
                            <div
                                class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"
                            ></div>
                        </div>

                        <!-- Empty State -->
                        <div
                            v-else-if="orders.length === 0"
                            class="text-center py-12"
                        >
                            <svg
                                class="w-16 h-16 text-gray-300 mx-auto mb-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                ></path>
                            </svg>
                            <p class="text-gray-600 text-lg">No orders yet</p>
                            <RouterLink
                                to="/products"
                                class="mt-4 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                            >
                                Start Shopping
                            </RouterLink>
                        </div>

                        <!-- Orders List -->
                        <div v-else class="space-y-4">
                            <div
                                v-for="order in orders"
                                :key="order.id"
                                class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition"
                            >
                                <div
                                    class="flex justify-between items-start mb-3"
                                >
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            Order #{{ order.id }}
                                        </p>
                                        <p
                                            class="text-lg font-bold text-gray-900"
                                        >
                                            ${{
                                                parseFloat(
                                                    order.total_amount
                                                ).toFixed(2)
                                            }}
                                        </p>
                                    </div>
                                    <span
                                        :class="[
                                            'px-3 py-1 rounded-full text-xs font-semibold',
                                            order.status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : order.status === 'processing'
                                                ? 'bg-blue-100 text-blue-800'
                                                : order.status === 'shipped'
                                                ? 'bg-purple-100 text-purple-800'
                                                : order.status === 'delivered'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{ order.status.toUpperCase() }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mb-3">
                                    <p>
                                        Date: {{ formatDate(order.created_at) }}
                                    </p>
                                    <p>
                                        Payment:
                                        {{
                                            order.payment_method ===
                                            "creditcard"
                                                ? "Credit Card"
                                                : "Bank Transfer"
                                        }}
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    <button
                                        @click="viewOrderDetails(order)"
                                        class="px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition text-sm font-semibold"
                                    >
                                        View Details
                                    </button>
                                    <button
                                        v-if="order.status === 'delivered'"
                                        class="px-4 py-2 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition text-sm font-semibold"
                                    >
                                        Buy Again
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Tab -->
                    <div
                        v-if="activeTab === 'security'"
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
                    >
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">
                            Security Settings
                        </h2>

                        <form
                            @submit.prevent="updatePassword"
                            class="space-y-6"
                        >
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Current Password</label
                                >
                                <input
                                    v-model="passwordForm.current_password"
                                    type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >New Password</label
                                >
                                <input
                                    v-model="passwordForm.new_password"
                                    type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required
                                />
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 mb-2"
                                    >Confirm New Password</label
                                >
                                <input
                                    v-model="passwordForm.confirm_password"
                                    type="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    required
                                />
                            </div>

                            <div class="flex gap-4">
                                <button
                                    type="submit"
                                    :disabled="updatingPassword"
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-semibold rounded-lg transition"
                                >
                                    {{
                                        updatingPassword
                                            ? "Updating..."
                                            : "Update Password"
                                    }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Settings Tab -->
                    <div
                        v-if="activeTab === 'settings'"
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-6"
                    >
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">
                            Preferences
                        </h2>

                        <div class="space-y-6">
                            <!-- Email Notifications -->
                            <div
                                class="flex items-center justify-between py-3 border-b border-gray-200"
                            >
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        Email Notifications
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Receive order updates via email
                                    </p>
                                </div>
                                <label
                                    class="relative inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="settings.emailNotifications"
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"
                                    ></div>
                                </label>
                            </div>

                            <!-- Marketing Emails -->
                            <div
                                class="flex items-center justify-between py-3 border-b border-gray-200"
                            >
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        Marketing Emails
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Receive promotional offers and news
                                    </p>
                                </div>
                                <label
                                    class="relative inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="settings.marketingEmails"
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"
                                    ></div>
                                </label>
                            </div>

                            <!-- SMS Notifications -->
                            <div
                                class="flex items-center justify-between py-3 border-b border-gray-200"
                            >
                                <div>
                                    <p class="font-semibold text-gray-900">
                                        SMS Notifications
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Receive text messages for important
                                        updates
                                    </p>
                                </div>
                                <label
                                    class="relative inline-flex items-center cursor-pointer"
                                >
                                    <input
                                        type="checkbox"
                                        v-model="settings.smsNotifications"
                                        class="sr-only peer"
                                    />
                                    <div
                                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"
                                    ></div>
                                </label>
                            </div>

                            <button
                                @click="saveSettings"
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                            >
                                Save Preferences
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Order Details Modal -->
        <div
            v-if="showOrderModal"
            @click.self="closeOrderModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[85vh] overflow-auto"
            >
                <div
                    class="flex items-center justify-between p-5 border-b border-gray-100"
                >
                    <h3 class="text-xl font-bold text-gray-900">
                        Order #{{ selectedOrder?.id }}
                    </h3>
                    <button
                        @click="closeOrderModal"
                        class="p-2 rounded-md hover:bg-gray-100"
                    >
                        <svg
                            class="w-5 h-5 text-gray-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>

                <div v-if="selectedOrder" class="p-6 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Amount</p>
                            <p class="text-2xl font-bold text-gray-900">
                                ${{
                                    parseFloat(
                                        selectedOrder.total_amount
                                    ).toFixed(2)
                                }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <p class="text-lg font-semibold text-gray-900">
                                {{ selectedOrder.status }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">
                            Shipping Address
                        </h4>
                        <p class="text-gray-600">
                            {{ selectedOrder.shipping_address }}
                        </p>
                    </div>

                    <div>
                        <h4 class="font-semibold text-gray-900 mb-2">Items</h4>
                        <div class="space-y-2">
                            <div
                                v-for="item in selectedOrder.items"
                                :key="item.id"
                                class="flex justify-between p-3 bg-gray-50 rounded-lg"
                            >
                                <div>
                                    <p class="font-semibold">
                                        {{ item.product?.name || "Product" }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Qty: {{ item.quantity }}
                                    </p>
                                </div>
                                <p class="font-bold">
                                    ${{
                                        (
                                            parseFloat(item.price) *
                                            item.quantity
                                        ).toFixed(2)
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
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
import { ref, computed, onMounted, h } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { useAuth } from "../../composables/useAuthService";
import { useOrderService } from "../../composables/useOrderService";

const router = useRouter();
const { user, fetchUser } = useAuth();
const { getOrders } = useOrderService();

const activeTab = ref("orders");
const orders = ref([]);
const loadingOrders = ref(false);
const updating = ref(false);
const updatingPassword = ref(false);
const showOrderModal = ref(false);
const selectedOrder = ref(null);
const showToast = ref(false);
const toastMessage = ref("");
const toastType = ref("success");

// Icon components
const UserIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        h("path", {
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
            "stroke-width": "2",
            d: "M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z",
        })
    );
const OrderIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        h("path", {
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
            "stroke-width": "2",
            d: "M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z",
        })
    );
const SecurityIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        h("path", {
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
            "stroke-width": "2",
            d: "M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z",
        })
    );
const SettingsIcon = () =>
    h(
        "svg",
        {
            class: "w-5 h-5",
            fill: "none",
            stroke: "currentColor",
            viewBox: "0 0 24 24",
        },
        h("path", {
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
            "stroke-width": "2",
            d: "M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z",
        }),
        h("path", {
            "stroke-linecap": "round",
            "stroke-linejoin": "round",
            "stroke-width": "2",
            d: "M15 12a3 3 0 11-6 0 3 3 0 016 0z",
        })
    );

const tabs = [{ id: "orders", label: "Order History", icon: OrderIcon }];

const profileForm = ref({
    name: "",
    email: "",
    phone: "",
    birthdate: "",
});

const passwordForm = ref({
    current_password: "",
    new_password: "",
    confirm_password: "",
});

const settings = ref({
    emailNotifications: true,
    marketingEmails: false,
    smsNotifications: true,
});

const userInitials = computed(() => {
    const name = user.value?.name || "U";
    const parts = name.split(" ");
    if (parts.length >= 2) {
        return (parts[0][0] + parts[1][0]).toUpperCase();
    }
    return name.substring(0, 2).toUpperCase();
});

const loadOrders = async () => {
    loadingOrders.value = true;
    try {
        const data = await getOrders();
        console.log("Fetched orders:", data);
        orders.value = data || [];
    } catch (error) {
        console.error("Failed to load orders:", error);
        showNotification("Failed to load orders", "error");
    } finally {
        loadingOrders.value = false;
    }
};

const updateProfile = async () => {
    updating.value = true;
    try {
        // TODO: Implement profile update API call
        await new Promise((resolve) => setTimeout(resolve, 1000));
        showNotification("Profile updated successfully", "success");
    } catch (error) {
        console.error("Failed to update profile:", error);
        showNotification("Failed to update profile", "error");
    } finally {
        updating.value = false;
    }
};

const resetProfileForm = () => {
    profileForm.value = {
        name: user.value?.name || "",
        email: user.value?.email || "",
        phone: "",
        birthdate: "",
    };
};

const updatePassword = async () => {
    if (
        passwordForm.value.new_password !== passwordForm.value.confirm_password
    ) {
        showNotification("Passwords do not match", "error");
        return;
    }

    updatingPassword.value = true;
    try {
        // TODO: Implement password update API call
        await new Promise((resolve) => setTimeout(resolve, 1000));
        showNotification("Password updated successfully", "success");
        passwordForm.value = {
            current_password: "",
            new_password: "",
            confirm_password: "",
        };
    } catch (error) {
        console.error("Failed to update password:", error);
        showNotification("Failed to update password", "error");
    } finally {
        updatingPassword.value = false;
    }
};

const saveSettings = () => {
    showNotification("Preferences saved successfully", "success");
};

const viewOrderDetails = (order) => {
    selectedOrder.value = order;
    showOrderModal.value = true;
};

const closeOrderModal = () => {
    showOrderModal.value = false;
    selectedOrder.value = null;
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

onMounted(async () => {
    await fetchUser();
    resetProfileForm();
    if (activeTab.value === "orders") {
        loadOrders();
    }
});

// Watch activeTab to load orders when switching to orders tab
import { watch } from "vue";
watch(activeTab, (newTab) => {
    if (newTab === "orders" && orders.value.length === 0) {
        loadOrders();
    }
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
