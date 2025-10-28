import { createRouter, createWebHistory } from 'vue-router';
import carRoutes from '@/routes/car';
import partRoutes from '@/routes/part';

export const router = createRouter({
  history: createWebHistory(),
  routes:[
    ...carRoutes,
    ...partRoutes
  ],
});