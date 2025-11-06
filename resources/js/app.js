import "../css/app.css";

import "./bootstrap";
import { createApp } from "vue";

import App from "./App.vue";
import router from "./router";
import tenantRoutes from "./router/tenant";
import centralRoutes from "./router/central";

const app = createApp(App);

const hostname = window.location.hostname;

if (hostname === "central.localhost") {
    centralRoutes.forEach((route) => router.addRoute(route));
} else {
    tenantRoutes.forEach((route) => router.addRoute(route));
}
app.use(router);
app.mount("#app");
