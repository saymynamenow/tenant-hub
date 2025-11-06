import CentralDashboard from "../pages/AdminPage/CentralDashboard.vue";
import RegisterCentral from "../pages/AdminPage/RegisterCentral.vue";
import LoginCentral from "../pages/AdminPage/LoginCentral.vue";
import Homepage from "../pages/AdminPage/Homepage.vue";
import CentralProfile from "../pages/AdminPage/CentralProfile.vue";
import CentralSettings from "../pages/AdminPage/CentralSettings.vue";
import TenantRequestSubmission from "../pages/AdminPage/TenantRequestSubmission.vue";
import NotFound from "../pages/NotFound.vue";

export default [
    {
        path: "/",
        component: Homepage,
    },
    {
        path: "/request-tenant",
        name: "TenantRequestSubmission",
        component: TenantRequestSubmission,
    },
    {
        path: "/central-dashboard",
        component: CentralDashboard,
        meta: { requiresAuth: true, requiresSuperAdmin: true },
    },
    {
        path: "/profile",
        name: "CentralProfile",
        component: CentralProfile,
        meta: { requiresAuth: true },
    },
    {
        path: "/settings",
        name: "CentralSettings",
        component: CentralSettings,
        meta: { requiresAuth: true },
    },
    {
        path: "/central/register",
        name: "RegisterCentral",
        component: RegisterCentral,
        meta: { guestOnly: true },
    },
    {
        path: "/central/login",
        name: "LoginCentral",
        component: LoginCentral,
        meta: { guestOnly: true },
    },
    { path: "/404", name: "NotFound", component: NotFound },
];
