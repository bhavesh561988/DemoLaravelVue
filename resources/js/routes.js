import AllProduct from './components/AllProduct.vue';
import MyOrder from './components/Order.vue';
 
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
    }
];