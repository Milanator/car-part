import { CheckboxProps } from '@/types/CheckboxProps';
import { ref, watch } from 'vue';

export function useCheckbox(props: CheckboxProps, emit: any) {
    const checked = ref(Boolean(props.modelValue));

    watch(
        () => props.modelValue,
        (newVal) => {
            checked.value = Boolean(newVal);
        },
    );

    watch(checked, (newVal) => {
        emit('update:modelValue', newVal);
    });

    return { checked };
}
