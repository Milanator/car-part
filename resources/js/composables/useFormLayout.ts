import { FormLayoutProps } from '@/types/FormLayoutProps';
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export function useFormLayout(props: FormLayoutProps) {
    const router = useRouter();
    const route = useRoute();

    const id = route.params.id ? Number(route.params.id) : undefined;

    const form = reactive<object>(props.data ?? {});
    const errors = ref<object>({});
    const loaded = ref<boolean>(false);

    const isEdit = computed(() => !!id);
    const title = computed(() => (isEdit.value ? `Upraviť ${props.title}` : `Pridať ${props.title}`));

    onMounted(async () => {
        if (isEdit.value) {
            const data = await props.store.getItem(id);
       
            Object.assign(form, data);
        }
       
        loaded.value = true;
    });

    const submit = async () => {
        errors.value = {};

        try {
            if (isEdit.value) {
                // update
                await props.store.updateItem(id, form);
            } else {
                // store
                await props.store.createItem(form);
            }

            router.push(`/${props.type}`);
        } catch (e: any) {
            errors.value = e.response?.data?.errors ?? {};
            console.error('Submit error', e);
        }
    };

    const goBack = () => router.push(`/${props.type}`);

    return {
        form,
        errors,
        loaded,
        isEdit,
        title,
        submit,
        goBack,
    };
}
