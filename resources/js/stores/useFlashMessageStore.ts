import { defineStore } from 'pinia';
import { ref, watch } from 'vue';

export const useFlashMessageStore = defineStore('flash-message', () => {
    const message = ref<string | null>(null);
    const type = ref<'success' | 'error' | 'info'>('success');

    const success = (msg: string) => {
        message.value = msg;
        type.value = 'success';
    };

    const error = (msg: string) => {
        message.value = msg;
        type.value = 'error';
    };

    const clear = () => {
        message.value = null;
    };

    return { message, type, success, error, clear };
});
