<script lang="ts" setup>
import { useCheckbox } from '@/composables/form/useCheckbox';
import { CheckboxProps } from '@/types/form/CheckboxProps';

const props = defineProps<CheckboxProps>();

const emit = defineEmits(['update:modelValue']);

const { checked } = useCheckbox(props, emit);
</script>
<template>
    <div class="form-check mb-3">
        <input type="checkbox" :id="id" class="form-check-input" v-model="checked" />
        <label :for="id" class="form-check-label">{{ label }}</label>
    </div>
</template>
