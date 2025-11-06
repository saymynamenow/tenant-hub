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
                                Discover Products
                            </h1>
                            <p class="text-gray-600 text-sm">
                                Find your perfect products
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Filters Sidebar -->
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <div
                        class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 sticky top-24"
                    >
                        <!-- Search Bar -->
                        <div class="mb-6">
                            <label
                                class="block text-sm font-bold text-gray-900 mb-3"
                                >🔍 Search</label
                            >
                            <input
                                v-model="filters.search"
                                type="text"
                                placeholder="Search products..."
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            />
                        </div>

                        <!-- Category Filter -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <label
                                class="block text-sm font-bold text-gray-900 mb-3"
                                >📁 Categories</label
                            >
                            <div class="space-y-2 max-h-48 overflow-y-auto">
                                <button
                                    @click="filters.category = ''"
                                    :class="[
                                        'w-full text-left px-3 py-2 rounded-lg transition font-medium text-sm',
                                        filters.category === ''
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'text-gray-700 hover:bg-gray-100',
                                    ]"
                                >
                                    All Categories
                                </button>
                                <button
                                    v-for="category in categories"
                                    :key="category.id"
                                    @click="filters.category = category.id"
                                    :class="[
                                        'w-full text-left px-3 py-2 rounded-lg transition font-medium text-sm flex justify-between items-center',
                                        filters.category === category.id
                                            ? 'bg-blue-100 text-blue-800'
                                            : 'text-gray-700 hover:bg-gray-100',
                                    ]"
                                >
                                    <span>{{ category.name }}</span>
                                    <span
                                        :class="[
                                            'text-xs px-2 py-1 rounded',
                                            filters.category === category.id
                                                ? 'bg-blue-200'
                                                : 'bg-gray-200',
                                        ]"
                                    >
                                        {{ category.products_count || 0 }}
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <label
                                class="block text-sm font-bold text-gray-900 mb-3"
                                >💰 Price Range</label
                            >
                            <div class="space-y-3">
                                <div>
                                    <label class="text-xs text-gray-600"
                                        >Min Price</label
                                    >
                                    <input
                                        v-model.number="filters.priceMin"
                                        type="number"
                                        placeholder="0"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                                    />
                                </div>
                                <div>
                                    <label class="text-xs text-gray-600"
                                        >Max Price</label
                                    >
                                    <input
                                        v-model.number="filters.priceMax"
                                        type="number"
                                        placeholder="9999"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition text-sm"
                                    />
                                </div>
                            </div>
                        </div>

                        <!-- Stock Filter -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <label
                                class="block text-sm font-bold text-gray-900 mb-3"
                                >📦 Availability</label
                            >
                            <div class="space-y-2">
                                <label class="flex items-center cursor-pointer">
                                    <input
                                        v-model="filters.inStock"
                                        type="checkbox"
                                        class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500"
                                    />
                                    <span class="ml-2 text-sm text-gray-700"
                                        >In Stock Only</span
                                    >
                                </label>
                            </div>
                        </div>

                        <!-- Reset Button -->
                        <button
                            @click="resetFilters"
                            class="w-full px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg transition"
                        >
                            Reset Filters
                        </button>
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="flex-1">
                    <!-- Top Bar with Sort and View Results -->
                    <div
                        class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
                    >
                        <div>
                            <p class="text-gray-700 font-medium">
                                Found
                                <span class="text-blue-600 font-bold">{{
                                    filteredProducts.length
                                }}</span>
                                products
                            </p>
                            <p class="text-sm text-gray-500">
                                Page {{ currentPage }} of
                                {{ totalPages || 1 }}
                            </p>
                        </div>
                        <div class="w-full sm:w-auto">
                            <label
                                class="text-sm font-medium text-gray-700 block mb-2 sm:mb-0 sm:inline mr-2"
                            >
                                Sort by:
                            </label>
                            <select
                                v-model="filters.sort"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            >
                                <option value="newest">Newest</option>
                                <option value="price-asc">
                                    Price: Low to High
                                </option>
                                <option value="price-desc">
                                    Price: High to Low
                                </option>
                                <option value="name-asc">Name: A to Z</option>
                                <option value="name-desc">Name: Z to A</option>
                            </select>
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

                    <!-- Empty State -->
                    <div
                        v-else-if="filteredProducts.length === 0"
                        class="text-center py-20"
                    >
                        <svg
                            class="w-20 h-20 text-gray-300 mx-auto mb-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M20.354 15.354A9 9 0 015.646 5.646 9 9 0 0120.354 15.354z"
                            ></path>
                        </svg>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">
                            No products found
                        </h2>
                        <p class="text-gray-600 mb-6">
                            Try adjusting your search or filters
                        </p>
                        <button
                            @click="resetFilters"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
                        >
                            Clear Filters
                        </button>
                    </div>

                    <!-- Products Grid -->
                    <div
                        v-else
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="product in paginatedProducts"
                            :key="product.id"
                            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition group cursor-pointer"
                            @click="goToProductDetail(product.id)"
                        >
                            <!-- Product Image -->
                            <div
                                class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden group-hover:from-gray-200 group-hover:to-gray-300 transition"
                            >
                                <img
                                    v-if="product.image_url"
                                    :src="product.image_url"
                                    :alt="product.name"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                />
                                <div
                                    v-else
                                    class="w-full h-full flex items-center justify-center"
                                >
                                    <svg
                                        class="w-12 h-12 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        ></path>
                                    </svg>
                                </div>

                                <!-- Stock Badge -->
                                <div class="absolute top-3 right-3">
                                    <span
                                        :class="[
                                            'px-3 py-1 rounded-full text-xs font-bold',
                                            product.stock > 0
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{
                                            product.stock > 0
                                                ? `${product.stock} in stock`
                                                : "Out of stock"
                                        }}
                                    </span>
                                </div>

                                <!-- Category Badge -->
                                <div class="absolute top-3 left-3">
                                    <span
                                        class="px-2 py-1 bg-blue-500 text-white text-xs font-semibold rounded"
                                    >
                                        {{
                                            getCategoryName(product.category_id)
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="p-4">
                                <!-- Product Name -->
                                <h3
                                    class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition"
                                >
                                    {{ product.name }}
                                </h3>

                                <!-- Product Description -->
                                <p
                                    class="text-sm text-gray-600 mb-3 line-clamp-2"
                                >
                                    {{
                                        product.description ||
                                        "High quality product"
                                    }}
                                </p>

                                <!-- Price and Actions -->
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600">
                                            Price
                                        </p>
                                        <p
                                            class="text-2xl font-bold text-blue-600"
                                        >
                                            ${{
                                                parseFloat(
                                                    product.price
                                                ).toFixed(2)
                                            }}
                                        </p>
                                    </div>
                                    <button
                                        @click.stop="addToCart(product)"
                                        :disabled="
                                            product.stock === 0 ||
                                            addingToCart.includes(product.id)
                                        "
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white font-semibold rounded-lg transition flex items-center gap-2"
                                    >
                                        <svg
                                            v-if="
                                                !addingToCart.includes(
                                                    product.id
                                                )
                                            "
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
                                            ></path>
                                        </svg>
                                        <svg
                                            v-else
                                            class="w-5 h-5 animate-spin"
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
                                            ></circle>
                                            <path
                                                class="opacity-75"
                                                fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                            ></path>
                                        </svg>
                                        {{
                                            product.stock === 0 ? "Out" : "Add"
                                        }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination Controls -->
                    <div
                        v-if="filteredProducts.length > 0"
                        class="flex justify-center items-center gap-2 mt-8"
                    >
                        <button
                            @click="currentPage = Math.max(1, currentPage - 1)"
                            :disabled="currentPage === 1"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 disabled:bg-gray-100 disabled:text-gray-400 text-gray-800 font-semibold rounded-lg transition"
                        >
                            ← Previous
                        </button>

                        <div class="flex items-center gap-1">
                            <button
                                v-for="page in totalPages"
                                :key="page"
                                @click="currentPage = page"
                                :class="[
                                    'px-3 py-2 rounded-lg font-semibold transition',
                                    currentPage === page
                                        ? 'bg-blue-600 text-white'
                                        : 'bg-gray-200 text-gray-800 hover:bg-gray-300',
                                ]"
                            >
                                {{ page }}
                            </button>
                        </div>

                        <button
                            @click="
                                currentPage = Math.min(
                                    totalPages,
                                    currentPage + 1
                                )
                            "
                            :disabled="currentPage === totalPages"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 disabled:bg-gray-100 disabled:text-gray-400 text-gray-800 font-semibold rounded-lg transition"
                        >
                            Next →
                        </button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Toast Notification -->
        <Transition name="fade">
            <div
                v-if="showToast"
                :class="[
                    'fixed bottom-4 right-4 px-6 py-4 rounded-lg shadow-lg text-white font-medium flex items-center gap-2',
                    toastType === 'success' ? 'bg-green-500' : 'bg-red-500',
                ]"
            >
                <svg
                    v-if="toastType === 'success'"
                    class="w-5 h-5"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                >
                    <path
                        fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
                {{ toastMessage }}
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { useProductService } from "../../composables/useProductService";
import { useCategoryService } from "../../composables/useCategoryService";
import { useCartService } from "../../composables/useCartService";

const router = useRouter();
const { fetchProducts } = useProductService();
const { fetchCategories } = useCategoryService();
const { addToCart: addToCartAPI } = useCartService();

const products = ref([]);
const categories = ref([]);
const loading = ref(false);
const showToast = ref(false);
const toastMessage = ref("");
const toastType = ref("success");
const addingToCart = ref([]);

const filters = ref({
    search: "",
    category: "",
    priceMin: null,
    priceMax: null,
    inStock: false,
    sort: "newest",
});

const currentPage = ref(1);
const itemsPerPage = 15;

const filteredProducts = computed(() => {
    let filtered = products.value.filter((product) => {
        // Search filter
        const matchesSearch =
            product.name
                .toLowerCase()
                .includes(filters.value.search.toLowerCase()) ||
            (product.description || "")
                .toLowerCase()
                .includes(filters.value.search.toLowerCase());

        // Category filter
        const matchesCategory =
            filters.value.category === "" ||
            product.category_id === filters.value.category;

        // Price filter
        const matchesPrice =
            (filters.value.priceMin === null ||
                product.price >= filters.value.priceMin) &&
            (filters.value.priceMax === null ||
                product.price <= filters.value.priceMax);

        // Stock filter
        const matchesStock = !filters.value.inStock || product.stock > 0;

        return matchesSearch && matchesCategory && matchesPrice && matchesStock;
    });

    // Sort
    if (filters.value.sort === "newest") {
        filtered.sort((a, b) => b.id - a.id);
    } else if (filters.value.sort === "price-asc") {
        filtered.sort((a, b) => a.price - b.price);
    } else if (filters.value.sort === "price-desc") {
        filtered.sort((a, b) => b.price - a.price);
    } else if (filters.value.sort === "name-asc") {
        filtered.sort((a, b) => a.name.localeCompare(b.name));
    } else if (filters.value.sort === "name-desc") {
        filtered.sort((a, b) => b.name.localeCompare(a.name));
    }

    return filtered;
});

const totalPages = computed(() => {
    return Math.ceil(filteredProducts.value.length / itemsPerPage);
});

const paginatedProducts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return filteredProducts.value.slice(start, end);
});

