<script lang="ts" setup>
import axios from 'axios';
import { debounce } from 'lodash';
import { ref, watch } from 'vue';

interface Props {
    modelValue?: any;
    apiUrl: string;
    placeholder?: string;
    labelField?: string;
    valueField?: string;
    searchAttribute: string;
}

const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    placeholder: 'Vyhľadať...',
    labelField: 'name',
    valueField: 'id',
    searchAttribute: 'name',
});

const emit = defineEmits(['update:modelValue', 'select']);

const searchTerm = ref('');
const suggestions = ref<any[]>([]);
const showDropdown = ref(false);

const fetchSuggestions = debounce(async (term: string) => {
    if (!term.trim()) {
        suggestions.value = [];
        return;
    }

    try {
        const res = await axios.get(props.apiUrl, { params: { [props.searchAttribute]: term } });
        suggestions.value = res.data;
    } catch (error) {
        console.error('Autocomplete error:', error);
    }
}, 300);

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
    setTimeout(() => {
        showDropdown.value = false;
    }, 200);
};

const getLabel = (item: any) => item[props.labelField] ?? item;
</script>
<template>
    <div class="position-relative">
        <input type="text" class="form-control" v-model="searchTerm" :placeholder="placeholder" @focus="showDropdown = true" @blur="hideDropdown" />

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
