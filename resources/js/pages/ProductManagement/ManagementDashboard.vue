<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <RouterLink
                            to="/"
                            class="inline-flex items-center text-gray-600 hover:text-blue-600 transition"
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
                                    d="M15 19l-7-7 7-7"
                                />
                            </svg>
                        </RouterLink>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">
                                Dashboard
                            </h1>
                            <p class="text-gray-600 mt-1">
                                Welcome to your eCommerce management system
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <RouterLink
                            to="/central-dashboard"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 flex items-center gap-2"
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
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                                />
                            </svg>
                            Central Admin
                        </RouterLink>
                        <button
                            @click="openAddModal"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow-md transition duration-200 flex items-center gap-2"
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
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Add Product
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex">
            <!-- Left Sidebar -->
            <aside
                class="w-64 bg-white shadow-sm min-h-screen py-6 sticky top-16"
            >
                <div class="px-6">
                    <!-- Navigation -->
                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Management
                    </h3>
                    <div class="space-y-2 mb-6">
                        <RouterLink
                            to="/dashboard"
                            class="w-full text-left px-4 py-2 rounded-lg transition duration-200 font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20.354 15.354A9 9 0 015.646 5.646 9 9 0 0120.354 15.354z"
                                />
                            </svg>
                            Products
                        </RouterLink>
                        <RouterLink
                            to="/dashboard/orders"
                            class="w-full text-left px-4 py-2 rounded-lg transition duration-200 font-medium text-gray-700 hover:bg-gray-100 flex items-center gap-2"
                        >
                            <svg
                                class="w-4 h-4"
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
                            Orders
                        </RouterLink>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 mb-4">
                        Categories
                    </h3>

                    <div class="space-y-2">
                        <button
                            @click="selectedCategory = null"
                            :class="[
                                'w-full text-left px-4 py-2 rounded-lg transition duration-200 font-medium',
                                selectedCategory === null
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-700 hover:bg-gray-100',
                            ]"
                        >
                            <svg
                                class="w-4 h-4 inline mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M20.354 15.354A9 9 0 015.646 5.646 9 9 0 0120.354 15.354z"
                                />
                            </svg>
                            All Products
                        </button>

                        <div
                            v-if="loadingCategories"
                            class="px-4 py-2 text-sm text-gray-500"
                        >
                            Loading categories...
                        </div>

                        <button
                            v-for="category in categories"
                            :key="category.id"
                            @click="selectedCategory = category.id"
                            :class="[
                                'w-full text-left px-4 py-2 rounded-lg transition duration-200 flex justify-between items-center',
                                selectedCategory === category.id
                                    ? 'bg-blue-600 text-white'
                                    : 'text-gray-700 hover:bg-gray-100',
                            ]"
                        >
                            <span>{{ category.name }}</span>
                            <span
                                :class="[
                                    'text-xs font-semibold px-2 py-1 rounded',
                                    selectedCategory === category.id
                                        ? 'bg-blue-700'
                                        : 'bg-gray-200',
                                ]"
                            >
                                {{ category.products_count }}
                            </span>
                        </button>
                    </div>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button
                            @click="openCategoryModal"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            New Category
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-8">
                <!-- Stats Section -->
                <StatsCards :stats="stats" />

                <!-- Filters Section -->
                <FiltersSection
                    v-model:search="filters.search"
                    v-model:stock-filter="filters.stockFilter"
                    v-model:sort="filters.sort"
                />

                <!-- Products Section -->
                <div class="mt-8">
                    <LoadingSpinner v-if="loading" />
                    <EmptyState v-else-if="filteredProducts.length === 0" />
                    <ProductsTable
                        v-else
                        :products="filteredProducts"
                        @edit="openEditModal"
                        @delete="handleDelete"
                    />
                </div>
            </main>
        </div>

        <!-- Product Modal -->
        <ProductModal
            v-if="showModal"
            :product="editingProduct"
            :loading="submitting"
            @save="handleSaveProduct"
            @close="closeModal"
        />

        <!-- Category Modal -->
        <CategoryModal
            v-if="showCategoryModal"
            :loading="submitting"
            @save="handleSaveCategory"
            @close="closeCategoryModal"
        />
    </div>
</template>

<script>
import { ref, computed, onMounted } from "vue";
import { RouterLink } from "vue-router";
import { useProductService } from "../../composables/useProductService";
import { useCategoryService } from "../../composables/useCategoryService";
import StatsCards from "../../components/StatsCards.vue";
import FiltersSection from "../../components/FiltersSection.vue";
import ProductsTable from "../../components/ProductsTable.vue";
import ProductModal from "../../components/ProductModal.vue";
import CategoryModal from "../../components/CategoryModal.vue";
import LoadingSpinner from "../../components/LoadingSpinner.vue";
import EmptyState from "../../components/EmptyState.vue";

