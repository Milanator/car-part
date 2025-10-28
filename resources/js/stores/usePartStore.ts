import { defineBaseStore } from '@/stores/useBaseStore';
import { Part } from '@/types/Part';

export const usePartStore = defineBaseStore<Part>('part');
