<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
        <!-- Navigation Header -->
        <nav class="bg-white shadow-md sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
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
                                />
                            </svg>
                            Back
                        </RouterLink>
                        <div class="border-l border-gray-300 pl-4">
                            <h1
                                class="text-2xl sm:text-3xl font-bold text-gray-900"
                            >
                                Shopping Cart
                            </h1>
                            <p class="text-gray-600 text-sm">
                                Review your items before checkout
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div v-if="loading" class="flex items-center justify-center py-20">
                <LoadingSpinner />
            </div>

            <div v-else-if="cartItems.length === 0" class="text-center py-20">
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
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Your cart is empty
                </h2>
                <p class="text-gray-600 mb-6">
                    Add some products to get started!
                </p>
                <RouterLink
                    to="/"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg transition"
                >
                    Continue Shopping
                </RouterLink>
            </div>

            <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <!-- Cart Header -->
                        <div
                            class="border-b border-gray-200 px-6 py-4 bg-gray-50 flex justify-between items-center"
                        >
                            <h2 class="text-lg font-bold text-gray-900">
                                Cart Items ({{ cartItems.length }})
                            </h2>
                            <button
                                @click="confirmClearCart"
                                class="text-sm text-red-600 hover:text-red-700 font-medium"
                            >
                                Clear Cart
                            </button>
                        </div>

                        <!-- Cart Items List -->
                        <div class="divide-y divide-gray-200">
                            <div
                                v-for="item in cartItems"
                                :key="item.id"
                                class="p-6 hover:bg-gray-50 transition"
                            >
                                <div class="flex gap-4">
                                    <!-- Product Image -->
                                    <div
                                        class="w-24 h-24 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden"
                                    >
                                        <img
                                            v-if="item.product.image_url"
                                            :src="item.product.image_url"
                                            :alt="item.product.name"
                                            class="w-full h-full object-cover"
                                        />
                                        <svg
                                            v-else
                                            class="w-full h-full text-gray-300 p-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                            />
                                        </svg>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1">
                                        <RouterLink
                                            :to="{
                                                name: 'ProductDetail',
                                                params: { id: item.product.id },
                                            }"
                                            class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition"
                                        >
                                            {{ item.product.name }}
                                        </RouterLink>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ item.product.description }}
                                        </p>
                                        <div
                                            v-if="item.product.category"
                                            class="mt-2"
                                        >
                                            <span
                                                class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded"
                                            >
                                                {{ item.product.category.icon }}
                                                {{ item.product.category.name }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Price & Quantity -->
                                    <div
                                        class="text-right flex flex-col justify-between"
                                    >
                                        <div>
                                            <p
                                                class="text-2xl font-bold text-gray-900"
                                            >
                                                ${{
                                                    (
                                                        item.product.price *
                                                        item.quantity
                                                    ).toFixed(2)
                                                }}
                                            </p>
                                            <p class="text-sm text-gray-600">
                                                ${{
                                                    parseFloat(
                                                        item.product.price
                                                    ).toFixed(2)
                                                }}
                                                each
                                            </p>
                                        </div>

                                        <!-- Quantity Control -->
                                        <div
                                            class="flex items-center justify-end gap-2 mt-4"
                                        >
                                            <div
                                                class="flex items-center border border-gray-300 rounded-lg"
                                            >
                                                <button
                                                    @click="
                                                        updateQuantity(
                                                            item.id,
                                                            item.quantity - 1
                                                        )
                                                    "
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition"
                                                >
                                                    −
                                                </button>
                                                <input
                                                    v-model.number="
                                                        item.quantity
                                                    "
                                                    type="number"
                                                    min="1"
                                                    @change="
                                                        updateQuantity(
                                                            item.id,
                                                            item.quantity
                                                        )
                                                    "
                                                    class="w-12 text-center border-0 outline-none font-semibold"
                                                />
                                                <button
                                                    @click="
                                                        updateQuantity(
                                                            item.id,
                                                            item.quantity + 1
                                                        )
                                                    "
                                                    class="px-3 py-1 text-gray-600 hover:bg-gray-100 transition"
                                                >
                                                    +
                                                </button>
                                            </div>
                                            <button
                                                @click="removeFromCart(item.id)"
                                                class="ml-2 px-3 py-1 text-red-600 hover:bg-red-50 rounded transition font-medium"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div
                        class="bg-white rounded-lg shadow-sm overflow-hidden sticky top-20"
                    >
                        <div
                            class="border-b border-gray-200 px-6 py-4 bg-gray-50"
                        >
                            <h2 class="text-lg font-bold text-gray-900">
                                Order Summary
                            </h2>
                        </div>

                        <div class="p-6 space-y-4">
                            <!-- Subtotal -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold text-gray-900"
                                    >${{ subtotal.toFixed(2) }}</span
                                >
                            </div>

                            <!-- Shipping -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold text-gray-900"
                                    >${{ shipping.toFixed(2) }}</span
                                >
                            </div>

                            <!-- Tax -->
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Tax (10%)</span>
                                <span class="font-semibold text-gray-900"
                                    >${{ tax.toFixed(2) }}</span
                                >
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-200 pt-4">
                                <!-- Total -->
                                <div
                                    class="flex justify-between items-center mb-6"
                                >
                                    <span
                                        class="text-lg font-bold text-gray-900"
                                        >Total</span
                                    >
                                    <span
                                        class="text-2xl font-bold text-blue-600"
                                        >${{ total.toFixed(2) }}</span
                                    >
                                </div>

                                <!-- Checkout Button -->
                                <button
                                    @click="goToCheckout"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 rounded-lg transition mb-3"
                                >
                                    Proceed to Checkout
                                </button>

                                <!-- Continue Shopping -->
                                <RouterLink
                                    to="/"
                                    class="block w-full text-center border border-gray-300 text-gray-700 font-bold py-3 rounded-lg hover:bg-gray-50 transition"
                                >
                                    Continue Shopping
                                </RouterLink>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="border-t border-gray-200 px-6 py-4">
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                                >Promo Code</label
                            >
                            <div class="flex gap-2">
                                <input
                                    v-model="promoCode"
                                    type="text"
                                    placeholder="Enter code"
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                                />
                                <button
                                    @click="applyPromoCode"
                                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition text-sm"
                                >
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <Transition name="slide">
            <div
                v-if="showToast"
                :class="[
                    'fixed bottom-6 right-6 px-6 py-3 rounded-lg shadow-lg text-white font-medium',
                    toastType === 'success' ? 'bg-green-600' : 'bg-red-600',
                ]"
            >
                {{ toastMessage }}
            </div>
        </Transition>
    </div>
