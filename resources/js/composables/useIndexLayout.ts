import { IndexLayoutProps } from '@/types/IndexLayoutProps';
import { debounce } from 'lodash';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

export function useIndexLayout(props: IndexLayoutProps) {
    const router = useRouter();

    const search = ref(undefined);

    const goToCreate = () => router.push(`/${props.type}/create`);

    const goToEdit = (id: number) => router.push(`/${props.type}/${id}/edit`);

    const deleteItem = async (id: number) => {
        if (!confirm('Naozaj chcete vymazať túto položku?')) return;

        await props.store.deleteItem(id);
    };

    const filter = debounce((event: string | undefined) => {
        const params = Object.fromEntries(props.store.filterable.map((field: string) => [field, event]));

        props.store.fetchItems(params);
    }, 1000);

    onMounted(async () => {
        await props.store.fetchItems();
    });

    return { goToCreate, goToEdit, deleteItem, filter, search };
}
