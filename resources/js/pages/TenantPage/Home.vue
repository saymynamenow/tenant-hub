<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-5 h-5 text-white"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900"
                            >Store</span
                        >
                    </div>

                    <div class="hidden md:flex items-center gap-8">
                        <RouterLink
                            to="/products"
                            class="text-gray-600 hover:text-gray-900 font-medium"
                        >
                            Browse All
                        </RouterLink>
                        <RouterLink
                            to="/categories"
                            class="text-gray-600 hover:text-gray-900 font-medium"
                        >
                            Categories
                        </RouterLink>
                        <button
                            @click="scrollToSection('products')"
                            class="text-gray-600 hover:text-gray-900 font-medium"
                        >
                            Products
                        </button>
                        <a
                            href="#"
                            class="text-gray-600 hover:text-gray-900 font-medium"
                            >About</a
                        >
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <input
                                type="text"
                                placeholder="Search products..."
                                class="w-48 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />
                        </div>
                        <RouterLink
                            to="/profile"
                            class="text-gray-600 hover:text-gray-900 transition"
                            title="My Profile"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                />
                            </svg>
                        </RouterLink>
                        <div class="relative">
                            <RouterLink
                                to="/cart"
                                class="text-gray-600 hover:text-gray-900 transition"
                            >
                                <svg
                                    class="w-6 h-6"
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
                            </RouterLink>
                            <span
                                class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center"
                                >{{ cartCount }}</span
                            >
                        </div>
                        <button
                            @click="handleLogout"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium transition"
                        >
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <section
            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-20"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-5xl font-bold mb-4">Welcome to Our Store</h1>
                <p class="text-xl text-blue-100 mb-8">
                    Discover amazing products at unbeatable prices
                </p>
                <button
                    class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition"
                >
                    Start Shopping
                </button>
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">
                Featured Categories
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <CategoryCard
                    v-for="category in featuredCategories"
                    :key="category.id"
                    :category="category"
                />
            </div>
        </section>

        <section
            ref="productsSection"
            class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16"
        >
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900">
                    Featured Products
                </h2>
                <RouterLink
                    to="/products"
                    class="text-blue-600 hover:text-blue-700 font-semibold"
                >
                    View All →
                </RouterLink>
            </div>

            <div v-if="loadingProducts" class="text-center py-12">
                <LoadingSpinner />
            </div>

            <div v-else-if="products.length === 0" class="text-center py-12">
                <p class="text-gray-600 text-lg">No products available</p>
            </div>

            <div
                v-else
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6"
            >
                <ProductCard
                    v-for="product in products.slice(0, 8)"
                    :key="product.id"
                    :product="product"
                    @add-to-cart="handleAddToCart"
                />
            </div>
        </section>

        <section class="bg-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                    What Customers Say
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <TestimonialCard
                        v-for="testimonial in testimonials"
                        :key="testimonial.id"
                        :testimonial="testimonial"
                    />
                </div>
            </div>
        </section>

        <section
            class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-16"
        >
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-4">
                    Subscribe to Our Newsletter
                </h2>
                <p class="text-blue-100 mb-6">
                    Get exclusive deals and updates delivered to your inbox
                </p>
                <div class="flex gap-2">
                    <input
                        type="email"
                        placeholder="Enter your email"
                        class="flex-1 px-4 py-3 rounded-lg text-gray-900 focus:outline-none"
                    />
                    <button
                        class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold hover:bg-blue-50 transition"
                    >
                        Subscribe
                    </button>
                </div>
            </div>
        </section>

        <footer class="bg-gray-900 text-gray-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                    <div>
                        <h3 class="text-white font-bold mb-4">About Us</h3>
                        <p class="text-sm">
                            Your trusted online store for quality products and
                            exceptional service.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="#" class="hover:text-white">Home</a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-white"
                                    >Products</a
                                >
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">About</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">
                            Customer Service
                        </h3>
                        <ul class="space-y-2 text-sm">
                            <li>
                                <a href="#" class="hover:text-white"
                                    >Contact Us</a
                                >
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">FAQ</a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">Returns</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-bold mb-4">Follow Us</h3>
                        <div class="flex gap-4">
                            <a href="#" class="hover:text-white">Facebook</a>
                            <a href="#" class="hover:text-white">Twitter</a>
                            <a href="#" class="hover:text-white">Instagram</a>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-800 pt-8 text-center text-sm">
                    <p>&copy; 2025 Store. All rights reserved.</p>
                </div>
            </div>
        </footer>

        <Transition name="slide">
            <div
                v-if="showToast"
                class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg"
            >
                {{ toastMessage }}
            </div>
        </Transition>
        <LogoutModal ref="logoutModalRef" @confirm="confirmLogout" />
    </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useRouter, RouterLink } from "vue-router";
