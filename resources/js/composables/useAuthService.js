import { computed, ref } from "vue";
import api from "../axios";

const user = ref(null);
const loading = ref(false);
const error = ref(null);

// Determine if we're in central or tenant context
const isCentralDomain = () => {
    return window.location.hostname === "www.central.localhost";
};

export const useAuth = () => {
    const fetchUser = async () => {
        loading.value = true;
        error.value = null;
        try {
            const endpoint = isCentralDomain() ? "/central/me" : "/tenant/me";
            const response = await api.get(endpoint, {
                withCredentials: true,
            });
            user.value = response.data.user;
            return response.data.user;
        } catch (err) {
            error.value = err.response?.data?.message || "Failed to fetch user";
            user.value = null;
            throw err;
        } finally {
            loading.value = false;
        }
    };

    const isManager = computed(() => {
        return (
            user.value &&
            (user.value.role === "admin" || user.value.role === "manager")
        );
    });

    const isOwner = computed(() => {
        return user.value && user.value.role === "owner";
    });

    const isSuperAdmin = computed(() => {
        return (
            (user.value && user.value.role === "super_admin") ||
            user.value.role === "admin"
        );
    });

    const isAuthenticated = computed(() => {
        return user.value !== null;
    });

    const logout = async () => {
        try {
            const endpoint = isCentralDomain()
                ? "/central/logout"
                : "/tenant/logout";
            await api.post(endpoint, {}, { withCredentials: true });
            user.value = null;
        } catch (err) {
            console.error("Logout failed:", err);
        }
    };

    const setUser = (userData) => {
        user.value = userData;
    };

    const clearUser = () => {
        user.value = null;
    };

    return {
        user,
        loading,
        error,
        isManager,
        isOwner,
        isSuperAdmin,
        isAuthenticated,
        logout,
        fetchUser,
        setUser,
        clearUser,
    };
};
