import Home from "../pages/TenantPage/Home.vue";
import Register from "../pages/TenantPage/Register.vue";
import Login from "../pages/TenantPage/Login.vue";
import ManagementDashboard from "../pages/ProductManagement/ManagementDashboard.vue";
import Orders from "../pages/TenantPage/ProductManagement/Orders.vue";
import UserRegister from "../pages/TenantPage/UserRegister.vue";
import ProductDetail from "../pages/TenantPage/ProductDetail.vue";
import Products from "../pages/TenantPage/Products.vue";
import Categories from "../pages/TenantPage/Categories.vue";
import Cart from "../pages/TenantPage/Cart.vue";
import Checkout from "../pages/TenantPage/Checkout.vue";
import Profile from "../pages/TenantPage/Profile.vue";
import NotFound from "../pages/NotFound.vue";

export default [
    { path: "/", component: Home, meta: { requiresAuth: true } },
    { path: "/tenantregister", component: Register, meta: { guestOnly: true } },
    { path: "/login", component: Login, meta: { guestOnly: true } },
    {
        path: "/dashboard",
        component: ManagementDashboard,
        meta: { requiresAuth: true, requiresManager: true },
    },
    {
        path: "/dashboard/orders",
        name: "Orders",
        component: Orders,
        meta: { requiresAuth: true, requiresManager: true },
    },
    { path: "/register", component: UserRegister, meta: { guestOnly: true } },
    {
        path: "/product/:id",
        name: "ProductDetail",
        component: ProductDetail,
        meta: { requiresAuth: true },
    },
    {
        path: "/products",
        name: "Products",
        component: Products,
        meta: { requiresAuth: true },
    },
    {
        path: "/categories",
        name: "Categories",
        component: Categories,
        meta: { requiresAuth: true },
    },
    {
        path: "/cart",
        name: "Cart",
        component: Cart,
        meta: { requiresAuth: true },
    },
    {
        path: "/checkout",
        name: "Checkout",
        component: Checkout,
        meta: { requiresAuth: true },
    },
    {
        path: "/profile",
        name: "Profile",
        component: Profile,
        meta: { requiresAuth: true },
    },
    { path: "/404", name: "NotFound", component: NotFound },
];
