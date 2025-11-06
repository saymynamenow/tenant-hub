<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-sm sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center gap-4">
                    <RouterLink
                        to="/"
                        class="text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1"
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
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />
                        </svg>
                        Back
                    </RouterLink>
                    <h1 class="text-xl font-bold text-gray-900">
                        Product Details
                    </h1>
                </div>
            </div>
        </nav>

        <div v-if="loading" class="flex items-center justify-center py-20">
            <LoadingSpinner />
        </div>

        <div
            v-else-if="product"
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8"
        >
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Product Images -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <!-- Main Image -->
                        <div
                            class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden"
                        >
                            <img
                                v-if="product.image_url"
                                :src="product.image_url"
                                :alt="product.name"
                                class="w-full h-full object-cover"
                            />
                            <svg
                                v-else
                                class="w-32 h-32 text-gray-300"
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

                        <!-- Image Thumbnails -->
                        <div class="p-4 border-t border-gray-200">
                            <p class="text-sm font-medium text-gray-700 mb-3">
                                Additional Images
                            </p>
                            <div class="flex gap-2">
                                <div
                                    class="w-16 h-16 bg-gray-100 rounded border-2 border-blue-500 flex items-center justify-center cursor-pointer"
                                >
                                    <img
                                        v-if="product.image_url"
                                        :src="product.image_url"
                                        :alt="product.name"
                                        class="w-full h-full object-cover rounded"
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
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Product Info & Purchase -->
                <div class="space-y-4">
                    <!-- Product Header -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div
                            v-if="product.category"
                            class="inline-block px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium mb-3"
                        >
                            {{ product.category?.icon }}
                            {{ product.category?.name }}
                        </div>

                        <h1 class="text-2xl font-bold text-gray-900 mb-2">
                            {{ product.name }}
                        </h1>

                        <!-- Rating Section -->
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex text-yellow-400">
                                <span class="text-lg">★★★★★</span>
                            </div>
                            <span class="text-sm text-gray-600"
                                >(128 reviews)</span
                            >
                        </div>

                        <!-- Stock Status -->
                        <div class="flex items-center gap-2 mb-4">
                            <span
                                :class="[
                                    'px-3 py-1 rounded-full text-sm font-medium',
                                    product.stock > 0
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-red-100 text-red-700',
                                ]"
                            >
                                {{
                                    product.stock > 0
                                        ? `In Stock (${product.stock} available)`
                                        : "Out of Stock"
                                }}
                            </span>
                        </div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <div class="mb-4">
                            <span class="text-4xl font-bold text-gray-900"
                                >${{
                                    parseFloat(product.price).toFixed(2)
                                }}</span
                            >
                            <div class="flex items-center gap-2 mt-2">
                                <span
                                    v-if="product.original_price"
                                    class="text-lg text-gray-500 line-through"
                                >
                                    ${{
                                        parseFloat(
                                            product.original_price
                                        ).toFixed(2)
                                    }}
                                </span>
                                <span
                                    v-if="product.original_price"
                                    class="text-lg font-semibold text-red-600"
                                >
                                    -{{
                                        Math.round(
                                            ((product.original_price -
                                                product.price) /
                                                product.original_price) *
                                                100
                                        )
                                    }}%
                                </span>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                                >Quantity</label
                            >
                            <div
                                class="flex items-center border border-gray-300 rounded-lg w-fit"
                            >
                                <button
                                    @click="
                                        quantity = Math.max(1, quantity - 1)
                                    "
                                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition"
                                >
                                    −
                                </button>
                                <input
                                    v-model.number="quantity"
                                    type="number"
                                    min="1"
                                    :max="product.stock"
                                    class="w-16 text-center border-0 outline-none font-semibold"
                                />
                                <button
                                    @click="
                                        quantity = Math.min(
                                            product.stock,
                                            quantity + 1
                                        )
                                    "
                                    class="px-4 py-2 text-gray-600 hover:bg-gray-100 transition"
                                    :disabled="quantity >= product.stock"
                                >
                                    +
                                </button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <button
                                @click="addToCart"
                                :disabled="product.stock === 0 || addingToCart"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            >
                                <svg
                                    v-if="addingToCart"
                                    class="animate-spin h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    />
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    />
                                </svg>
                                <svg
                                    v-else
                                    class="w-5 h-5"
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
                                {{ addingToCart ? "Adding..." : "Add to Cart" }}
                            </button>

                            <button
                                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg transition"
                            >
                                Buy Now
                            </button>

                            <button
                                @click="toggleWishlist"
                                :class="[
                                    'w-full font-bold py-3 rounded-lg transition border-2',
                                    isWishlisted
                                        ? 'bg-red-50 text-red-600 border-red-300'
                                        : 'bg-white text-gray-700 border-gray-300 hover:border-gray-400',
                                ]"
                            >
                                <svg
                                    class="w-5 h-5 inline mr-2"
                                    :fill="
                                        isWishlisted ? 'currentColor' : 'none'
                                    "
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    />
                                </svg>
                                {{
                                    isWishlisted
                                        ? "Remove from Wishlist"
                                        : "Add to Wishlist"
                                }}
                            </button>
                        </div>
                    </div>

                    <!-- Seller Info -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="font-semibold text-gray-900 mb-3">
                            Seller Information
                        </h3>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Shop</span>
                                <span class="font-medium text-gray-900"
                                    >Official Store</span
                                >
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Rating</span>
                                <span class="text-yellow-500 font-medium"
                                    >4.8/5</span
                                >
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Response Time</span>
                                <span class="text-green-600 font-medium"
                                    >Fast</span
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details Section -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            Description
                        </h2>
                        <div class="prose prose-sm max-w-none text-gray-700">
                            <p>{{ product.description }}</p>
                            <p class="mt-4 text-gray-600">
                                This is a high-quality product designed to meet
                                your needs. It comes with excellent features and
                                superior durability.
                            </p>
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">
                            Specifications
                        </h2>
                        <div class="space-y-3">
                            <div
                                class="flex justify-between border-b border-gray-200 pb-3"
                            >
                                <span class="text-gray-600 font-medium"
                                    >SKU</span
                                >
                                <span class="text-gray-900 font-semibold">{{
                                    product.slug
                                }}</span>
                            </div>
                            <div
                                class="flex justify-between border-b border-gray-200 pb-3"
                            >
                                <span class="text-gray-600 font-medium"
                                    >Category</span
                                >
                                <span class="text-gray-900 font-semibold">{{
                                    product.category?.name || "Uncategorized"
                                }}</span>
                            </div>
                            <div
                                class="flex justify-between border-b border-gray-200 pb-3"
                            >
                                <span class="text-gray-600 font-medium"
                                    >Stock</span
                                >
                                <span class="text-gray-900 font-semibold"
                                    >{{ product.stock }} units</span
                                >
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 font-medium"
                                    >Added</span
                                >
                                <span class="text-gray-900 font-semibold">{{
                                    formatDate(product.created_at)
                                }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar: Shipping Info -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3
                            class="font-semibold text-gray-900 mb-4 flex items-center gap-2"
                        >
                            <svg
                                class="w-5 h-5 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                                />
                            </svg>
                            Shipping Info
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-2">
                                <svg
                                    class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span>Free shipping for orders over $50</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <svg
                                    class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span
                                    >Estimated delivery: 3-5 business days</span
                                >
                            </div>
                            <div class="flex items-start gap-2">
                                <svg
                                    class="w-5 h-5 text-green-600 mt-0.5 flex-shrink-0"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                <span>Easy returns within 30 days</span>
                            </div>
                        </div>
                    </div>

                    <!-- Trust & Safety -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3
                            class="font-semibold text-gray-900 mb-4 flex items-center gap-2"
                        >
                            <svg
                                class="w-5 h-5 text-blue-600"
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
                            Trust & Safety
                        </h3>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center gap-2">
                                <svg
                                    class="w-4 h-4 text-green-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Verified Seller
                            </li>
                            <li class="flex items-center gap-2">
                                <svg
                                    class="w-4 h-4 text-green-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Secure Payments
                            </li>
                            <li class="flex items-center gap-2">
                                <svg
                                    class="w-4 h-4 text-green-600"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                                Buyer Protection
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{ console.log(product) }}
        </div>
        <div v-else class="text-center py-20">
            <p class="text-gray-600 text-lg">Product not found</p>
        </div>

        <!-- Toast Notification -->
        <Transition name="slide">
            <div
                v-if="showToast"
                class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg"
            >
                {{ toastMessage }}
            </div>
        </Transition>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRoute, RouterLink, useRouter } from "vue-router";
