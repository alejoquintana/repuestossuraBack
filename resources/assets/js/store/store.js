import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state : {
        orders:[],
       
        config : null,
        states:[],
        meta:[],
        categories: [],
        loading:true,
        searchTerm:'',
    },
    getters :{
        getSearchTerm(store){
            return store.searchTerm;
        },
        getOrders(store){
            return store.orders;
        },
        getLoading(store)
        {
            return store.loading;
        },
        getTotal(store) {
                var tot = 0;
                if(store.categories && store.categories.length){
                    store.categories.forEach(function(category){
                        category.products.forEach(function(product){
                            if (product.units > 0)
                            {
                                
                               tot+= product.price * product.units
                                
                            }
                        });
                    });
                }
                return tot;
            },
        getList(store) {
            if (store.categories && store.categories.length){
                var result = [];
                store.categories.forEach(function (category) {
                    var prods = category.products.filter(function (el) {
                        return (el.units != null & el.units > 0);
                    });
                    if (prods.length > 0) {
                        result.push(prods);
                    }
                });
                return [].concat.apply([], result);
            }


        },

        getMeta: store => page => {
            if (store.meta)
            {
               
                return store.meta.find(m=>{
                   
                    return m.page.trim() == page.trim();
                });
            }
        },
       
        getConfig(store){
            return store.config;
        },
        getStates(store){
            return store.states;
        },
        getCity: store => id => {
            if (store.states){
            
                store.states.forEach(state => {
                    let cit = state.cities.find(city => {
                        return city.id == id;
                    });
                    if (cit){
                        return cit;
                    }
                })  ;
            }
        },
             getCategories(state) {
                return state.categories;
            },
            getCategory: (state) => (id) => {
                if (state.categories.length > 0) {
                    return state.categories.find(cat => {
                        return cat.id == id;
                    });
                }
            },
            getProducts(state) {
                let prods = [];
                if (state.categories.length > 0) {
                    state.categories.forEach(category => {
                        prods.concat(category.products);
                    });
                }
                return prods;
            },
            getProduct: (state) => (id) => {
                var res = null;
                if (state.categories.length > 0) {
                    state.categories.forEach(cat => {

                        var prod = cat.products.find(p => {
                            return p.id == id
                        });
                        if (prod) {

                            res = prod;

                        }
                    });
                    return res;

                }
            },
            getOffers(state) {
                let prods = [];
                if (state.categories.length > 0) {
                    state.categories.forEach(category => {
                        category.products.forEach(product => {

                            if (product.offer) {
                                prods.push(product);
                            }
                        });
                    });
                }

                return prods;
            },
            
    },
    mutations : {
        setSearchTerm(state,payload)
        {
            if(payload.length > 2)
            {
                Vue.http.post('/searchHistory',{term:payload});
            }
            state.searchTerm = payload;
        },
        setLoading(state, payload)
        {
            state.loading = payload;
        },
        setOrders(state,payload){
            state.orders=payload;
        },
        setMeta(state,payload){
            state.meta=payload;
        },
       
        setConfig(state,payload){
            state.config = payload;
        },
        setStates(state,payload){
            state.states = payload
        },
         setProductUnits: (state, payload) => {
                 let prod = payload;
                 state.categories.forEach(c => {
                     c.products.forEach(p => {
                         if (p.id == prod.id) {
                            
                             Vue.set(p, 'units', prod.units);
                         }
                     });
                 });
             },
             updateCategories: (state, payload) => {
                 state.categories = payload;
             },
             saveCategory: (state, category) => {
                 state.categories.push(category);
             },
             
    },
    actions: {
            fetchCategories: ({
                commit
            }, payload) => {

                Vue.http.get('/api/categories')
                    .then(response => {
                        let cats = _.sortBy(response.data, 'name');

                        commit('updateCategories', cats);
                    });
            },
    
       fetchConfig: ({
           commit
       }, payload) => {

           Vue.http.get('/config')
               .then(response => {
                   commit('setConfig', response.data);
               });
       },
       fetchStates: ({
           commit
       }, payload) => {
           Vue.http.get('/api/states')
               .then(response => {
                   commit('setStates', response.data);
               });
       },
       fetchMeta: ({
           commit
       }, payload) => {
           Vue.http.get('/api/metadatas')
               .then(response => {
                   commit('setMeta', response.data);
               });
       },
       fetchOrders: ({
           commit
       }, payload) => {
           Vue.http.get('/admin/getOrders')
               .then(response => {
                   commit('setOrders', response.data);
               });
       },
    },
   

});