export default {
    name: "ManagementDashboard",
    components: {
        RouterLink,
        StatsCards,
        FiltersSection,
        ProductsTable,
        ProductModal,
        CategoryModal,
        LoadingSpinner,
        EmptyState,
    },
    setup() {
        const products = ref([]);
        const categories = ref([]);
        const loading = ref(false);
        const loadingCategories = ref(false);
        const submitting = ref(false);
        const showModal = ref(false);
        const showCategoryModal = ref(false);
        const editingProduct = ref(null);
        const selectedCategory = ref(null);

        const filters = ref({
            search: "",
            stockFilter: "",
            sort: "name-asc",
        });

        const { fetchProducts, saveProduct, deleteProduct } =
            useProductService();
        const { fetchCategories, saveCategory } = useCategoryService();

        const filteredProducts = computed(() => {
            let filtered = products.value.filter((product) => {
                const matchesSearch = product.name
                    .toLowerCase()
                    .includes(filters.value.search.toLowerCase());
                const matchesFilter =
                    filters.value.stockFilter === "" ||
                    (filters.value.stockFilter === "in-stock" &&
                        product.stock > 0) ||
                    (filters.value.stockFilter === "out-of-stock" &&
                        product.stock === 0);
                const matchesCategory =
                    selectedCategory.value === null ||
                    product.category_id === selectedCategory.value;
                return matchesSearch && matchesFilter && matchesCategory;
            });
            if (filters.value.sort === "name-asc") {
                filtered.sort((a, b) => a.name.localeCompare(b.name));
            } else if (filters.value.sort === "name-desc") {
                filtered.sort((a, b) => b.name.localeCompare(a.name));
            } else if (filters.value.sort === "price-asc") {
                filtered.sort((a, b) => a.price - b.price);
            } else if (filters.value.sort === "price-desc") {
                filtered.sort((a, b) => b.price - a.price);
            }

            return filtered;
        });

        const stats = computed(() => ({
            totalProducts: filteredProducts.value.length,
            inStock: filteredProducts.value.filter((p) => p.stock > 0).length,
            outOfStock: filteredProducts.value.filter((p) => p.stock === 0)
                .length,
            totalValue: filteredProducts.value
                .reduce((sum, p) => sum + p.price * p.stock, 0)
                .toFixed(2),
        }));

        const getCategoryProductCount = (categoryId) => {
            return products.value.filter((p) => p.category_id === categoryId)
                .length;
        };

        const loadCategories = async () => {
            loadingCategories.value = true;
            try {
                const data = await fetchCategories();
                categories.value = data;
            } catch (error) {
                console.error("Failed to load categories:", error);
            } finally {
                loadingCategories.value = false;
            }
        };

        const loadProducts = async () => {
            loading.value = true;
            try {
                const data = await fetchProducts();
                products.value = data;
            } catch (error) {
                console.error("Failed to load products:", error);
            } finally {
                loading.value = false;
            }
        };

        const openAddModal = () => {
            editingProduct.value = null;
            showModal.value = true;
        };

        const openEditModal = (product) => {
            editingProduct.value = { ...product };
            showModal.value = true;
        };

        const closeModal = () => {
            showModal.value = false;
            editingProduct.value = null;
        };

        const handleSaveProduct = async (productData) => {
            submitting.value = true;
            try {
                await saveProduct(productData, editingProduct.value?.id);
                closeModal();
                await loadProducts();
            } catch (error) {
                console.error("Failed to save product:", error);
                throw error;
            } finally {
                submitting.value = false;
            }
        };

        const handleDelete = async (productId) => {
            if (
                window.confirm("Are you sure you want to delete this product?")
            ) {
                try {
                    await deleteProduct(productId);
                    await loadProducts();
                } catch (error) {
                    console.error("Failed to delete product:", error);
                }
            }
        };

        const openCategoryModal = () => {
            showCategoryModal.value = true;
        };

        const closeCategoryModal = () => {
            showCategoryModal.value = false;
        };

        const handleSaveCategory = async (categoryData) => {
            try {
                await saveCategory(categoryData);
                await loadCategories();
                closeCategoryModal();
            } catch (error) {
                console.error("Failed to save category:", error);
                throw error;
            }
        };

        onMounted(() => {
            loadProducts();
            loadCategories();
        });

        return {
            products,
            categories,
            loading,
            loadingCategories,
            submitting,
            showModal,
            showCategoryModal,
            editingProduct,
            selectedCategory,
            filters,
            filteredProducts,
            stats,
            openAddModal,
            openEditModal,
            closeModal,
            handleSaveProduct,
            handleDelete,
            getCategoryProductCount,
            openCategoryModal,
            closeCategoryModal,
            handleSaveCategory,
        };
    },
};
</script>
