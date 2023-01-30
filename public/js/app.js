(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/app"],{

/***/ "./resources/assets/js/app.js":
/*!************************************!*\
  !*** ./resources/assets/js/app.js ***!
  \************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_mq__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-mq */ "./node_modules/vue-mq/dist/vue-mq.es.js");
/* harmony import */ var sweetalert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! sweetalert */ "./node_modules/sweetalert/dist/sweetalert.min.js");
/* harmony import */ var sweetalert__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(sweetalert__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _store_store_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./store/store.js */ "./resources/assets/js/store/store.js");
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");
/* harmony import */ var _filters_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./filters.js */ "./resources/assets/js/filters.js");
/* harmony import */ var vue_on_click_outside__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! vue-on-click-outside */ "./node_modules/vue-on-click-outside/dist/vue-on-click-outside.js");
/* harmony import */ var vue_on_click_outside__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(vue_on_click_outside__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var vue_awesome_swiper__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! vue-awesome-swiper */ "./node_modules/vue-awesome-swiper/dist/vue-awesome-swiper.js");
/* harmony import */ var vue_awesome_swiper__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(vue_awesome_swiper__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var v_lazy_image__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! v-lazy-image */ "./node_modules/v-lazy-image/dist/v-lazy-image.js");
/* harmony import */ var v_lazy_image__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(v_lazy_image__WEBPACK_IMPORTED_MODULE_8__);
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/App.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
/* harmony import */ var _routes_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./routes.js */ "./resources/assets/js/routes.js");
/* harmony import */ var laravel_mix_vue_svgicon_IconComponent_vue__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! laravel-mix-vue-svgicon/IconComponent.vue */ "./node_modules/laravel-mix-vue-svgicon/IconComponent.vue");
function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; var ownKeys = Object.keys(source); if (typeof Object.getOwnPropertySymbols === 'function') { ownKeys = ownKeys.concat(Object.getOwnPropertySymbols(source).filter(function (sym) { return Object.getOwnPropertyDescriptor(source, sym).enumerable; })); } ownKeys.forEach(function (key) { _defineProperty(target, key, source[key]); }); } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

__webpack_require__(/*! intersection-observer */ "./node_modules/intersection-observer/intersection-observer.js");
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


__webpack_require__(/*! ./bootstrap */ "./resources/assets/js/bootstrap.js");


window.vue = vue__WEBPACK_IMPORTED_MODULE_0___default.a;
window.Vue = vue__WEBPACK_IMPORTED_MODULE_0___default.a;

var VueResource = __webpack_require__(/*! vue-resource */ "./node_modules/vue-resource/dist/vue-resource.esm.js");

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(VueResource); // Vue.http.interceptors.push(function (request, next) {
//     request.headers['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
//     next();
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue); */


vue__WEBPACK_IMPORTED_MODULE_0___default.a.component('fade-loader', __webpack_require__(/*! vue-spinner/src/FadeLoader.vue */ "./node_modules/vue-spinner/src/FadeLoader.vue")["default"]); // Vue.component('example-component', require('./components/ExampleComponent.vue').default);


window.swal = sweetalert__WEBPACK_IMPORTED_MODULE_2___default.a;
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_mq__WEBPACK_IMPORTED_MODULE_1__["default"], {
  breakpoints: {
    sm: 600,
    md: 990,
    lg: Infinity
  }
});

String.prototype.ucfirst = function () {
  return this.charAt(0).toUpperCase() + this.slice(1);
};





vue__WEBPACK_IMPORTED_MODULE_0___default.a.directive('on-click-outside', vue_on_click_outside__WEBPACK_IMPORTED_MODULE_6__["directive"]);

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_awesome_swiper__WEBPACK_IMPORTED_MODULE_7___default.a
/* { default global options } */
);

vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(v_lazy_image__WEBPACK_IMPORTED_MODULE_8__["VLazyImagePlugin"]);

