<template>
    <div
        class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100 py-12 px-4 sm:px-6 lg:px-8"
    >
        <div class="max-w-4xl mx-auto">
            <!-- Header with Back Button -->
            <div class="mb-8">
                <RouterLink
                    to="/cart"
                    class="inline-flex items-center text-gray-600 hover:text-blue-600 transition mb-4"
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
                    Back to Cart
                </RouterLink>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">
                    Checkout
                </h1>
                <p class="text-gray-600 mt-2">Complete your purchase</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <form @submit.prevent="handleCheckout" class="space-y-6">
                        <!-- Shipping Address Section -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border border-gray-200"
                        >
                            <h2
                                class="text-xl font-semibold text-gray-900 mb-6"
                            >
                                Shipping Address
                            </h2>

                            <div class="space-y-4">
                                <!-- Full Name -->
                                <div>
                                    <label
                                        for="name"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Full Name *
                                    </label>
                                    <input
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                        placeholder="John Doe"
                                    />
                                </div>

                                <!-- Email -->
                                <div>
                                    <label
                                        for="email"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Email Address *
                                    </label>
                                    <input
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                        placeholder="john@example.com"
                                    />
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label
                                        for="phone"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Phone Number *
                                    </label>
                                    <input
                                        id="phone"
                                        v-model="form.phone"
                                        type="tel"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                        placeholder="+1 (555) 000-0000"
                                    />
                                </div>

                                <!-- Street Address -->
                                <div>
                                    <label
                                        for="street"
                                        class="block text-sm font-medium text-gray-700 mb-2"
                                    >
                                        Street Address *
                                    </label>
                                    <input
                                        id="street"
                                        v-model="form.street"
                                        type="text"
                                        required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                        placeholder="123 Main Street"
                                    />
                                </div>

                                <!-- City & State -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            for="city"
                                            class="block text-sm font-medium text-gray-700 mb-2"
                                        >
                                            City *
                                        </label>
                                        <input
                                            id="city"
                                            v-model="form.city"
                                            type="text"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                            placeholder="New York"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            for="state"
                                            class="block text-sm font-medium text-gray-700 mb-2"
                                        >
                                            State/Province *
                                        </label>
                                        <input
                                            id="state"
                                            v-model="form.state"
                                            type="text"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                            placeholder="NY"
                                        />
                                    </div>
                                </div>

                                <!-- Postal Code & Country -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            for="postal"
                                            class="block text-sm font-medium text-gray-700 mb-2"
                                        >
                                            Postal Code *
                                        </label>
                                        <input
                                            id="postal"
                                            v-model="form.postalCode"
                                            type="text"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                            placeholder="10001"
                                        />
                                    </div>
                                    <div>
                                        <label
                                            for="country"
                                            class="block text-sm font-medium text-gray-700 mb-2"
                                        >
                                            Country *
                                        </label>
                                        <input
                                            id="country"
                                            v-model="form.country"
                                            type="text"
                                            required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                            placeholder="United States"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Section -->
                        <div
                            class="bg-white rounded-xl shadow-sm p-6 border border-gray-200"
                        >
                            <h2
                                class="text-xl font-semibold text-gray-900 mb-6"
                            >
                                Payment Method
                            </h2>

                            <div class="space-y-4">
                                <!-- Credit Card Option -->
                                <label
                                    class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="
                                        form.paymentMethod === 'creditcard'
                                            ? 'border-blue-500 bg-blue-50'
                                            : 'border-gray-300 hover:border-gray-400'
                                    "
                                >
                                    <input
                                        v-model="form.paymentMethod"
                                        type="radio"
                                        value="creditcard"
                                        name="paymentMethod"
                                        class="w-4 h-4 text-blue-600"
                                    />
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center">
                                            <span
                                                class="font-semibold text-gray-900"
                                                >Credit Card</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Visa, Mastercard, American Express
                                        </p>
                                    </div>
                                </label>

                                <!-- Bank Transfer Option -->
                                <label
                                    class="flex items-center p-4 border-2 rounded-lg cursor-pointer transition"
                                    :class="
                                        form.paymentMethod === 'transfer'
                                            ? 'border-blue-500 bg-blue-50'
                                            : 'border-gray-300 hover:border-gray-400'
                                    "
                                >
                                    <input
                                        v-model="form.paymentMethod"
                                        type="radio"
                                        value="transfer"
                                        name="paymentMethod"
                                        class="w-4 h-4 text-blue-600"
                                    />
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center">
                                            <span
                                                class="font-semibold text-gray-900"
                                                >Bank Transfer</span
                                            >
                                        </div>
                                        <p class="text-sm text-gray-600 mt-1">
                                            Direct transfer from your bank
                                            account
                                        </p>
                                    </div>
                                </label>

                                <!-- Validation Message -->
                                <div
                                    v-if="paymentMethodError"
                                    class="flex items-center gap-2 text-red-600 text-sm mt-4"
                                >
                                    <svg
                                        class="w-4 h-4"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                    {{ paymentMethodError }}
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="isProcessing"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 disabled:from-gray-400 disabled:to-gray-500 text-white font-bold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center"
                        >
                            <svg
                                v-if="isProcessing"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            {{
                                isProcessing
                                    ? "Processing..."
                                    : "Complete Purchase"
                            }}
                        </button>
                    </form>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 sticky top-8 border border-gray-200"
                    >
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">
                            Order Summary
                        </h2>

                        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                            <div
                                v-for="item in cartItems"
                                :key="item.id"
                                class="flex items-center justify-between py-3 border-b border-gray-200"
                            >
                                <div class="flex-1">
                                    <p
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{
                                            item.product?.name ||
                                            item.name ||
                                            "Product"
                                        }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        Qty: {{ item.quantity }}
                                    </p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900">
                                    ${{
                                        (
                                            (item.product?.price ||
                                                item.price ||
                                                0) * item.quantity
                                        ).toFixed(2)
                                    }}
                                </p>
                            </div>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-3 border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900"
                                    >${{ subtotal.toFixed(2) }}</span
                                >
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-gray-900"
                                    >${{ shipping.toFixed(2) }}</span
                                >
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium text-gray-900"
                                    >${{ tax.toFixed(2) }}</span
                                >
                            </div>
                            <div
                                class="flex justify-between text-lg font-bold pt-3 border-t border-gray-200"
                            >
                                <span class="text-gray-900">Total</span>
                                <span class="text-blue-600"
                                    >${{ total.toFixed(2) }}</span
                                >
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
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { useCartService } from "../../composables/useCartService";
import { useCheckoutService } from "../../composables/useCheckoutService";

