<script lang="ts" setup>
import Input from '@/components/form/Input.vue';
import { useAutocomplete } from '@/composables/useAutocomplete';
import { AutocompleteProps } from '@/types/AutocompleteProps';

const props = withDefaults(defineProps<AutocompleteProps>(), {
    modelValue: '',
    labelField: 'name',
    required: false,
});

const emit = defineEmits(['update:modelValue', 'select']);

const { searchTerm, suggestions, showDropdown, selectItem, hideDropdown, getLabel, fetchSuggestions } = useAutocomplete(props, emit);
</script>
<template>
    <div class="position-relative">
        <!-- Input -->
        <Input
            :id="id"
            label="Názov"
            classes="as-select"
            v-model="searchTerm"
            :required="required"
            @focus="showDropdown = true"
            @blur="hideDropdown"
            @input="fetchSuggestions(searchTerm)"
        />

        <!-- Options -->
        <ul v-if="showDropdown && suggestions.length" class="list-group position-absolute w-100 mt-1 shadow-sm" style="z-index: 1000">
            <li v-for="item in suggestions" :key="item.id" class="list-group-item list-group-item-action" @mousedown.prevent="selectItem(item)">
                {{ getLabel(item) }}
            </li>
        </ul>
    </div>
</template>
<style>
.list-group-item {
    cursor: pointer;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}

.as-select {
    position: relative;
    appearance: none;
    cursor: pointer;
}

.as-select::after {
    content: '';
    position: absolute;
    right: 1rem;
    bottom: 20%;
    transform: translateY(-50%) rotate(45deg);
    width: 8px;
    height: 8px;
    border-right: 2px solid #666;
    border-bottom: 2px solid #666;
    pointer-events: none;
}
</style>
