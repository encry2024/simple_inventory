import VueRouter from 'vue-router';
import IndexComponent from './components/inventory/Index.vue';
import CreateComponent from './components/inventory/Create.vue';

let routes = [
    {
        path: '/list',
        component: IndexComponent
    },
    {
        path: '/create',
        component: CreateComponent
    }
]

export default new VueRouter({
    routes,
    linkExactActiveClass: 'active',
    mode: 'history'
});
