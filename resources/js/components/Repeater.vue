<script lang="ts" setup>
import { onMounted, reactive, watch } from 'vue';

interface Props {
    modelValue: any[];
}

const props = defineProps<Props>();

const emit = defineEmits(['update:modelValue']);

const items = reactive([...props.modelValue]);

onMounted(() => {
    if (items.length === 0) {
        items.push({});
    }
});

watch(
    () => items,
    (val) => emit('update:modelValue', val),
    { deep: true },
);

const addItem = () => items.push({});

const removeItem = (index: number) => items.splice(index, 1);
</script>
<template>
    <div class="repeater">
        <div v-for="(item, index) in items" :key="index" class="card mb-3 shadow-sm">
            <div class="card-body position-relative">
                <div class="mb-2">
                    <slot name="default" :item="item" :index="index" />
                </div>
                <div v-if="items.length > 1" class="d-flex justify-content-end align-items-start mb-2">
                    <button type="button" class="btn btn-sm btn-outline-danger" @click="removeItem(index)">
                        <i class="bi bi-x-circle me-1"></i> Odstrániť
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <button type="button" class="btn btn-primary" @click="addItem"><i class="bi bi-plus-circle me-1"></i> Pridať položku</button>
        </div>
    </div>
</template>
