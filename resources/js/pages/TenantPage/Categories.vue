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
                                Browse Categories
                            </h1>
                            <p class="text-gray-600 text-sm">
                                Explore products by category
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Top Bar -->
            <div
                class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4"
            >
                <div>
                    <p class="text-gray-700 font-medium">
                        Found
                        <span class="text-blue-600 font-bold">{{
                            categories.length
                        }}</span>
                        categories
                    </p>
                </div>
                <div class="w-full sm:w-auto">
                    <input
                        v-model="searchQuery"
                        type="text"
                        placeholder="Search categories..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                    />
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
                v-else-if="filteredCategories.length === 0"
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
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                    ></path>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    No categories found
                </h2>
                <p class="text-gray-600 mb-6">Try adjusting your search</p>
            </div>

            <!-- Categories Grid -->
            <div
                v-else
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6"
            >
                <div
                    v-for="category in filteredCategories"
                    :key="category.id"
                    @click="goToCategory(category)"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-lg transition group cursor-pointer"
                >
                    <!-- Category Header -->
                    <div
                        :style="{ background: category.color || '#3B82F6' }"
                        class="h-32 flex items-center justify-center relative overflow-hidden"
                    >
                        <!-- Pattern Background -->
                        <div class="absolute inset-0 opacity-10">
                            <div
                                class="absolute inset-0"
                                style="
                                    background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23fff\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 0h20v20H0z\'/%3E%3C/g%3E%3C/svg%3E');
                                    background-size: 20px 20px;
                                "
                            ></div>
                        </div>

                        <!-- Icon -->
                        <div
                            class="relative text-6xl transform group-hover:scale-110 transition-transform duration-300"
                        >
                            {{ category.icon || "📦" }}
                        </div>
                    </div>

                    <!-- Category Info -->
                    <div class="p-5">
                        <h3
                            class="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-600 transition"
                        >
                            {{ category.name }}
                        </h3>

                        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                            {{
                                category.description ||
                                "Explore our collection of products"
                            }}
                        </p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2 text-gray-600">
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
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                    ></path>
                                </svg>
                                <span class="text-sm font-semibold">
                                    {{ category.products_count || 0 }} products
                                </span>
                            </div>

                            <button
                                class="text-blue-600 hover:text-blue-700 font-semibold text-sm flex items-center gap-1"
                            >
                                Browse
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
                                        d="M9 5l7 7-7 7"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Products Link -->
            <div class="mt-8 text-center">
                <RouterLink
                    to="/products"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"
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
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                        ></path>
                    </svg>
                    View All Products
                </RouterLink>
            </div>
        </main>

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
import { RouterLink, useRouter } from "vue-router";
import { useCategoryService } from "../../composables/useCategoryService";

const router = useRouter();
const { fetchCategories } = useCategoryService();

const categories = ref([]);
const loading = ref(false);
const searchQuery = ref("");
const showToast = ref(false);
const toastMessage = ref("");
const toastType = ref("success");

const filteredCategories = computed(() => {
    if (!searchQuery.value) {
        return categories.value;
    }

    const query = searchQuery.value.toLowerCase();
    return categories.value.filter(
        (category) =>
            category.name.toLowerCase().includes(query) ||
            (category.description || "").toLowerCase().includes(query)
    );
});

const loadCategories = async () => {
    loading.value = true;
    try {
        const data = await fetchCategories();
        categories.value = data;
    } catch (error) {
        console.error("Failed to load categories:", error);
        showNotification("Failed to load categories", "error");
    } finally {
        loading.value = false;
    }
};

const goToCategory = (category) => {
    // Navigate to products page with category filter
    router.push({
        path: "/products",
        query: { category: category.id },
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
    loadCategories();
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

.line-clamp-2 {
    display: -webkit-box;
    line-clamp: 2;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
