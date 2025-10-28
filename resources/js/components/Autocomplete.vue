<script lang="ts" setup>
import axios from 'axios';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';

interface Props {
    modelValue?: any;
    apiUrl: string;
    labelField?: string;
    required?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    labelField: 'name',
    required: false,
});

const emit = defineEmits(['update:modelValue', 'select']);

const DEBOUNCE = 500;

const searchTerm = ref(props.modelValue);
const suggestions = ref<any[]>([]);
const showDropdown = ref(false);

const fetchSuggestions = debounce(async (term: string) => {
    // empty term
    if (!term.trim()) {
        suggestions.value = [];
        emit('update:modelValue', undefined);
        return;
    }

    try {
        const res = await axios.get(props.apiUrl, { params: { [props.labelField]: term } });

        if (res.data?.length) {
            // preset item
            suggestions.value = res.data;
            showDropdown.value = true;
        } else {
            // custom item
            selectItem({ name: term });
        }
    } catch (error) {
        console.error('Autocomplete error:', error);
    }
}, DEBOUNCE);

watch(searchTerm, (newVal) => {
    fetchSuggestions(newVal);
});

const selectItem = (item: any) => {
    emit('update:modelValue', item);
    emit('select', item);

    searchTerm.value = getLabel(item);

    showDropdown.value = false;
};

const hideDropdown = () => {
    setTimeout(() => (showDropdown.value = false), 200);
};

const getLabel = (item: any) => item[props.labelField] ?? item;
</script>
<template>
    <div class="position-relative">
        <input type="text" class="form-control" v-model="searchTerm" @focus="showDropdown = true" @blur="hideDropdown" :required="required" />

        <ul v-if="showDropdown && suggestions.length" class="list-group position-absolute w-100 mt-1 shadow-sm" style="z-index: 1000">
            <li v-for="item in suggestions" :key="item.id" class="list-group-item list-group-item-action" @mousedown.prevent="selectItem(item)">
                {{ getLabel(item) }}
            </li>
        </ul>
    </div>
</template>
<style scoped>
.list-group-item {
    cursor: pointer;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
</style>
