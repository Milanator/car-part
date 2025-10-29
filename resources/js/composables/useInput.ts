import { InputProps } from '@/types/InputProps';
import { ref, watch } from 'vue';

export function useInput(props: InputProps, emit: any) {
    const value = ref(props.modelValue);

    watch(
        () => props.modelValue,
        (newValue) => {
            value.value = newValue;
        },
    );

    const onInput = () => emit('update:modelValue', value.value);

    const onFocus = (event: FocusEvent) => emit('focus', event);
    
    const onBlur = (event: FocusEvent) => emit('blur', event);

    return { value, onInput, onFocus, onBlur };
}
