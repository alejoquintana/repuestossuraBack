import Vue from 'vue';

import VueRouter from 'vue-router';
import VueMeta from 'vue-meta';

import {
    store
} from './store/store.js';

Vue.use(VueRouter);
Vue.use(VueMeta);





function guardAdmin(to, from, next) {
    setTimeout(() => {

        let user = store.getters.getUser;
        if (user && user.role_id < 3) {
            next();
        } else {
            next('/login');
        }

    }, 300);
}

function guardLogin(to, from, next) {
    setTimeout(() => {

        let user = store.getters.getUser;
        if (user && user.role_id < 3) {
            next('/admin');
        } else {
            next();
        }

    }, 300);
}

/* 
import "core-js/modules/es6.promise";
import "core-js/modules/es6.array.iterator";
 */





import Busqueda from './components/search/Results.vue';
import Franquicia from './components/franquicia/Franquicia.vue'
import Regalos from './components/regalos/Regalos.vue';
import Sucursales from './components/sucursales/Sucursales.vue';
import HomeA from './components/home/HomeA.vue';
import HomeB from './components/home/HomeB.vue';
import Cotizer from './components/cotizer/Cotizer.vue';
import Contacto from './components/contacto/Contacto.vue';
import Login from './components/login/Login.vue';
import CategoryRouter from './components/category/Category-router.vue';
import Category from './components/category/Category.vue';
import Product from './components/category/product/Product.vue';

import Admin from './components/admin/Admin.vue';
import Orders from './components/admin/Orders.vue';
import SearchStatics from './components/admin/Search-statics.vue';
import Metadata  from './components/super/metadata/Super.vue';

/* landings */
import Rosario from './components/landings/Rosario.vue';


const router = new VueRouter({
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    },
    mode: 'history',
    routes: [{
            path: '/login',
            name: 'login',
            component: Login,
            beforeEnter: guardLogin
        },
        /* ADMIN */
         {
             path: '/admin',
             name: 'admin',
             component: Admin,
             beforeEnter: guardAdmin
         }, {
             path: '/admin/busquedas',
             name: 'searchStatics',
             component: SearchStatics,
             beforeEnter: guardAdmin
         }, {
             path: '/admin/pedidos',
             name: 'orders',
             component: Orders,
             beforeEnter: guardAdmin
         }, {
             path: '/admin/metadata',
             name: 'meta',
             component: Metadata,
             beforeEnter: guardAdmin
         }, 
         /* /ADMIN */

        {
            path: '/',
            name: 'home',
            components: {
                default:HomeA,
                contentB:HomeB
            }
        },
        
        {
            path: '/contacto',
            name: 'contacto',
            component: Contacto
        },
        {
            path: '/cotizador',
            name: 'cotizador',
            component: Cotizer
        },
        {
            path: '/franquicia',
            name: 'franquicia',
            component: Franquicia
        },
        {
            path: '/regalos-empresariales',
            name: 'regalos-empresariales',
            component: Regalos
        },
        {
            path: '/sucursales',
            name: 'sucursales',
            component: Sucursales
        },
        
        {
            path: '/busqueda',
            name: 'busqueda',
            component: Busqueda
        },
        {
            path:'/envios-a-rosario',
            name:'Rosario',
            component: Rosario
        },
        {
            path: '/:category_slug',
            component: CategoryRouter,
            children: [{
                    path: '',
                    component: Category,
                    name: 'category'
                },
                {
                    path: ':product_slug',
                    component: Product,
                    name: 'product'
                }
            ]

        }
    ]

});

export default router;