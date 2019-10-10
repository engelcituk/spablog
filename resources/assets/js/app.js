require('./bootstrap');

import Vue from 'vue';
import Router from 'vue-router';
import Home from './views/Home.vue';

Vue.use(Router);

let router = new Router({
    routes: [{
            path: '/',
            component: () =>
                import ('./views/Home')
        },
        {
            path: '/contacto',
            component: () =>
                import ('./views/Contacto')

        },
        {
            path: '/nosotros',
            component: () =>
                import ('./views/Nosotros')

        }, {
            path: '/archivo',
            component: () =>
                import ('./views/Archivo')
        }
    ],
    linkExactActiveClass: 'active'
});
const app = new Vue({
    el: '#app',
    router
});