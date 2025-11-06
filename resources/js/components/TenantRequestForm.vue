<template>
    <div class="w-full">
        <!-- Success Message -->
        <div
            v-if="successMessage"
            class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-start"
        >
            <svg
                class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd"
                />
            </svg>
            <div>
                <p class="font-semibold">Success!</p>
                <p>{{ successMessage }}</p>
            </div>
        </div>

        <!-- Error Message -->
        <div
            v-if="errorMessage"
            class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg flex items-start"
        >
            <svg
                class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                    clip-rule="evenodd"
                />
            </svg>
            <div>
                <p class="font-semibold">Error</p>
                <p>{{ errorMessage }}</p>
            </div>
        </div>

        <form @submit.prevent="handleSubmit" class="space-y-6">
            <!-- Business Name -->
            <div>
                <label
                    for="business_name"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Business Name <span class="text-red-500">*</span>
                </label>
                <input
                    v-model="form.business_name"
                    id="business_name"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    :class="{ 'border-red-500': errors.business_name }"
                    placeholder="Enter your business name"
                />
                <p
                    v-if="errors.business_name"
                    class="mt-1 text-sm text-red-600"
                >
                    {{ errors.business_name[0] }}
                </p>
            </div>

            <!-- Contact Name -->
            <div>
                <label
                    for="contact_name"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Contact Name <span class="text-red-500">*</span>
                </label>
                <input
                    v-model="form.contact_name"
                    id="contact_name"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    :class="{ 'border-red-500': errors.contact_name }"
                    placeholder="Enter your full name"
                />
                <p v-if="errors.contact_name" class="mt-1 text-sm text-red-600">
                    {{ errors.contact_name[0] }}
                </p>
            </div>

            <!-- Email -->
            <div>
                <label
                    for="email"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Email Address <span class="text-red-500">*</span>
                </label>
                <input
                    v-model="form.email"
                    id="email"
                    type="email"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    :class="{ 'border-red-500': errors.email }"
                    placeholder="your@email.com"
                />
                <p v-if="errors.email" class="mt-1 text-sm text-red-600">
                    {{ errors.email[0] }}
                </p>
            </div>

            <!-- Phone -->
            <div>
                <label
                    for="phone"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Phone Number (Optional)
                </label>
                <input
                    v-model="form.phone"
                    id="phone"
                    type="tel"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    :class="{ 'border-red-500': errors.phone }"
                    placeholder="+1 (555) 000-0000"
                />
                <p v-if="errors.phone" class="mt-1 text-sm text-red-600">
                    {{ errors.phone[0] }}
                </p>
            </div>

            <!-- Description -->
            <div>
                <label
                    for="description"
                    class="block text-sm font-semibold text-gray-700 mb-2"
                >
                    Tell us about your business (Optional)
                </label>
                <textarea
                    v-model="form.description"
                    id="description"
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                    :class="{ 'border-red-500': errors.description }"
                    placeholder="What type of products or services do you plan to sell? What are your business goals?"
                ></textarea>
                <p v-if="errors.description" class="mt-1 text-sm text-red-600">
                    {{ errors.description[0] }}
                </p>
                <p class="mt-1 text-xs text-gray-500">
                    {{ form.description.length }}/1000 characters
                </p>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                :disabled="isSubmitting"
                class="w-full bg-blue-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-blue-700 transform hover:scale-105 transition-all shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:bg-blue-600"
            >
                <span
                    v-if="!isSubmitting"
                    class="flex items-center justify-center"
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
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    Submit Request
                </span>
                <span v-else class="flex items-center justify-center">
                    <svg
                        class="animate-spin h-5 w-5 mr-2"
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
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                        ></path>
                    </svg>
                    Submitting...
                </span>
            </button>

            <p class="text-center text-sm text-gray-500 mt-4">
                We'll review your request and get back to you within 1-2
                business days
            </p>
        </form>
    </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import axios from "axios";

const isSubmitting = ref(false);
const successMessage = ref("");
const errorMessage = ref("");
const errors = ref({});

const form = reactive({
    business_name: "",
    contact_name: "",
    email: "",
    phone: "",
    description: "",
});

const resetForm = () => {
    form.business_name = "";
    form.contact_name = "";
    form.email = "";
    form.phone = "";
    form.description = "";
};

const handleSubmit = async () => {
    isSubmitting.value = true;
    successMessage.value = "";
    errorMessage.value = "";
    errors.value = {};

    try {
        const response = await axios.post("/tenant-requests", form);

        successMessage.value = response.data.message;
        resetForm();

        // Scroll to top to show success message
        window.scrollTo({ top: 0, behavior: "smooth" });
    } catch (error) {
        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
            errorMessage.value = "Please fix the errors below and try again.";
        } else {
            errorMessage.value =
                error.response?.data?.error ||
                "Failed to submit request. Please try again later.";
        }

        // Scroll to top to show error message
        window.scrollTo({ top: 0, behavior: "smooth" });
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<style scoped>
/* Custom animations */
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
