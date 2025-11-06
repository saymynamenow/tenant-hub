<template>
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <router-link
                        to="/"
                        class="text-2xl font-bold text-blue-600"
                    >
                        TenantHub
                    </router-link>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Show when user is NOT logged in -->
                    <template v-if="!isLoggedIn">
                        <router-link
                            to="/central/login"
                            class="text-gray-700 hover:text-blue-600 transition-colors"
                        >
                            Login
                        </router-link>
                        <router-link
                            to="/central/register"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
                        >
                            Get Started
                        </router-link>
                    </template>

                    <!-- Show when user IS logged in -->
                    <template v-else>
                        <span class="text-gray-700">
                            Hello,
                            <span class="font-semibold">{{ userName }}</span>
                        </span>
                        <div class="relative">
                            <button
                                @click="toggleDropdown"
                                class="flex items-center space-x-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors"
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
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />
                                </svg>
                                <span>Profile</span>
                                <svg
                                    class="w-4 h-4 transition-transform"
                                    :class="{ 'rotate-180': dropdownOpen }"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div
                                v-if="dropdownOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                            >
                                <router-link
                                    v-if="isAdmin"
                                    to="/central-dashboard"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                    @click="closeDropdown"
                                >
                                    Dashboard
                                </router-link>
                                <router-link
                                    to="/profile"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                    @click="closeDropdown"
                                >
                                    My Profile
                                </router-link>
                                <router-link
                                    to="/settings"
                                    class="block px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600"
                                    @click="closeDropdown"
                                >
                                    Settings
                                </router-link>
                                <hr class="my-1" />
                                <button
                                    @click="handleLogout"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50"
                                >
                                    Logout
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useAuth } from "../composables/useAuthService";

const router = useRouter();
const { user, isAuthenticated, logout } = useAuth();

const dropdownOpen = ref(false);

const isLoggedIn = computed(() => isAuthenticated.value);
const userName = computed(() => user.value?.name || "User");
const isAdmin = computed(() => user.value?.role === "admin");

const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value;
};

const closeDropdown = () => {
    dropdownOpen.value = false;
};

const handleLogout = async () => {
    try {
        await logout();
        closeDropdown();
        router.push("/");
    } catch (error) {
        console.error("Logout failed:", error);
    }
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    const dropdown = event.target.closest(".relative");
    if (!dropdown && dropdownOpen.value) {
        closeDropdown();
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});
</script>

<style scoped>
.rotate-180 {
    transform: rotate(180deg);
}
</style>