import { useProductService } from "../../composables/useProductService";
import ProductCard from "../../components/ProductCard.vue";
import CategoryCard from "../../components/CategoryCard.vue";
import TestimonialCard from "../../components/TestimonialCard.vue";
import LoadingSpinner from "../../components/LoadingSpinner.vue";
import { useCategoryService } from "../../composables/useCategoryService";
import { useCartService } from "../../composables/useCartService";
import LogoutModal from "../../components/LogoutModal.vue";
import { useAuth } from "../../composables/useAuthService";

export default {
    name: "Home",
    components: {
        ProductCard,
        CategoryCard,
        TestimonialCard,
        LoadingSpinner,
        RouterLink,
        LogoutModal,
    },
    setup() {
        const router = useRouter();
        const { fetchProducts } = useProductService();
        const { fetchCategories } = useCategoryService();
        const { addToCart, fetchCart } = useCartService();
        const { logout } = useAuth();

        const products = ref([]);
        const loadingProducts = ref(false);
        const productsSection = ref(null);
        const showToast = ref(false);
        const toastMessage = ref("");
        const cartItems = ref([]);
        const logoutModalRef = ref(null);

        const featuredCategories = ref([]);

        const cartCount = computed(() => {
            return cartItems.value.length;
        });

        const testimonials = [
            {
                id: 1,
                name: "John Doe",
                rating: 5,
                text: "Great products and fast shipping!",
                avatar: "👨",
            },
            {
                id: 2,
                name: "Jane Smith",
                rating: 5,
                text: "Excellent customer service and quality items.",
                avatar: "👩",
            },
            {
                id: 3,
                name: "Mike Johnson",
                rating: 5,
                text: "Best online store I have used so far.",
                avatar: "👨",
            },
        ];

        const loadCategory = async () => {
            try {
                const data = await fetchCategories();
                featuredCategories.value = data;
            } catch (error) {
                console.error("Failed to load categories:", error);
            }
        };
        const loadProducts = async () => {
            loadingProducts.value = true;
            try {
                const data = await fetchProducts();
                products.value = data;
            } catch (error) {
                console.error("Failed to load products:", error);
            } finally {
                loadingProducts.value = false;
            }
        };

        const handleLogout = async () => {
            logoutModalRef.value.openModal();
        };

        const confirmLogout = async () => {
            try {
                await logout();
                router.push("/login");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        };

        const handleAddToCart = async (product) => {
            await addToCart(product.id, 1);
            toastMessage.value = `${product.name} added to cart!`;
            showToast.value = true;
            setTimeout(() => {
                showToast.value = false;
            }, 3000);
        };

        const scrollToSection = (section) => {
            if (section === "products" && productsSection.value) {
                productsSection.value.scrollIntoView({ behavior: "smooth" });
            }
        };

        const loadCart = async () => {
            try {
                const data = await fetchCart();
                if (Array.isArray(data)) {
                    cartItems.value = data;
                } else if (
                    data &&
                    typeof data === "object" &&
                    "items" in data
                ) {
                    cartItems.value = data.items;
                } else {
                    cartItems.value = [];
                }
            } catch (error) {
                console.error("Failed to load cart:", error);
                cartItems.value = [];
            }
        };

        onMounted(() => {
            loadProducts();
            loadCategory();
            loadCart();
        });

        return {
            products,
            logoutModalRef,
            loadingProducts,
            productsSection,
            showToast,
            toastMessage,
            featuredCategories,
            testimonials,
            cartCount,
            handleLogout,
            confirmLogout,
            handleLogout,
            handleAddToCart,
            scrollToSection,
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
