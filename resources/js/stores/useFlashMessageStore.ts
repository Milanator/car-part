import { defineStore } from 'pinia';
import { ref } from 'vue';

const MESSAGE_TIME = 5000;

export const useFlashMessageStore = defineStore('flash-message', () => {
    const message = ref<string | undefined>(undefined);
    const type = ref<'success' | 'error' | 'info' | undefined>('success');

    const success = (msg: string) => {
        message.value = msg;
        type.value = 'success';

        hide();
    };

    const error = (msg: string) => {
        message.value = msg;
        type.value = 'error';

        hide();
    };

    const hide = () => {
        setTimeout(clear, MESSAGE_TIME);
    };

    const clear = () => {
        message.value = undefined;
        type.value = undefined;
    };

    return { message, type, success, error, clear };
});
