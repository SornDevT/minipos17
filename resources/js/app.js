import './bootstrap';

import { createApp } from 'vue';
import App from './App.vue'
import router from './Router';
import SideMenu from './Components/SideMenu.vue';
import { createPinia } from 'pinia';
const pinia = createPinia();

import Pagination from './Components/Pagination.vue';
import Cleave from 'vue-cleave-component';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

import { PerfectScrollbarPlugin } from 'vue3-perfect-scrollbar';
import 'vue3-perfect-scrollbar/style.css';

import DashGrap from './Components/DashGrap.vue';

const app = createApp(App);
app.use(pinia);
app.use(Cleave);
app.use(VueSweetalert2);
app.component("SideMenu",SideMenu);
app.component("Pagination",Pagination);
app.component('DashGrap', DashGrap);
app.use(router);
app.use(PerfectScrollbarPlugin);
app.mount('#app-vue');