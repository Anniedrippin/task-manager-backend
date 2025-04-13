import { createRouter, createWebHistory } from "vue-router";
import HomeView from "../views/HomeView.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Tasks from "../views/Tasks.vue";

const routes = [
    { path: "/", redirect: "/tasks" },
    { path: "/login", component: Login },
    { path: "/register", component: Register },
    { path: "/tasks", component: Tasks },
    {
        path: "/",
        name: "home",
        component: HomeView,
    },
    {
        path: "/about",
        name: "about",
        component: () => import("../views/AboutView.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes, // Use the combined routes array
});

export default router;