</template>

<script>
import { ref, computed, onMounted } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { useCartService } from "../../composables/useCartService";
import LoadingSpinner from "../../components/LoadingSpinner.vue";

export default {
    name: "Cart",
    components: {
        RouterLink,
        LoadingSpinner,
    },
    setup() {
        const router = useRouter();
        const { fetchCart, updateCartItem, removeFromCart, clearCart } =
            useCartService();

        const cartItems = ref([]);
        const loading = ref(true);
        const showToast = ref(false);
        const toastMessage = ref("");
        const toastType = ref("success");
        const promoCode = ref("");

        const subtotal = computed(() => {
            return cartItems.value.reduce(
                (sum, item) => sum + item.product.price * item.quantity,
                0
            );
        });

        const shipping = computed(() => {
            return subtotal.value > 50 ? 0 : 10;
        });

        const tax = computed(() => {
            return subtotal.value * 0.1;
        });

        const total = computed(() => {
            return subtotal.value + shipping.value + tax.value;
        });

        const loadCart = async () => {
            loading.value = true;
            try {
                const data = await fetchCart();
                cartItems.value = Array.isArray(data) ? data : data.items || [];
            } catch (error) {
                console.error("Failed to load cart:", error);
                showNotification("Failed to load cart", "error");
            } finally {
                loading.value = false;
            }
        };

        const updateQuantity = async (itemId, newQuantity) => {
            if (newQuantity < 1) {
                await removeFromCartHandler(itemId);
                return;
            }

            try {
                await updateCartItem(itemId, newQuantity);
                const item = cartItems.value.find((i) => i.id === itemId);
                if (item) {
                    item.quantity = newQuantity;
                }
                showNotification("Cart updated", "success");
            } catch (error) {
                console.error("Failed to update cart item:", error);
                showNotification("Failed to update quantity", "error");
                await loadCart();
            }
        };

        const removeFromCartHandler = async (itemId) => {
            try {
                await removeFromCart(itemId);
                cartItems.value = cartItems.value.filter(
                    (item) => item.id !== itemId
                );
                showNotification("Item removed from cart", "success");
            } catch (error) {
                console.error("Failed to remove item:", error);
                showNotification("Failed to remove item", "error");
            }
        };

        const confirmClearCart = () => {
            if (
                window.confirm(
                    "Are you sure you want to clear your entire cart?"
                )
            ) {
                clearCartHandler();
            }
        };

        const clearCartHandler = async () => {
            try {
                await clearCart();
                cartItems.value = [];
                showNotification("Cart cleared", "success");
            } catch (error) {
                console.error("Failed to clear cart:", error);
                showNotification("Failed to clear cart", "error");
            }
        };

        const applyPromoCode = () => {
            if (!promoCode.value.trim()) {
                showNotification("Please enter a promo code", "error");
                return;
            }
            showNotification(
                `Promo code "${promoCode.value}" applied!`,
                "success"
            );
            promoCode.value = "";
        };

        const goToCheckout = () => {
            router.push("/checkout");
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
            loadCart();
        });

        return {
            cartItems,
            loading,
            showToast,
            toastMessage,
            toastType,
            promoCode,
            subtotal,
            shipping,
            tax,
            total,
            updateQuantity,
            removeFromCart: removeFromCartHandler,
            confirmClearCart,
            applyPromoCode,
            goToCheckout,
        };
    },
};
</script>

<style scoped>
.slide-enter-active,
.slide-leave-active {
    transition: all 0.3s ease;
}

.slide-enter-from {
    transform: translateX(400px);
    opacity: 0;
}

.slide-leave-to {
    transform: translateX(400px);
    opacity: 0;
}
</style>
