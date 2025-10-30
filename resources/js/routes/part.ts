import Form from '@/pages/part/Form.vue';
import Index from '@/pages/part/Index.vue';

export default [
    { path: '/', component: Index },
    { path: '/part', component: Index },
    { path: '/part/create', component: Form },
    { path: '/part/:id/edit', component: Form, props: true },
];
