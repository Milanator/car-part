import { AutocompleteProps } from '@/types/form/AutocompleteProps';
import axios from 'axios';
import { debounce } from 'lodash';
import { ref } from 'vue';

export function useAutocomplete(props: AutocompleteProps, emit: any) {
    const labelField = props.labelField;
    const DEBOUNCE = 500;

    const searchTerm = ref(props.value);
    const suggestions = ref<any[]>([]);
    const showDropdown = ref(false);

    const fetchSuggestions = debounce(async (term: string) => {
        if (!term.trim()) {
            suggestions.value = [];
            emit('change', undefined);
            return;
        }

        try {
            const res = await axios.get(props.apiUrl, { params: { [labelField]: term } });

            if (res.data.items?.length) {
                suggestions.value = res.data.items;
                showDropdown.value = true;
            } else {
                setCustomValue(term);
            }
        } catch (error) {
            console.error('Autocomplete error:', error);
        }
    }, DEBOUNCE);

    const selectItem = (item: any) => {
        emit('change', item);

        searchTerm.value = getLabel(item);
        showDropdown.value = false;
    };

    const hideDropdown = () => {
        setTimeout(() => (showDropdown.value = false), 200);
    };

    const setCustomValue = (term: any) => {
        selectItem({ [labelField]: term });
    };

    const getLabel = (item: any) => item[labelField] ?? item;

    return {
        searchTerm,
        suggestions,
        showDropdown,
        selectItem,
        hideDropdown,
        getLabel,
        fetchSuggestions,
    };
}
