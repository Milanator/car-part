<script lang="ts" setup>
import { onMounted, ref } from 'vue';

interface Props {
    modelValue: any[];
}

const props = defineProps<Props>();

const emit = defineEmits(['update:modelValue']);

const items = ref([...props.modelValue]);

onMounted(() => {
    if (items.value.length === 0) {
        items.value.push({});
    }
});

const addItem = () => {
    items.value.push({});
    
    emit('update:modelValue', [...items.value]);
};

const removeItem = (index: number) => {
    items.value = items.value.filter((_, i) => i !== index);

    emit('update:modelValue', [...items.value]);
};
</script>
<template>
    <div class="repeater">
        <div v-for="(item, index) in items" :key="index" class="card mb-3 shadow-sm">
            <div class="card-body position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">Položka {{ index + 1 }}</small>
                    <!-- Remove -->
                    <div v-if="items.length > 1">
                        <button type="button" class="btn btn-sm btn-outline-danger" @click="removeItem(index)">
                            <i class="bi bi-x-circle me-1"></i> Odstrániť položku
                        </button>
                    </div>
                </div>
                <div class="my-2">
                    <!-- content -->
                    <slot name="default" :item="item" :index="index" />
                </div>
            </div>
        </div>
        <!-- Add new -->
        <div class="text-right my-3">
            <button type="button" class="btn btn-primary" @click="addItem"><i class="bi bi-plus-circle me-1"></i> Pridať položku</button>
        </div>
    </div>
</template>