import { useProductService } from "../../composables/useProductService";
import { useCartService } from "../../composables/useCartService";
import LoadingSpinner from "../../components/LoadingSpinner.vue";

export default {
    name: "ProductDetail",
    components: {
        LoadingSpinner,
        RouterLink,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        const { fetchProducts } = useProductService();
        const { addToCart: addToCartAPI } = useCartService();

        const product = ref(null);
        const loading = ref(true);
        const quantity = ref(1);
        const isWishlisted = ref(false);
        const showToast = ref(false);
        const toastMessage = ref("");
        const addingToCart = ref(false);

        const loadProduct = async () => {
            loading.value = true;
            try {
                const products = await fetchProducts();
                const productId = parseInt(route.params.id);
                product.value = products.find((p) => p.id === productId);
            } catch (error) {
                console.error("Failed to load product:", error);
            } finally {
                loading.value = false;
            }
        };

        const addToCart = async () => {
            if (product.value.stock === 0) {
                toastMessage.value = "This product is out of stock";
                showToast.value = true;
                return;
            }
            if (quantity.value > product.value.stock) {
                quantity.value = product.value.stock;
                toastMessage.value = `Only ${product.value.stock} ${product.value.name} available in stock.`;
                showToast.value = true;
                return;
            }

            addingToCart.value = true;
            try {
                await addToCartAPI(product.value.id, quantity.value);
                toastMessage.value = `Added ${quantity.value} ${product.value.name} to cart!`;
                showToast.value = true;
                quantity.value = 1;
                setTimeout(() => {
                    showToast.value = false;
                }, 3000);
            } catch (error) {
                console.error("Failed to add to cart:", error);
                toastMessage.value = "Failed to add product to cart";
                showToast.value = true;
            } finally {
                addingToCart.value = false;
            }
        };

        const toggleWishlist = () => {
            isWishlisted.value = !isWishlisted.value;
            toastMessage.value = isWishlisted.value
                ? "Added to wishlist!"
                : "Removed from wishlist!";
            showToast.value = true;
            setTimeout(() => {
                showToast.value = false;
            }, 2000);
        };

        const formatDate = (date) => {
            if (!date) return "N/A";
            return new Date(date).toLocaleDateString("en-US", {
                year: "numeric",
                month: "long",
                day: "numeric",
            });
        };

        onMounted(() => {
            loadProduct();
        });

        return {
            product,
            loading,
            quantity,
            isWishlisted,
            showToast,
            toastMessage,
            addingToCart,
            addToCart,
            toggleWishlist,
            formatDate,
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
