import { createRouter, createWebHistory } from 'vue-router';
import carRoutes from '@/routes/car';

export const router = createRouter({
  history: createWebHistory(),
  routes:[
    ...carRoutes
  ],
});