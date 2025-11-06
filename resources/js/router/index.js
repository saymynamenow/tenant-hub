import { createRouter, createWebHistory } from "vue-router";
import tenantRoutes from "./tenant";
import centralRoutes from "./central";
import { useAuth } from "../composables/useAuthService";

const CENTRAL_HOSTNAMES = [
    "www.central.localhost",
    "central.localhost",
    "localhost",
];
const isCentralDomain = () =>
    CENTRAL_HOSTNAMES.includes(window.location.hostname);

// Determine initial routes based on current domain
const routes = isCentralDomain() ? centralRoutes : tenantRoutes;

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// flag so we check tenant status only once per app load
let tenantStatusChecked = false;

router.beforeEach(async (to, from, next) => {
    const { user, fetchUser, isManager, isOwner, isSuperAdmin, loading } =
        useAuth();

    if (!user.value && !loading.value) {
        try {
            await fetchUser();
        } catch {
            user.value = null;
        }
    }

    if (loading.value) return;

    const isCentral = isCentralDomain();
    const loginPath = isCentral ? "/central/login" : "/login";
    const homePath = isCentral ? "/central-dashboard" : "/";

    if (!isCentral && !tenantStatusChecked) {
        try {
            const resp = await fetch("/tenant/status", {
                method: "GET",
                credentials: "same-origin",
            });
            if (resp.status === 404) {
                return next("/404");
            }
        } catch (e) {
        } finally {
            tenantStatusChecked = true;
        }
    }

    if (to.meta.requiresAuth && !user.value) return next(loginPath);
    if (to.meta.requiresManager && !isManager.value && !isOwner.value)
        return next(homePath);
    if (to.meta.requiresSuperAdmin && !isSuperAdmin.value)
        return next(homePath);
    if (to.meta.guestOnly && user.value) return next(homePath);

    next();
});
export default router;
