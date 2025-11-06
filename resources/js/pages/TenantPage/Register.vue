<template>
    <div
        class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
    >
        <div
            class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-lg"
        >
            <div>
                <h2
                    class="mt-6 text-center text-3xl font-extrabold text-gray-900"
                >
                    Create your tenant account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Start managing your organization today
                </p>
            </div>
            <form class="mt-8 space-y-6" @submit.prevent="handleSubmit">
                <div class="rounded-md shadow-sm -space-y-px">
                    <!-- Tenant Name -->
                    <div>
                        <label for="tenant-name" class="sr-only"
                            >Tenant Name</label
                        >
                        <input
                            id="tenant-name"
                            v-model="form.tenantName"
                            name="tenant-name"
                            type="text"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Tenant Name (Organization)"
                        />
                    </div>
                    <div>
                        <label for="username" class="sr-only">Username</label>
                        <input
                            id="username"
                            v-model="form.username"
                            name="username"
                            type="text"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Tenant Name (Organization)"
                        />
                    </div>
                    <!-- Email Address -->
                    <div>
                        <label for="email-address" class="sr-only"
                            >Email address</label
                        >
                        <input
                            id="email-address"
                            v-model="form.email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address"
                        />
                    </div>
                    <!-- Password -->
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            name="password"
                            type="password"
                            autocomplete="new-password"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Password"
                        />
                    </div>
                    <!-- Confirm Password -->
                    <div>
                        <label for="password-confirmation" class="sr-only"
                            >Confirm Password</label
                        >
                        <input
                            id="password-confirmation"
                            v-model="form.passwordConfirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm Password"
                        />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input
                            id="terms"
                            v-model="form.acceptTerms"
                            name="terms"
                            type="checkbox"
                            required
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                        />
                        <label
                            for="terms"
                            class="ml-2 block text-sm text-gray-900"
                        >
                            I agree to the terms and conditions
                        </label>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        :disabled="loading"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <span
                            class="absolute left-0 inset-y-0 flex items-center pl-3"
                        >
                            <svg
                                v-if="!loading"
                                class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <svg
                                v-else
                                class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
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
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"
                                ></path>
                            </svg>
                        </span>
                        {{ loading ? "Creating account..." : "Register" }}
                    </button>
                </div>
            </form>

            <!-- Error Alert -->
            <div v-if="error" class="rounded-md bg-red-50 p-4 mt-4">
                <div class="flex">
                    <div class="shrink-0">
                        <svg
                            class="h-5 w-5 text-red-400"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">
                            {{ error }}
                        </h3>
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
    name: "Register",
    setup() {
        const router = useRouter();
        const loading = ref(false);
        const error = ref("");
        const form = ref({
            tenantName: "",
            email: "",
            password: "",
            passwordConfirmation: "",
            acceptTerms: false,
        });

        const handleSubmit = async () => {
            try {
                loading.value = true;
                error.value = "";

                if (form.value.password !== form.value.passwordConfirmation) {
                    throw new Error("Passwords do not match");
                }

                const response = await api.post("/tenants/register", {
                    name: form.value.tenantName,
                    email: form.value.email,
                    password: form.value.password,
                    username: form.value.username,
                });
                const data = response.data;

                if (!response.ok) {
                    throw new Error(
                        data.response.data.message || "Registration failed"
                    );
                }
                router.push("/login");
            } catch (e) {
                error.value = "Registration failed. ";
            } finally {
                loading.value = false;
            }
        };

        return {
            form,
            loading,
            error,
            handleSubmit,
        };
    },
};
</script>
