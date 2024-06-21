
import { createWebHistory , createRouter } from "vue-router";

import Store from "../Pages/Store.vue";
import Pos from "../Pages/Pos.vue";
import Transection from "../Pages/Transection.vue";
import Report from "../Pages/Report.vue";
import NotFound from "../Pages/NotFound.vue";
import Login from "../Pages/Login.vue";
import Register from "../Pages/Register.vue";

import { useStore } from "../Store/auth";

export const routes = [
    {
        name: "login",
        path: "/login",
        component: Login
    },
    {
        name: "register",
        path: "/register",
        component: Register
    },
    {
        name: "store",
        path: "/store",
        component: Store,
        meta:{
            requiresAuth: true
        }
    },
    {
        name: "pos",
        path: "/pos",
        component: Pos,
        meta:{
            requiresAuth: true
        }
    },
    {
        name: "transection",
        path: "/transection",
        component: Transection,
        meta:{
            requiresAuth: true
        }
    },
    {
        name: "report",
        path: "/report",
        component: Report,
        meta:{
            requiresAuth: true
        }
    },
    {
        name:"notfound",
        path: "/:pathMactch(.*)*",
        component: NotFound,
        meta:{
            requiresAuth: true
        }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior () {
        window.scrollTo(0,0)
    }
});

router.beforeEach((to,from,next)=>{

    const token = localStorage.getItem('web_token');
    const user = localStorage.getItem('web_user');
    const store = useStore();

    // ກວດວ່າມີ token ຫຼືບໍ່
    if(token){
        store.set_token(token);
        store.set_user(JSON.parse(user));

        if(to.path == '/login' || to.path == '/register'){
            return next({
                path:'/',
                replace: true
            })
        }

    } else {
        // store.remove_token()
        // store.remove_user()
    }

    if(to.meta.requiresAuth){
        if(!token){
            return next({
                path:'/login',
                replace: true
            })
        }
    }
    next()
})

export default router;