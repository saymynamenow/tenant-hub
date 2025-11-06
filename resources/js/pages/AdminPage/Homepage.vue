<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50"
    >
        <!-- Navigation -->
        <Navigation />

        <!-- Hero Section -->
        <section class="relative overflow-hidden py-20 lg:py-28">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2
                        class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6"
                    >
                        Launch Your Own
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600"
                        >
                            Multi-Tenant Store
                        </span>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-10">
                        Create your own e-commerce platform with isolated
                        databases, custom domains, and complete control. Perfect
                        for entrepreneurs and growing businesses.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <router-link
                            to="/request-tenant"
                            class="bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg"
                        >
                            Create Your Tenant Now
                        </router-link>
                        <button
                            @click="scrollToFeatures"
                            class="bg-white text-blue-600 border-2 border-blue-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-50 transform hover:scale-105 transition-all"
                        >
                            Learn More
                        </button>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div
                class="absolute top-0 left-0 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"
            ></div>
            <div
                class="absolute top-0 right-0 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"
            ></div>
            <div
                class="absolute bottom-0 left-1/2 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"
            ></div>
        </section>

        <!-- Features Section -->
        <section ref="featuresSection" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h3
                        class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4"
                    >
                        Everything You Need to Succeed
                    </h3>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Powerful features to help you build and scale your
                        online business
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    <!-- Feature 1 -->
                    <div
                        class="p-6 rounded-xl border-2 border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all"
                    >
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"
                                />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            Isolated Databases
                        </h4>
                        <p class="text-gray-600">
                            Each tenant gets its own secure database for
                            complete data isolation and privacy
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="p-6 rounded-xl border-2 border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all"
                    >
                        <div
                            class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-6 h-6 text-purple-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"
                                />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            Custom Domains
                        </h4>
                        <p class="text-gray-600">
                            Use your own domain name or get a subdomain - your
                            brand, your choice
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="p-6 rounded-xl border-2 border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all"
                    >
                        <div
                            class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-6 h-6 text-green-600"
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
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            Lightning Fast
                        </h4>
                        <p class="text-gray-600">
                            Built with modern technology for blazing fast
                            performance and scalability
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div
                        class="p-6 rounded-xl border-2 border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all"
                    >
                        <div
                            class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-6 h-6 text-yellow-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            Secure & Reliable
                        </h4>
                        <p class="text-gray-600">
                            Enterprise-grade security with automatic backups and
                            99.9% uptime guarantee
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div
                        class="p-6 rounded-xl border-2 border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all"
                    >
                        <div
                            class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-6 h-6 text-red-600"
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
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            E-commerce Ready
                        </h4>
                        <p class="text-gray-600">
                            Complete shopping cart, orders, and payment
                            integration out of the box
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div
                        class="p-6 rounded-xl border-2 border-gray-100 hover:border-blue-200 hover:shadow-xl transition-all"
                    >
                        <div
                            class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4"
                        >
                            <svg
                                class="w-6 h-6 text-indigo-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 mb-2">
                            Analytics Dashboard
                        </h4>
                        <p class="text-gray-600">
                            Track your performance with detailed insights and
                            real-time analytics
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h3
                        class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4"
                    >
                        Get Started in 3 Simple Steps
                    </h3>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Launch your store in minutes, not months
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-blue-600 rounded-full flex items-center justify-center mx-auto mb-6"
                        >
                            <span class="text-3xl font-bold text-white">1</span>
                        </div>
                        <h4 class="text-2xl font-semibold text-gray-900 mb-3">
                            Sign Up
                        </h4>
                        <p class="text-gray-600">
                            Create your account and choose your tenant name. It
                            only takes 30 seconds.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-purple-600 rounded-full flex items-center justify-center mx-auto mb-6"
                        >
                            <span class="text-3xl font-bold text-white">2</span>
                        </div>
                        <h4 class="text-2xl font-semibold text-gray-900 mb-3">
                            Configure
                        </h4>
                        <p class="text-gray-600">
                            Set up your store settings, add products, and
                            customize your brand.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div
                            class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-6"
                        >
                            <span class="text-3xl font-bold text-white">3</span>
                        </div>
                        <h4 class="text-2xl font-semibold text-gray-900 mb-3">
                            Launch
                        </h4>
                        <p class="text-gray-600">
                            Go live instantly and start accepting orders from
                            customers worldwide.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-20 bg-blue-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center text-white"
                >
                    <div>
                        <div class="text-5xl font-bold mb-2">1000+</div>
                        <div class="text-xl text-blue-100">Active Tenants</div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">99.9%</div>
                        <div class="text-xl text-blue-100">
                            Uptime Guarantee
                        </div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">24/7</div>
                        <div class="text-xl text-blue-100">
                            Customer Support
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tenant Request CTA Section -->
        <section class="py-20 bg-gradient-to-br from-blue-50 to-purple-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-white rounded-2xl shadow-xl p-12">
                    <div class="mb-8">
                        <div
                            class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"
                        >
                            <svg
                                class="w-10 h-10 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <h3
                            class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4"
                        >
                            Apply for Your Tenant Account
                        </h3>
                        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                            Submit your application and join thousands of
                            entrepreneurs building their businesses on our
                            platform
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 text-left"
                    >
                        <div class="flex items-start">
                            <svg
                                class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    Fast Approval
                                </p>
                                <p class="text-sm text-gray-600">
                                    Get reviewed in 1-2 business days
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg
                                class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    No Commitment
                                </p>
                                <p class="text-sm text-gray-600">
                                    Free application, no credit card required
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <svg
                                class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    Full Support
                                </p>
                                <p class="text-sm text-gray-600">
                                    24/7 help from our expert team
                                </p>
                            </div>
                        </div>
                    </div>

                    <router-link
                        to="/request-tenant"
                        class="inline-block bg-blue-600 text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg"
                    >
                        Submit Your Application
                    </router-link>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">
                    Ready to Build Your Store?
                </h3>
                <p class="text-xl text-gray-600 mb-10">
                    Join thousands of entrepreneurs who are already growing
                    their business with TenantHub
                </p>
                <router-link
                    to="/central/register"
                    class="inline-block bg-blue-600 text-white px-10 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg"
                >
                    Start Your Free Trial
                </router-link>
                <p class="mt-4 text-gray-500">
                    No credit card required • Cancel anytime
                </p>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h5 class="text-xl font-bold mb-4">TenantHub</h5>
                        <p class="text-gray-400">
                            The easiest way to launch your multi-tenant
                            e-commerce platform
                        </p>
                    </div>
                    <div>
                        <h6 class="font-semibold mb-4">Product</h6>
                        <ul class="space-y-2 text-gray-400">
                            <li>
                                <a href="#" class="hover:text-white"
                                    >Features</a
                                >
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">Pricing</a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-white"
                                    >Documentation</a
                                >
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h6 class="font-semibold mb-4">Company</h6>
                        <ul class="space-y-2 text-gray-400">
                            <li>
                                <a href="#" class="hover:text-white">About</a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">Blog</a>
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">Careers</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h6 class="font-semibold mb-4">Support</h6>
                        <ul class="space-y-2 text-gray-400">
                            <li>
                                <a href="#" class="hover:text-white"
                                    >Help Center</a
                                >
                            </li>
                            <li>
                                <a href="#" class="hover:text-white"
                                    >Contact Us</a
                                >
                            </li>
                            <li>
                                <a href="#" class="hover:text-white">Status</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div
                    class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400"
                >
                    <p>&copy; 2025 TenantHub. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Navigation from "../../components/Navigation.vue";

const featuresSection = ref(null);

const scrollToFeatures = () => {
    featuresSection.value?.scrollIntoView({ behavior: "smooth" });
};
</script>

<style scoped>
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