vue__WEBPACK_IMPORTED_MODULE_0___default.a.component('my-app', !(function webpackMissingModule() { var e = new Error("Cannot find module './components/App.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

/* 
window.csrf = $('meta[name="csrf-token"]').attr('content');
Vue.http.headers.common['X-CSRF-TOKEN'] = window.csrf;

 */

/* 


window.csrf = document.getElementById('csrf-token').getAttribute('content');
Vue.http.headers.common['X-CSRF-TOKEN'] = window.csrf; */


vue__WEBPACK_IMPORTED_MODULE_0___default.a.component('icon', laravel_mix_vue_svgicon_IconComponent_vue__WEBPACK_IMPORTED_MODULE_11__["default"]);
var app = new vue__WEBPACK_IMPORTED_MODULE_0___default.a({
  router: _routes_js__WEBPACK_IMPORTED_MODULE_10__["default"],
  el: '#app',
  store: _store_store_js__WEBPACK_IMPORTED_MODULE_3__["store"],
  methods: _objectSpread({}, Object(vuex__WEBPACK_IMPORTED_MODULE_4__["mapActions"])({
    fetchCategories: 'fetchCategories',
    fetchUser: 'fetchUser',
    fetchConfig: 'fetchConfig',
    fetchStates: 'fetchStates',
    fetchMeta: 'fetchMeta'
  })),
  created: function created() {
    this.fetchCategories();
    this.fetchUser();
    this.fetchConfig();
    this.fetchStates();
    this.fetchMeta();
  },
  mounted: function mounted() {
    window.csrf = document.getElementById('csrf-token').getAttribute('content');
    vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.headers.common['X-CSRF-TOKEN'] = window.csrf;
  }
});

/***/ }),

/***/ "./resources/assets/js/bootstrap.js":
/*!******************************************!*\
  !*** ./resources/assets/js/bootstrap.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window._ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
window.Popper = __webpack_require__(/*! popper.js */ "./node_modules/popper.js/dist/esm/popper.js")["default"];
/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
  window.$ = window.jQuery = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

  __webpack_require__(/*! bootstrap */ "./node_modules/bootstrap/dist/js/bootstrap.js");
} catch (e) {}
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

var token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
// import Echo from 'laravel-echo'
// window.Pusher = require('pusher-js');
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

/***/ }),

/***/ "./resources/assets/js/filters.js":
/*!****************************************!*\
  !*** ./resources/assets/js/filters.js ***!
  \****************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);

vue__WEBPACK_IMPORTED_MODULE_0___default.a.filter('price', function (value) {
  if (value % 1 != 0) {
    return value.toFixed(2);
  }

  return value;
});
vue__WEBPACK_IMPORTED_MODULE_0___default.a.filter('text', function (value) {
  if (value) {
    return value.trim();
  }
});
vue__WEBPACK_IMPORTED_MODULE_0___default.a.filter('datetime', function (val) {
  return moment(val).format('DD/MM/YYYY H:mm');
});
vue__WEBPACK_IMPORTED_MODULE_0___default.a.filter('slug', function (str) {
  if (typeof str != 'string') {
    return str;
  }

  str = str.replace(/^\s+|\s+$/g, ''); // trim

  str = str.toLowerCase(); // remove accents, swap ñ for n, etc

  var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
  var to = "aaaaeeeeiiiioooouuuunc------";

  for (var i = 0, l = from.length; i < l; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
  .replace(/\s+/g, '-') // collapse whitespace and replace by -
  .replace(/-+/g, '-'); // collapse dashes

  return str;
});
vue__WEBPACK_IMPORTED_MODULE_0___default.a.filter('ucFirst', function (string) {
  if (!string) return;
  return string.charAt(0).toUpperCase() + string.slice(1);
});

/***/ }),

/***/ "./resources/assets/js/routes.js":
/*!***************************************!*\
  !*** ./resources/assets/js/routes.js ***!
  \***************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vue_router__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vue-router */ "./node_modules/vue-router/dist/vue-router.esm.js");
/* harmony import */ var vue_meta__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! vue-meta */ "./node_modules/vue-meta/lib/vue-meta.js");
/* harmony import */ var vue_meta__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(vue_meta__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _store_store_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./store/store.js */ "./resources/assets/js/store/store.js");
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/search/Results.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/franquicia/Franquicia.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/regalos/Regalos.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/sucursales/Sucursales.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/home/HomeA.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/home/HomeB.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/cotizer/Cotizer.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/contacto/Contacto.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/login/Login.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/category/Category-router.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/category/Category.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/category/product/Product.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/admin/Admin.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/admin/Orders.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/admin/Search-statics.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/super/metadata/Super.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());
!(function webpackMissingModule() { var e = new Error("Cannot find module './components/landings/Rosario.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());




vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]);
vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vue_meta__WEBPACK_IMPORTED_MODULE_2___default.a);

function guardAdmin(to, from, next) {
  setTimeout(function () {
    var user = _store_store_js__WEBPACK_IMPORTED_MODULE_3__["store"].getters.getUser;

    if (user && user.role_id < 3) {
      next();
    } else {
      next('/login');
    }
  }, 300);
}

