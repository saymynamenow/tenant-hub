<template>
    <div
        class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow overflow-hidden"
    >
        <div
            class="w-full h-48 bg-gray-200 flex items-center justify-center overflow-hidden"
        >
            <img
                v-if="product.imageUrl"
                :src="product.imageUrl"
                :alt="product.name || 'Product image'"
                class="w-full h-full object-cover"
                loading="lazy"
            />
            <div v-else class="w-full h-full flex items-center justify-center">
                <svg
                    class="w-16 h-16 text-gray-400"
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
        <div class="p-4">
            <div class="flex items-start justify-between mb-2">
                <h3 class="font-semibold text-gray-900 flex-1">
                    {{ product.name }}
                </h3>
                <svg
                    class="w-5 h-5 text-gray-400 cursor-pointer hover:text-red-500"
                    fill="none"
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
            </div>
            <p class="text-sm text-gray-600 mb-3 line-clamp-2">
                {{ product.description || "High quality product" }}
            </p>
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-lg font-bold text-gray-900"
                        >${{ parseFloat(product.price).toFixed(2) }}</span
                    >
                    <span
                        v-if="product.original_price"
                        class="text-sm text-gray-500 line-through ml-2"
                        >${{
                            parseFloat(product.original_price).toFixed(2)
                        }}</span
                    >
                </div>
            </div>
            <div class="mt-4 flex gap-2">
                <button
                    @click="addToCart"
                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-medium"
                >
                    Add to Cart
                </button>
                <RouterLink
                    :to="{ name: 'ProductDetail', params: { id: product.id } }"
                    class="px-4 py-2 border border-gray-300 rounded-lg hover:border-gray-400 transition text-center"
                >
                    View
                </RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
import { RouterLink } from "vue-router";

export default {
    name: "ProductCard",
    components: {
        RouterLink,
    },
    props: {
        product: {
            type: Object,
            required: true,
        },
    },
    emits: ["add-to-cart"],
    methods: {
        addToCart() {
            this.$emit("add-to-cart", this.product);
        },
    },
};
</script>
