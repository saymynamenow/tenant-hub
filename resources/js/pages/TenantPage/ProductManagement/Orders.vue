<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Header with Navigation -->
        <header class="bg-white shadow-md sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <RouterLink
                            to="/dashboard"
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
                                Orders
                            </h1>
                            <p class="text-gray-600 text-sm">
                                Manage and track all customer orders
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Filters Section -->
            <div
                class="bg-white rounded-xl shadow-sm p-4 sm:p-6 mb-6 border border-gray-200"
            >
                <h2 class="text-lg font-semibold text-gray-900 mb-4">
                    Filters
                </h2>
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4"
                >
                    <!-- Search -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Search Order ID</label
                        >
                        <input
                            v-model="filters.search"
                            type="text"
                            placeholder="Search..."
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        />
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                            >Status</label
                        >
                        <select
                            v-model="filters.status"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        >
                            <option value="">All Statuses</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Sort By
                        </label>
                        <select
                            v-model="filters.sort"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        >
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="amount-high">Highest Amount</option>
                            <option value="amount-low">Lowest Amount</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex items-center justify-center py-20">
                <div
                    class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"
                ></div>
            </div>

            <!-- Empty State -->
            <div
                v-else-if="filteredOrders.length === 0"
                class="text-center py-20"
            >
                <svg
                    class="w-32 h-32 text-gray-300 mx-auto mb-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    ></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    No orders found
                </h2>
                <p class="text-gray-600">Try adjusting your filters</p>
            </div>

            <!-- Orders Table -->
            <div v-else class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                >
                                    Order ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                >
                                    Customer
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                >
                                    Amount
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                >
                                    Payment
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider"
                                >
                                    Date
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
                                v-for="order in filteredOrders"
                                :key="order.id"
                                class="hover:bg-gray-50 transition"
                            >
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"
                                >
                                    #{{ order.id }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                                >
                                    {{ order.user?.name || "N/A" }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"
                                >
                                    ${{
                                        parseFloat(order.total_amount).toFixed(
                                            2
                                        )
                                    }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <span
                                        :class="[
                                            'px-3 py-1 rounded-full text-xs font-semibold',
                                            order.payment_method ===
                                            'creditcard'
                                                ? 'bg-blue-100 text-blue-800'
                                                : 'bg-green-100 text-green-800',
                                        ]"
                                    >
                                        {{
                                            order.payment_method ===
                                            "creditcard"
                                                ? "Credit Card"
                                                : "Bank Transfer"
                                        }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select
                                        :value="order.status"
                                        @change="
                                            handleStatusChange(order.id, $event)
                                        "
                                        :class="[
                                            'px-3 py-1 rounded-lg text-xs font-semibold cursor-pointer border-0 outline-none',
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
                                        <option value="pending">Pending</option>
                                        <option value="processing">
                                            Processing
                                        </option>
                                        <option value="shipped">Shipped</option>
                                        <option value="delivered">
                                            Delivered
                                        </option>
                                        <option value="cancelled">
                                            Cancelled
                                        </option>
                                    </select>
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                                >
                                    {{ formatDate(order.created_at) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button
                                        @click="viewOrderDetails(order.id)"
                                        class="text-blue-600 hover:text-blue-800 font-semibold transition"
                                    >
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Order Details Modal (improved UX) -->
        <div
            v-if="showDetailsModal"
            @click.self="closeDetailsModal"
            role="dialog"
            aria-modal="true"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 p-4"
        >
            <div
                class="bg-white rounded-2xl shadow-xl max-w-4xl w-full max-h-[85vh] overflow-auto ring-1 ring-black/5"
            >
                <!-- Header -->
                <div
                    class="flex items-center justify-between p-5 border-b border-gray-100"
                >
                    <div class="flex items-center gap-4">
                        <div class="text-sm text-gray-500">Order</div>
                        <h3 class="text-xl font-bold text-gray-900">
                            #{{ selectedOrder?.id }}
                        </h3>
                        <span
                            :class="[
                                'ml-3 px-3 py-1 rounded-full text-xs font-semibold',
                                getStatusColor(selectedOrder?.status || ''),
                            ]"
                        >
                            {{ (selectedOrder?.status || "N/A").toUpperCase() }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button
                            @click="closeDetailsModal"
                            aria-label="Close details"
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
                </div>

                <!-- Content -->
                <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left: Items -->
                    <div class="lg:col-span-2 space-y-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Customer</p>
                                <p class="font-semibold text-gray-900">
                                    {{ selectedOrder?.user?.name || "N/A" }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ selectedOrder?.user?.email || "" }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">Order date</p>
                                <p class="font-semibold text-gray-900">
                                    {{ formatDate(selectedOrder?.created_at) }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-3">
                                Shipping Address
                            </h4>
                            <div
                                class="bg-gray-50 p-4 rounded-lg flex justify-between items-start"
                            >
                                <div class="text-sm text-gray-700">
                                    {{
                                        selectedOrder?.shipping_address ||
                                        "No address provided"
                                    }}
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <button
                                        @click="copyShipping"
                                        class="text-sm px-3 py-1 bg-white border rounded-md hover:bg-gray-50"
                                    >
                                        Copy
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold mb-3">
                                Items ({{ selectedOrder?.items?.length || 0 }})
                            </h4>
                            <div class="space-y-3">
                                <div
                                    v-for="item in selectedOrder.items"
                                    :key="item.id"
                                    class="flex items-center gap-4 p-3 bg-white border rounded-lg"
                                >
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded overflow-hidden flex items-center justify-center"
                                    >
                                        <img
                                            v-if="
                                                item.product?.image_url ||
                                                item.product?.imageUrl
                                            "
                                            :src="
                                                item.product?.image_url ||
                                                item.product?.imageUrl
                                            "
                                            :alt="item.product?.name"
                                            class="w-full h-full object-cover"
                                        />
                                        <svg
                                            v-else
                                            class="w-8 h-8 text-gray-300"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 3h18v18H3V3z"
                                            ></path>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div
                                            class="flex justify-between items-start"
                                        >
                                            <div>
                                                <p
                                                    class="font-semibold text-gray-900"
                                                >
                                                    {{
                                                        item.product?.name ||
                                                        "Product"
                                                    }}
                                                </p>
                                                <p
                                                    class="text-sm text-gray-500"
                                                >
                                                    {{
                                                        item.product?.category
                                                            ?.name || ""
                                                    }}
                                                </p>
                                            </div>
                                            <div class="text-right">
                                                <p
                                                    class="font-semibold text-gray-900"
                                                >
                                                    ${{
                                                        parseFloat(
                                                            item.price
                                                        ).toFixed(2)
                                                    }}
                                                </p>
                                                <p
                                                    class="text-sm text-gray-500"
                                                >
                                                    Qty: {{ item.quantity }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2 text-sm text-gray-600">
                                            Subtotal:
                                            <span
                                                class="font-semibold text-gray-900"
                                                >${{
                                                    (
                                                        parseFloat(item.price) *
                                                        item.quantity
                                                    ).toFixed(2)
                                                }}</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Summary -->
                    <aside class="lg:col-span-1">
                        <div class="bg-gray-50 p-4 rounded-lg sticky top-6">
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-semibold text-gray-900 mb-4">
                                {{
                                    selectedOrder?.payment_method ===
                                    "creditcard"
                                        ? "Credit Card"
                                        : "Bank Transfer"
                                }}
                            </p>

                            <div class="border-t border-gray-200 pt-4">
                                <div
                                    class="flex justify-between items-center mb-2"
                                >
                                    <span class="text-sm text-gray-600"
                                        >Items</span
                                    >
                                    <span class="font-semibold text-gray-900"
                                        >${{
                                            (selectedOrder?.items || [])
                                                .reduce(
                                                    (s, it) =>
                                                        s +
                                                        parseFloat(it.price) *
                                                            it.quantity,
                                                    0
                                                )
                                                .toFixed(2)
                                        }}</span
                                    >
                                </div>
                                <div
                                    class="flex justify-between items-center mb-2"
                                >
                                    <span class="text-sm text-gray-600"
                                        >Shipping</span
                                    >
                                    <span class="font-semibold text-gray-900"
                                        >$0.00</span
                                    >
                                </div>
                                <div
                                    class="flex justify-between items-center mt-3 pt-3 border-t"
                                >
                                    <span class="text-sm text-gray-600"
                                        >Total</span
                                    >
                                    <span
                                        class="text-xl font-bold text-gray-900"
                                        >${{
                                            parseFloat(
                                                selectedOrder?.total_amount || 0
                                            ).toFixed(2)
                                        }}</span
                                    >
                                </div>
                            </div>

                            <div class="mt-4 space-y-2">
                                <button
                                    @click="closeDetailsModal"
                                    class="w-full px-4 py-2 bg-white border rounded-md"
                                >
                                    Close
                                </button>
                                <button
                                    @click="
                                        () =>
                                            showNotification(
                                                'Marked as processed (demo)',
                                                'success'
                                            )
                                    "
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-md"
                                >
                                    Mark Processed
                                </button>
                            </div>
                        </div>
                    </aside>
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
import { ref, computed, onMounted } from "vue";
import { useOrderService } from "../../../composables/useOrderService";

const { getAllAdminOrders, updateOrderStatus } = useOrderService();

const orders = ref([]);
const loading = ref(false);
const showDetailsModal = ref(false);
const selectedOrder = ref(null);
const showToast = ref(false);
const toastMessage = ref("");
const toastType = ref("success");

const filters = ref({
    search: "",
    status: "",
    sort: "newest",
});

const filteredOrders = computed(() => {
    let filtered = orders.value.filter((order) => {
        const matchesSearch =
            order.id.toString().includes(filters.value.search) ||
            (order.user?.name || "")
                .toLowerCase()
                .includes(filters.value.search.toLowerCase());
        const matchesStatus =
            filters.value.status === "" ||
            order.status === filters.value.status;
        return matchesSearch && matchesStatus;
    });

    // Sort
    if (filters.value.sort === "newest") {
        filtered.sort(
            (a, b) => new Date(b.created_at) - new Date(a.created_at)
        );
    } else if (filters.value.sort === "oldest") {
        filtered.sort(
            (a, b) => new Date(a.created_at) - new Date(b.created_at)
        );
    } else if (filters.value.sort === "amount-high") {
        filtered.sort((a, b) => b.total_amount - a.total_amount);
    } else if (filters.value.sort === "amount-low") {
        filtered.sort((a, b) => a.total_amount - b.total_amount);
    }

    return filtered;
});

const loadOrders = async () => {
    loading.value = true;
    try {
        const data = await getAllAdminOrders();
        orders.value = data;
    } catch (error) {
        console.error("Failed to load orders:", error);
        showNotification("Failed to load orders", "error");
    } finally {
        loading.value = false;
    }
};

const handleStatusChange = async (orderId, event) => {
    const newStatus = event.target.value;
    try {
        await updateOrderStatus(orderId, newStatus);
        const order = orders.value.find((o) => o.id === orderId);
        if (order) {
            order.status = newStatus;
        }
        if (selectedOrder.value && selectedOrder.value.id === orderId) {
            selectedOrder.value.status = newStatus;
        }
        showNotification("Order status updated successfully", "success");
    } catch (error) {
        console.error("Failed to update order status:", error);
        showNotification("Failed to update order status", "error");
        await loadOrders();
    }
};

const viewOrderDetails = (orderId) => {
    selectedOrder.value = orders.value.find((o) => o.id === orderId);
    showDetailsModal.value = true;
};

const closeDetailsModal = () => {
    showDetailsModal.value = false;
    selectedOrder.value = null;
};

const copyShipping = async () => {
    try {
        const addr = selectedOrder.value?.shipping_address || "";
        if (!addr) {
            showNotification("No shipping address to copy", "error");
            return;
        }
        await navigator.clipboard.writeText(addr);
        showNotification("Shipping address copied", "success");
    } catch (err) {
        console.error("Copy failed:", err);
        showNotification("Copy failed", "error");
    }
};

const resetFilters = () => {
    filters.value = {
        search: "",
        status: "",
        sort: "newest",
    };
};

const getStatusColor = (status) => {
    const colorMap = {
        pending: "bg-yellow-100 text-yellow-800",
        processing: "bg-blue-100 text-blue-800",
        shipped: "bg-purple-100 text-purple-800",
        delivered: "bg-green-100 text-green-800",
        cancelled: "bg-red-100 text-red-800",
    };
    return colorMap[status] || "bg-gray-100 text-gray-800";
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

onMounted(() => {
    loadOrders();
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
