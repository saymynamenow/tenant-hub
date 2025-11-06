<template>
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50"
    >
        <!-- Header with Logo -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center"
                        >
                            <svg
                                class="w-6 h-6 text-white"
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
                            >eCommerce Store</span
                        >
                    </div>
                    <div class="text-sm text-gray-600">
                        Already have an account?
                        <RouterLink
                            to="/login"
                            class="text-blue-600 hover:text-blue-700 font-semibold"
                            >Sign in</RouterLink
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Benefits -->
                <div class="hidden lg:block">
                    <div class="space-y-8">
                        <div>
                            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                                Join our community
                            </h1>
                            <p class="text-xl text-gray-600">
                                Create an account to start shopping and enjoy
                                exclusive benefits
                            </p>
                        </div>

                        <!-- Benefits List -->
                        <div class="space-y-4">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0"
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
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        Fast Checkout
                                    </h3>
                                    <p class="text-gray-600">
                                        Save your information for faster
                                        purchases
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0"
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
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        Exclusive Deals
                                    </h3>
                                    <p class="text-gray-600">
                                        Get access to member-only offers and
                                        discounts
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0"
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
                                            d="M13 10V3L4 14h7v7l9-11h-7z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        Track Orders
                                    </h3>
                                    <p class="text-gray-600">
                                        Monitor your purchases in real-time
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0"
                                >
                                    <svg
                                        class="w-6 h-6 text-orange-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        24/7 Support
                                    </h3>
                                    <p class="text-gray-600">
                                        Our customer service team is always here
                                        to help
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Registration Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">
                        Create Account
                    </h2>
                    <p class="text-gray-600 mb-8">
                        Sign up to get started with amazing deals
                    </p>

                    <form @submit.prevent="handleSubmit" class="space-y-6">
                        <!-- Full Name -->
                        <div>
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Full Name
                            </label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="Enter your full name"
                            />
                            <span
                                v-if="errors.name"
                                class="text-red-500 text-sm mt-1 block"
                                >{{ errors.name }}</span
                            >
                        </div>

                        <!-- Email -->
                        <div>
                            <label
                                for="email"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Email Address
                            </label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                placeholder="Enter your email"
                            />
                            <span
                                v-if="errors.email"
                                class="text-red-500 text-sm mt-1 block"
                                >{{ errors.email }}</span
                            >
                        </div>

                        <!-- Password -->
                        <div>
                            <label
                                for="password"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Password
                            </label>
                            <div class="relative">
                                <input
                                    id="password"
                                    v-model="form.password"
                                    :type="showPassword ? 'text' : 'password'"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    placeholder="Create a strong password"
                                />
                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute right-3 top-3 text-gray-600 hover:text-gray-900"
                                >
                                    <svg
                                        v-if="!showPassword"
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
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
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.172 9.172a4 4 0 015.656 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <span
                                v-if="errors.password"
                                class="text-red-500 text-sm mt-1 block"
                                >{{ errors.password }}</span
                            >
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label
                                for="password_confirmation"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Confirm Password
                            </label>
                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    v-model="form.password_confirmation"
                                    :type="
                                        showConfirmPassword
                                            ? 'text'
                                            : 'password'
                                    "
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                                    placeholder="Confirm your password"
                                />
                                <button
                                    type="button"
                                    @click="
                                        showConfirmPassword =
                                            !showConfirmPassword
                                    "
                                    class="absolute right-3 top-3 text-gray-600 hover:text-gray-900"
                                >
                                    <svg
                                        v-if="!showConfirmPassword"
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
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
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <span
                                v-if="errors.password_confirmation"
                                class="text-red-500 text-sm mt-1 block"
                                >{{ errors.password_confirmation }}</span
                            >
                        </div>

                        <!-- Terms & Conditions -->
                        <div class="flex items-start">
                            <input
                                id="terms"
                                v-model="form.acceptTerms"
                                type="checkbox"
                                required
                                class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500 mt-1"
                            />
                            <label
                                for="terms"
                                class="ml-3 text-sm text-gray-600"
                            >
                                I agree to the
                                <a
                                    href="#"
                                    class="text-blue-600 hover:text-blue-700 font-medium"
                                    >Terms & Conditions</a
                                >
                                and
                                <a
                                    href="#"
                                    class="text-blue-600 hover:text-blue-700 font-medium"
                                    >Privacy Policy</a
                                >
                            </label>
                        </div>

                        <!-- Error Alert -->
                        <div
                            v-if="error"
                            class="rounded-lg bg-red-50 p-4 border border-red-200"
                        >
                            <div class="flex">
                                <svg
                                    class="w-5 h-5 text-red-600 flex-shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4v2m0-10a8 8 0 110 16 8 8 0 010-16z"
                                    />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        {{ error }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button
                            type="submit"
                            :disabled="loading"
                            class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                        >
                            <svg
                                v-if="loading"
                                class="animate-spin h-5 w-5"
                                fill="none"
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
                            {{
                                loading
                                    ? "Creating Account..."
                                    : "Create Account"
                            }}
                        </button>
                    </form>

                    <!-- Sign In Link -->
                    <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                        <p class="text-gray-600">
                            Already have an account?
                            <RouterLink
                                to="/login"
                                class="text-blue-600 hover:text-blue-700 font-semibold"
                                >Sign in here</RouterLink
                            >
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import api from "../../axios";

export default {
    name: "UserRegister",
    setup() {
        const router = useRouter();
        const loading = ref(false);
        const error = ref("");
        const showPassword = ref(false);
        const showConfirmPassword = ref(false);

        const form = ref({
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            acceptTerms: false,
        });

        const errors = ref({});

        const validateForm = () => {
            errors.value = {};

            if (!form.value.name.trim()) {
                errors.value.name = "Full name is required";
            }

            if (!form.value.email.trim()) {
                errors.value.email = "Email is required";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.value.email)) {
                errors.value.email = "Please enter a valid email";
            }

            if (!form.value.password) {
                errors.value.password = "Password is required";
            } else if (form.value.password.length < 6) {
                errors.value.password =
                    "Password must be at least 6 characters";
            }

            if (!form.value.password_confirmation) {
                errors.value.password_confirmation =
                    "Please confirm your password";
            } else if (
                form.value.password !== form.value.password_confirmation
            ) {
                errors.value.password_confirmation = "Passwords do not match";
            }

            if (!form.value.acceptTerms) {
                errors.value.acceptTerms =
                    "You must accept the terms and conditions";
            }

            return Object.keys(errors.value).length === 0;
        };

        const handleSubmit = async () => {
            if (!validateForm()) {
                return;
            }

            try {
                loading.value = true;
                error.value = "";

                const response = await api.post(
                    "/tenant/register",
                    {
                        name: form.value.name,
                        email: form.value.email,
                        password: form.value.password,
                        password_confirmation: form.value.password_confirmation,
                    },
                    {
                        withCredentials: true,
                        headers: {
                            Accept: "application/json",
                            "Content-Type": "application/json",
                        },
                    }
                );

                if (response.data.error) {
                    throw new Error(response.data.error);
                }

                // Redirect to login or dashboard
                router.push("/login");
            } catch (e) {
                if (e.response?.data?.message) {
                    error.value = e.response.data.message;
                } else if (e.response?.data?.error) {
                    error.value = e.response.data.error;
                } else {
                    error.value =
                        e.message || "Registration failed. Please try again.";
                }
            } finally {
                loading.value = false;
            }
        };

        return {
            form,
            errors,
            loading,
            error,
            showPassword,
            showConfirmPassword,
            handleSubmit,
        };
    },
};
</script>
