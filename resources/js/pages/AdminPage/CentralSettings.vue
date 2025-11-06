<template>
    <div class="min-h-screen bg-gray-50">
        <Navigation />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
                <p class="text-gray-600 mt-2">
                    Manage your application settings and preferences
                </p>
            </div>

            <!-- Settings Sections -->
            <div class="space-y-6">
                <!-- General Settings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">
                            General Settings
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Configure general application preferences
                        </p>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Language -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    Language
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Select your preferred language
                                </p>
                            </div>
                            <select
                                v-model="settings.language"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="en">English</option>
                                <option value="id">Indonesian</option>
                            </select>
                        </div>

                        <!-- Timezone -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    Timezone
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Set your timezone
                                </p>
                            </div>
                            <select
                                v-model="settings.timezone"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="UTC">UTC</option>
                                <option value="Asia/Jakarta">
                                    Asia/Jakarta
                                </option>
                                <option value="America/New_York">
                                    America/New York
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Notifications
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Manage your notification preferences
                        </p>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Email Notifications -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    Email Notifications
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Receive notifications via email
                                </p>
                            </div>
                            <button
                                @click="
                                    settings.emailNotifications =
                                        !settings.emailNotifications
                                "
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                :class="
                                    settings.emailNotifications
                                        ? 'bg-blue-600'
                                        : 'bg-gray-200'
                                "
                            >
                                <span
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                    :class="
                                        settings.emailNotifications
                                            ? 'translate-x-6'
                                            : 'translate-x-1'
                                    "
                                ></span>
                            </button>
                        </div>

                        <!-- New Tenant Alerts -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    New Tenant Alerts
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Get notified when new tenants register
                                </p>
                            </div>
                            <button
                                @click="
                                    settings.tenantAlerts =
                                        !settings.tenantAlerts
                                "
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                :class="
                                    settings.tenantAlerts
                                        ? 'bg-blue-600'
                                        : 'bg-gray-200'
                                "
                            >
                                <span
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                    :class="
                                        settings.tenantAlerts
                                            ? 'translate-x-6'
                                            : 'translate-x-1'
                                    "
                                ></span>
                            </button>
                        </div>

                        <!-- System Updates -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    System Updates
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Receive updates about system changes
                                </p>
                            </div>
                            <button
                                @click="
                                    settings.systemUpdates =
                                        !settings.systemUpdates
                                "
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                :class="
                                    settings.systemUpdates
                                        ? 'bg-blue-600'
                                        : 'bg-gray-200'
                                "
                            >
                                <span
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                    :class="
                                        settings.systemUpdates
                                            ? 'translate-x-6'
                                            : 'translate-x-1'
                                    "
                                ></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">
                            Security
                        </h2>
                        <p class="text-gray-600 mt-1">
                            Manage your security preferences
                        </p>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Two-Factor Authentication -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    Two-Factor Authentication
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Add an extra layer of security
                                </p>
                            </div>
                            <button
                                @click="
                                    settings.twoFactorAuth =
                                        !settings.twoFactorAuth
                                "
                                class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors"
                                :class="
                                    settings.twoFactorAuth
                                        ? 'bg-blue-600'
                                        : 'bg-gray-200'
                                "
                            >
                                <span
                                    class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                    :class="
                                        settings.twoFactorAuth
                                            ? 'translate-x-6'
                                            : 'translate-x-1'
                                    "
                                ></span>
                            </button>
                        </div>

                        <!-- Session Timeout -->
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-medium text-gray-900">
                                    Session Timeout
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Auto logout after inactivity
                                </p>
                            </div>
                            <select
                                v-model="settings.sessionTimeout"
                                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                                <option value="15">15 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="120">2 hours</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button
                        @click="saveSettings"
                        :disabled="loading"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        {{ loading ? "Saving..." : "Save Settings" }}
                    </button>
                </div>

                <!-- Success Message -->
                <div
                    v-if="successMessage"
                    class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg"
                >
                    {{ successMessage }}
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Navigation from "../../components/Navigation.vue";

const settings = ref({
    language: "en",
    timezone: "UTC",
    emailNotifications: true,
    tenantAlerts: true,
    systemUpdates: false,
    twoFactorAuth: false,
    sessionTimeout: "30",
});

const loading = ref(false);
const successMessage = ref("");

const saveSettings = async () => {
    loading.value = true;
    successMessage.value = "";

    try {
        // Add your settings save API call here
        // await api.saveSettings(settings.value);
        await new Promise((resolve) => setTimeout(resolve, 1000)); // Simulate API call
        successMessage.value = "Settings saved successfully!";
        setTimeout(() => {
            successMessage.value = "";
        }, 3000);
    } catch (error) {
        console.error("Failed to save settings:", error);
    } finally {
        loading.value = false;
    }
};
</script>
