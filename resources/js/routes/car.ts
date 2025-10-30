import Form from '@/pages/car/Form.vue';
import Index from '@/pages/car/Index.vue';

export default [
    { path: '/', component: Index },
    { path: '/car', component: Index },
    { path: '/car/create', component: Form },
    { path: '/car/:id/edit', component: Form, props: true },
];
