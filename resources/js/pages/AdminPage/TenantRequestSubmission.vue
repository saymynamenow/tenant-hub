<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50"
    >
        <!-- Navigation -->
        <Navigation />

        <!-- Header Section -->
        <section class="py-12 lg:py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-8">
                    <!-- Back Button -->
                    <router-link
                        to="/"
                        class="inline-flex items-center text-blue-600 hover:text-blue-700 mb-6 font-medium"
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
                        Back to Home
                    </router-link>

                    <h1
                        class="text-4xl sm:text-5xl font-extrabold text-gray-900 mb-4"
                    >
                        Request Your
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600"
                        >
                            Tenant Account
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Fill out the form below to apply for your own
                        multi-tenant store. We'll review your application and
                        get back to you shortly.
                    </p>
                </div>

                <!-- Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
                    <div
                        class="bg-white p-4 rounded-lg border border-gray-200 text-center"
                    >
                        <div class="text-blue-600 font-bold text-2xl mb-1">
                            1-2 Days
                        </div>
                        <div class="text-gray-600 text-sm">Review Time</div>
                    </div>
                    <div
                        class="bg-white p-4 rounded-lg border border-gray-200 text-center"
                    >
                        <div class="text-blue-600 font-bold text-2xl mb-1">
                            Free
                        </div>
                        <div class="text-gray-600 text-sm">Application Fee</div>
                    </div>
                    <div
                        class="bg-white p-4 rounded-lg border border-gray-200 text-center"
                    >
                        <div class="text-blue-600 font-bold text-2xl mb-1">
                            24/7
                        </div>
                        <div class="text-gray-600 text-sm">
                            Support Available
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Form Section -->
        <section class="pb-20">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl shadow-xl p-8 lg:p-12">
                    <TenantRequestForm />
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                    What You'll Get
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                Isolated Database
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Your own secure database for complete data
                                isolation
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                Custom Subdomain
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Get your own branded subdomain for your store
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                Full Admin Access
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Complete control over your store and products
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                E-commerce Features
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Shopping cart, orders, and payment integration
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                Analytics Dashboard
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Track sales and performance in real-time
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div
                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">
                                Technical Support
                            </h3>
                            <p class="text-gray-600 text-sm">
                                Get help whenever you need it from our team
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">
                    Frequently Asked Questions
                </h2>
                <div class="space-y-6">
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-2">
                            How long does the approval process take?
                        </h3>
                        <p class="text-gray-600">
                            Most applications are reviewed within 1-2 business
                            days. We'll send you an email notification once your
                            application has been processed.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-2">
                            Is there a cost to apply?
                        </h3>
                        <p class="text-gray-600">
                            No, submitting an application is completely free.
                            You'll only be charged once your tenant is approved
                            and you start using the platform.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-2">
                            What happens after I submit my request?
                        </h3>
                        <p class="text-gray-600">
                            Our team will review your application and verify
                            your information. You'll receive an email with next
                            steps and login credentials once approved.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-2">
                            Can I customize my store after approval?
                        </h3>
                        <p class="text-gray-600">
                            Yes! Once approved, you'll have full access to
                            customize your store settings, add products,
                            configure categories, and manage your brand.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-white py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-gray-400">
                    &copy; 2025 TenantHub. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<script setup>
import Navigation from "../../components/Navigation.vue";
import TenantRequestForm from "../../components/TenantRequestForm.vue";
</script>
