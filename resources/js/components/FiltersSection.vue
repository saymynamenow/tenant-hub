<template>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search Input -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"
                    >Search Products</label
                >
                <input
                    :value="search"
                    @input="$emit('update:search', $event.target.value)"
                    type="text"
                    placeholder="Search by name..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                />
            </div>

            <!-- Stock Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"
                    >Stock Status</label
                >
                <select
                    :value="stockFilter"
                    @change="$emit('update:stock-filter', $event.target.value)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                >
                    <option value="">All Products</option>
                    <option value="in-stock">In Stock</option>
                    <option value="out-of-stock">Out of Stock</option>
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2"
                    >Sort By</label
                >
                <select
                    :value="sort"
                    @change="$emit('update:sort', $event.target.value)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                >
                    <option value="name-asc">Name (A-Z)</option>
                    <option value="name-desc">Name (Z-A)</option>
                    <option value="price-asc">Price (Low to High)</option>
                    <option value="price-desc">Price (High to Low)</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FiltersSection",
    props: {
        search: {
            type: String,
            default: "",
        },
        stockFilter: {
            type: String,
            default: "",
        },
        sort: {
            type: String,
            default: "name-asc",
        },
    },
    emits: ["update:search", "update:stock-filter", "update:sort"],
};
</script>