function guardLogin(to, from, next) {
  setTimeout(function () {
    var user = _store_store_js__WEBPACK_IMPORTED_MODULE_3__["store"].getters.getUser;

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


















/* landings */


var router = new vue_router__WEBPACK_IMPORTED_MODULE_1__["default"]({
  scrollBehavior: function scrollBehavior() {
    return {
      x: 0,
      y: 0
    };
  },
  mode: 'history',
  routes: [{
    path: '/login',
    name: 'login',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/login/Login.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
    beforeEnter: guardLogin
  },
  /* ADMIN */
  {
    path: '/admin',
    name: 'admin',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/admin/Admin.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
    beforeEnter: guardAdmin
  }, {
    path: '/admin/busquedas',
    name: 'searchStatics',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/admin/Search-statics.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
    beforeEnter: guardAdmin
  }, {
    path: '/admin/pedidos',
    name: 'orders',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/admin/Orders.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
    beforeEnter: guardAdmin
  }, {
    path: '/admin/metadata',
    name: 'meta',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/super/metadata/Super.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
    beforeEnter: guardAdmin
  },
  /* /ADMIN */
  {
    path: '/',
    name: 'home',
    components: {
      "default": !(function webpackMissingModule() { var e = new Error("Cannot find module './components/home/HomeA.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
      contentB: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/home/HomeB.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
    }
  }, {
    path: '/contacto',
    name: 'contacto',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/contacto/Contacto.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/cotizador',
    name: 'cotizador',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/cotizer/Cotizer.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/franquicia',
    name: 'franquicia',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/franquicia/Franquicia.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/regalos-empresariales',
    name: 'regalos-empresariales',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/regalos/Regalos.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/sucursales',
    name: 'sucursales',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/sucursales/Sucursales.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/busqueda',
    name: 'busqueda',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/search/Results.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/envios-a-rosario',
    name: 'Rosario',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/landings/Rosario.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }())
  }, {
    path: '/:category_slug',
    component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/category/Category-router.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
    children: [{
      path: '',
      component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/category/Category.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
      name: 'category'
    }, {
      path: ':product_slug',
      component: !(function webpackMissingModule() { var e = new Error("Cannot find module './components/category/product/Product.vue'"); e.code = 'MODULE_NOT_FOUND'; throw e; }()),
      name: 'product'
    }]
  }]
});
/* harmony default export */ __webpack_exports__["default"] = (router);

/***/ }),

/***/ "./resources/assets/js/store/store.js":
/*!********************************************!*\
  !*** ./resources/assets/js/store/store.js ***!
  \********************************************/
/*! exports provided: store */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "store", function() { return store; });
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue */ "./node_modules/vue/dist/vue.common.js");
/* harmony import */ var vue__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(vue__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var vuex__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! vuex */ "./node_modules/vuex/dist/vuex.esm.js");


