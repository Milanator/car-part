import { Car } from '@/types/Car';
import { defineBaseStore } from '@/stores/useBaseStore';

export const useCarStore = defineBaseStore<Car>('car');