<script lang="ts" setup>
import { CheckboxProps } from '@/types/CheckboxProps';
import { ref, watch } from 'vue';

const props = defineProps<CheckboxProps>();

const emit = defineEmits(['update:modelValue']);

const checked = ref(Boolean(props.modelValue));

watch(
    () => props.modelValue,
    (newVal) => {
        checked.value = newVal;
    },
);

watch(checked, (newVal) => {
    emit('update:modelValue', newVal);
});
</script>

<template>
    <div class="form-check mb-3">
        <input type="checkbox" :id="id" class="form-check-input" v-model="checked" />
        <label :for="id" class="form-check-label">{{ label }}</label>
    </div>
</template>
