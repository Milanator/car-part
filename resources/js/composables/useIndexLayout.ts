import { IndexLayoutProps } from '@/types/IndexLayoutProps';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

export function useIndexLayout(props: IndexLayoutProps) {
    const router = useRouter();

    const goToCreate = () => router.push(`/${props.type}/create`);

    const goToEdit = (id: number) => router.push(`/${props.type}/${id}/edit`);

    const deleteItem = async (id: number) => {
        if (!confirm('Naozaj chcete vymazať túto položku?')) return;

        await props.store.deleteItem(id);
    };

    onMounted(async () => {
        await props.store.fetchItems();
    });

    return { goToCreate, goToEdit, deleteItem };
}
