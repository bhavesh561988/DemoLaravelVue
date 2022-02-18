import AllProduct from './front/AllProduct.vue';
import MyOrder from './front/Order.vue';
import AdminOrder from './admin/Order.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllProduct
    },
    {
        name: 'order',
        path: '/orders',
        component: MyOrder
    },
    {
        name: 'admin',
        path: '/admin',
        component: AdminOrder
    }
];