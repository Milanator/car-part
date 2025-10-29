import { ref, watch } from 'vue';
import axios from 'axios';
import { debounce } from 'lodash';
import { AutocompleteProps } from '@/types/AutocompleteProps';

export function useAutocomplete(options: AutocompleteProps, emit: any) {
  const labelField = options.labelField ?? 'name';
  const DEBOUNCE =  500;

  const searchTerm = ref(options.modelValue ?? '');
  const suggestions = ref<any[]>([]);
  const showDropdown = ref(false);

  const fetchSuggestions = debounce(async (term: string) => {
    if (!term.trim()) {
      suggestions.value = [];
      emit('update:modelValue', undefined);
      return;
    }

    try {
      const res = await axios.get(options.apiUrl, { params: { [labelField]: term } });

      if (res.data?.length) {
        suggestions.value = res.data;
        showDropdown.value = true;
      } else {
        selectItem({ [labelField]: term });
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

  const getLabel = (item: any) => item[labelField] ?? item;

  return {
    searchTerm,
    suggestions,
    showDropdown,
    selectItem,
    hideDropdown,
    getLabel,
  };
}