const router = useRouter();
const { fetchCart } = useCartService();
const { checkout } = useCheckoutService();

const cartItems = ref([]);
const isProcessing = ref(false);
const showToast = ref(false);
const toastMessage = ref("");
const toastType = ref("success");
const paymentMethodError = ref("");

const form = ref({
    name: "",
    email: "",
    phone: "",
    street: "",
    city: "",
    state: "",
    postalCode: "",
    country: "",
    paymentMethod: "creditcard",
});

const subtotal = computed(() => {
    return cartItems.value.reduce(
        (sum, item) =>
            sum + (item.product?.price || item.price || 0) * item.quantity,
        0
    );
});

const shipping = computed(() => {
    return subtotal.value > 100 ? 0 : 10;
});

const tax = computed(() => {
    return subtotal.value * 0.1;
});

const total = computed(() => {
    return subtotal.value + shipping.value + tax.value;
});

onMounted(async () => {
    try {
        const cart = await fetchCart();
        // Handle both array and object responses
        if (Array.isArray(cart)) {
            cartItems.value = cart;
        } else if (cart && Array.isArray(cart.items)) {
            cartItems.value = cart.items;
        } else {
            cartItems.value = [];
        }
    } catch (error) {
        console.error("Failed to load cart:", error);
        showNotification("Failed to load cart items", "error");
    }
});

const handleCheckout = async () => {
    paymentMethodError.value = "";

    if (!form.value.paymentMethod) {
        paymentMethodError.value = "Please select a payment method";
        return;
    }

    isProcessing.value = true;

    try {
        const address = `${form.value.street}, ${form.value.city}, ${form.value.state} ${form.value.postalCode}, ${form.value.country}`;

        const response = await checkout({
            address: address,
            paymentMethod: form.value.paymentMethod,
            idempotencyKey: crypto.randomUUID(),
        });

        showNotification("Order placed successfully!", "success");

        setTimeout(() => {
            router.push("/");
        }, 2000);
    } catch (error) {
        console.error("Checkout error:", error);
        showNotification(
            error.response?.data?.message ||
                "Checkout failed. Please try again.",
            "error"
        );
    } finally {
        isProcessing.value = false;
    }
};

const showNotification = (message, type = "success") => {
    toastMessage.value = message;
    toastType.value = type;
    showToast.value = true;

    setTimeout(() => {
        showToast.value = false;
    }, 3000);
};
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
