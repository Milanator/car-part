<script lang="ts" setup>
import { useInput } from '@/composables/form/useInput';
import { InputProps } from '@/types/form/InputProps';

const props = withDefaults(defineProps<InputProps>(), {
    type: 'text',
    required: false,
    readonly: false,
});

const emit = defineEmits(['update:modelValue', 'focus', 'blur', 'input']);

const { value, onInput, onFocus, onBlur } = useInput(props, emit);
</script>
<template>
    <div class="mb-3" :class="classes">
        <label v-if="label" :for="id" class="form-label">
            {{ label }}
            <span v-if="required">*</span>
        </label>
        <input
            :type="type"
            :id="id"
            :required="Boolean(required)"
            :readonly="readonly"
            autocomplete="off"
            class="form-control"
            v-model="value"
            @input="onInput"
            @blur="onBlur"
            @focus="onFocus"
        />
    </div>
</template>
