<template>
    <div
        v-if="isOpen"
        @click.self="closeModal"
        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50"
    >
        <div class="bg-white rounded-lg shadow-lg w-96">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Confirm Logout</h2>
                <p class="mb-6">Are you sure you want to log out?</p>
                <div class="flex justify-end gap-4">
                    <button
                        @click="closeModal"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                    >
                        Cancel
                    </button>
                    <button
                        @click="logout"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600"
                    >
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useAuth } from "../composables/useAuthService";

const { logout } = useAuth();
export default {
    name: "LogoutModal",
    setup(props, { emit }) {
        const isOpen = ref(false);

        const openModal = () => {
            isOpen.value = true;
        };

        const closeModal = () => {
            isOpen.value = false;
        };

        const logout = async () => {
            emit("confirm");
            closeModal();
        };

        return {
            isOpen,
            openModal,
            closeModal,
            logout,
        };
    },
};
</script>
