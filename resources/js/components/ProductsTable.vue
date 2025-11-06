<template>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                    >
                        Product
                    </th>
                    <th
                        class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                    >
                        Price
                    </th>
                    <th
                        class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                    >
                        Stock
                    </th>
                    <th
                        class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                    >
                        Status
                    </th>
                    <th
                        class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                    >
                        Image
                    </th>
                    <th
                        class="px-6 py-3 text-left text-sm font-semibold text-gray-900"
                    >
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr
                    v-for="product in products"
                    :key="product.id"
                    class="hover:bg-gray-50 transition"
                >
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ product.name }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        ${{ parseFloat(product.price).toFixed(2) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        {{ product.stock }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span
                            :class="[
                                'px-3 py-1 rounded-full text-xs font-semibold inline-block',
                                product.stock > 0
                                    ? 'bg-green-100 text-green-800'
                                    : 'bg-red-100 text-red-800',
                            ]"
                        >
                            {{
                                product.stock > 0 ? "In Stock" : "Out of Stock"
                            }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <img
                            v-if="product.imageUrl"
                            :src="product.imageUrl"
                            :alt="product.name"
                            class="h-10 w-10 rounded object-cover"
                        />
                        <span v-else class="text-gray-400 text-xs"
                            >No image</span
                        >
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <div class="flex gap-2">
                            <button
                                @click="$emit('edit', product)"
                                class="text-blue-600 hover:text-blue-900 font-medium hover:underline transition"
                            >
                                Edit
                            </button>
                            <button
                                @click="$emit('delete', product.id)"
                                class="text-red-600 hover:text-red-900 font-medium hover:underline transition"
                            >
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    name: "ProductsTable",
    props: {
        products: {
            type: Array,
            required: true,
        },
    },
    emits: ["edit", "delete"],
};
</script>
