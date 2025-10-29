<script lang="ts" setup>
import { InputProps } from '@/types/InputProps';
import { ref } from 'vue';

const props = withDefaults(defineProps<InputProps>(), {
    type: 'text',
    required: false,
    readonly: false,
});

const emit = defineEmits(['update:modelValue']);

const value = ref(props.modelValue);
</script>
<template>
    <div class="mb-3">
        <label :for="id" class="form-label">
            {{ label }}
            <span v-if="required">*</span>
        </label>
        <input
            :type="type"
            :id="id"
            :required="required"
            :readonly="readonly"
            class="form-control"
            v-model="value"
            @input="emit('update:modelValue', value)"
        />
    </div>
</template>
