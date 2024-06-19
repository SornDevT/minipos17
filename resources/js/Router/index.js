
import { createWebHistory , createRouter } from "vue-router";

import Store from "../Pages/Store.vue";
import Pos from "../Pages/Pos.vue";
import Transection from "../Pages/Transection.vue";
import Report from "../Pages/Report.vue";
import NotFound from "../Pages/NotFound.vue";

export const routes = [
    {
        name: "store",
        path: "/store",
        component: Store
    },
    {
        name: "pos",
        path: "/pos",
        component: Pos
    },
    {
        name: "transection",
        path: "/transection",
        component: Transection
    },
    {
        name: "report",
        path: "/report",
        component: Report
    },
    {
        name:"notfound",
        path: "/:pathMactch(.*)*",
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior () {
        window.scrollTo(0,0)
    }
});

export default router;