vue__WEBPACK_IMPORTED_MODULE_0___default.a.use(vuex__WEBPACK_IMPORTED_MODULE_1__["default"]);
var store = new vuex__WEBPACK_IMPORTED_MODULE_1__["default"].Store({
  state: {
    orders: [],
    config: null,
    states: [],
    meta: [],
    categories: [],
    loading: true,
    searchTerm: ''
  },
  getters: {
    getSearchTerm: function getSearchTerm(store) {
      return store.searchTerm;
    },
    getOrders: function getOrders(store) {
      return store.orders;
    },
    getLoading: function getLoading(store) {
      return store.loading;
    },
    getTotal: function getTotal(store) {
      var tot = 0;

      if (store.categories && store.categories.length) {
        store.categories.forEach(function (category) {
          category.products.forEach(function (product) {
            if (product.units > 0) {
              tot += product.price * product.units;
            }
          });
        });
      }

      return tot;
    },
    getList: function getList(store) {
      if (store.categories && store.categories.length) {
        var result = [];
        store.categories.forEach(function (category) {
          var prods = category.products.filter(function (el) {
            return el.units != null & el.units > 0;
          });

          if (prods.length > 0) {
            result.push(prods);
          }
        });
        return [].concat.apply([], result);
      }
    },
    getMeta: function getMeta(store) {
      return function (page) {
        if (store.meta) {
          return store.meta.find(function (m) {
            return m.page.trim() == page.trim();
          });
        }
      };
    },
    getConfig: function getConfig(store) {
      return store.config;
    },
    getStates: function getStates(store) {
      return store.states;
    },
    getCity: function getCity(store) {
      return function (id) {
        if (store.states) {
          store.states.forEach(function (state) {
            var cit = state.cities.find(function (city) {
              return city.id == id;
            });

            if (cit) {
              return cit;
            }
          });
        }
      };
    },
    getCategories: function getCategories(state) {
      return state.categories;
    },
    getCategory: function getCategory(state) {
      return function (id) {
        if (state.categories.length > 0) {
          return state.categories.find(function (cat) {
            return cat.id == id;
          });
        }
      };
    },
    getProducts: function getProducts(state) {
      var prods = [];

      if (state.categories.length > 0) {
        state.categories.forEach(function (category) {
          prods.concat(category.products);
        });
      }

      return prods;
    },
    getProduct: function getProduct(state) {
      return function (id) {
        var res = null;

        if (state.categories.length > 0) {
          state.categories.forEach(function (cat) {
            var prod = cat.products.find(function (p) {
              return p.id == id;
            });

            if (prod) {
              res = prod;
            }
          });
          return res;
        }
      };
    },
    getOffers: function getOffers(state) {
      var prods = [];

      if (state.categories.length > 0) {
        state.categories.forEach(function (category) {
          category.products.forEach(function (product) {
            if (product.offer) {
              prods.push(product);
            }
          });
        });
      }

      return prods;
    }
  },
  mutations: {
    setSearchTerm: function setSearchTerm(state, payload) {
      if (payload.length > 2) {
        vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.post('/searchHistory', {
          term: payload
        });
      }

      state.searchTerm = payload;
    },
    setLoading: function setLoading(state, payload) {
      state.loading = payload;
    },
    setOrders: function setOrders(state, payload) {
      state.orders = payload;
    },
    setMeta: function setMeta(state, payload) {
      state.meta = payload;
    },
    setConfig: function setConfig(state, payload) {
      state.config = payload;
    },
    setStates: function setStates(state, payload) {
      state.states = payload;
    },
    setProductUnits: function setProductUnits(state, payload) {
      var prod = payload;
      state.categories.forEach(function (c) {
        c.products.forEach(function (p) {
          if (p.id == prod.id) {
            vue__WEBPACK_IMPORTED_MODULE_0___default.a.set(p, 'units', prod.units);
          }
        });
      });
    },
    updateCategories: function updateCategories(state, payload) {
      state.categories = payload;
    },
    saveCategory: function saveCategory(state, category) {
      state.categories.push(category);
    }
  },
  actions: {
    fetchCategories: function fetchCategories(_ref, payload) {
      var commit = _ref.commit;
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.get('/api/categories').then(function (response) {
        var cats = _.sortBy(response.data, 'name');

        commit('updateCategories', cats);
      });
    },
    fetchConfig: function fetchConfig(_ref2, payload) {
      var commit = _ref2.commit;
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.get('/config').then(function (response) {
        commit('setConfig', response.data);
      });
    },
    fetchStates: function fetchStates(_ref3, payload) {
      var commit = _ref3.commit;
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.get('/api/states').then(function (response) {
        commit('setStates', response.data);
      });
    },
    fetchMeta: function fetchMeta(_ref4, payload) {
      var commit = _ref4.commit;
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.get('/api/metadatas').then(function (response) {
        commit('setMeta', response.data);
      });
    },
    fetchOrders: function fetchOrders(_ref5, payload) {
      var commit = _ref5.commit;
      vue__WEBPACK_IMPORTED_MODULE_0___default.a.http.get('/admin/getOrders').then(function (response) {
        commit('setOrders', response.data);
      });
    }
  }
});

/***/ }),

/***/ "./resources/assets/sass/app.scss":
/*!****************************************!*\
  !*** ./resources/assets/sass/app.scss ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/svg sync recursive ^\\.\\/.*\\.svg$":
/*!******************************************!*\
  !*** ./resources/svg sync ^\.\/.*\.svg$ ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function webpackEmptyContext(req) {
	var e = new Error("Cannot find module '" + req + "'");
	e.code = 'MODULE_NOT_FOUND';
	throw e;
}
webpackEmptyContext.keys = function() { return []; };
webpackEmptyContext.resolve = webpackEmptyContext;
module.exports = webpackEmptyContext;
webpackEmptyContext.id = "./resources/svg sync recursive ^\\.\\/.*\\.svg$";

/***/ }),

/***/ 0:
/*!***************************************************************************!*\
  !*** multi ./resources/assets/js/app.js ./resources/assets/sass/app.scss ***!
  \***************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /home/rodrigo/RODRIGO/projects/nuxt/BALMON/SUSPENSION LUJAN/suspensionback/resources/assets/js/app.js */"./resources/assets/js/app.js");
module.exports = __webpack_require__(/*! /home/rodrigo/RODRIGO/projects/nuxt/BALMON/SUSPENSION LUJAN/suspensionback/resources/assets/sass/app.scss */"./resources/assets/sass/app.scss");


/***/ }),

/***/ 1:
/*!*********************!*\
  !*** got (ignored) ***!
  \*********************/
/*! no static exports found */
/***/ (function(module, exports) {

/* (ignored) */

/***/ })

},[[0,"/js/manifest","/js/vendor"]]]);