const getCategoryName = (categoryId) => {
    const category = categories.value.find((c) => c.id === categoryId);
    return category ? category.name : "Unknown";
};

const loadProducts = async () => {
    loading.value = true;
    try {
        const data = await fetchProducts();
        products.value = data;
    } catch (error) {
        console.error("Failed to load products:", error);
        showNotification("Failed to load products", "error");
    } finally {
        loading.value = false;
    }
};

const loadCategories = async () => {
    try {
        const data = await fetchCategories();
        categories.value = data;
    } catch (error) {
        console.error("Failed to load categories:", error);
    }
};

const resetFilters = () => {
    filters.value = {
        search: "",
        category: "",
        priceMin: null,
        priceMax: null,
        inStock: false,
        sort: "newest",
    };
    currentPage.value = 1;
};

const addToCart = async (product) => {
    if (product.stock === 0) {
        showNotification("This product is out of stock", "error");
        return;
    }

    addingToCart.value.push(product.id);
    try {
        await addToCartAPI(product.id, 1);
        showNotification(`${product.name} added to cart!`, "success");
    } catch (error) {
        console.error("Failed to add to cart:", error);
        showNotification("Failed to add product to cart", "error");
    } finally {
        addingToCart.value = addingToCart.value.filter(
            (id) => id !== product.id
        );
    }
};

const goToProductDetail = (productId) => {
    router.push(`/product/${productId}`);
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
    loadProducts();
    loadCategories();

    // Check if category filter is passed via query params
    const route = router.currentRoute.value;
    if (route.query.category) {
        filters.value.category = parseInt(route.query.category);
    }
});

// Reset pagination when filters change
watch(
    () => ({
        search: filters.value.search,
        category: filters.value.category,
        priceMin: filters.value.priceMin,
        priceMax: filters.value.priceMax,
        inStock: filters.value.inStock,
        sort: filters.value.sort,
    }),
    () => {
        currentPage.value = 1;
    }
);
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

.line-clamp-2 {
    display: -webkit-box;
    line-clamp: 2;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
