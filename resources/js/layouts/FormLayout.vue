<script setup lang="ts">
import Loader from '@/components/Loader.vue';
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const props = defineProps<{
    store: any;
    title: string;
    type: string;
    data: object;
}>();

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
            await props.store.updateItem(id, form);
        } else {
            await props.store.createItem(form);
        }

        router.push(`/${props.type}`);
    } catch (e: any) {
        errors.value = e.response?.data?.errors ?? {};
        console.error('Submit error', e);
    }
};

const goBack = () => router.push(`/${props.type}`);
</script>
<template>
    <div class="container py-5">
        <template v-if="loaded">
            <h1 class="mb-4">{{ title }}</h1>

            <form @submit.prevent="submit">
                <slot name="fields" :form="form" :errors="errors" />
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Uložiť</button>
                    <button type="button" @click="goBack" class="btn btn-secondary ms-2">Späť</button>
                </div>
            </form>
        </template>

        <template v-else>
            <Loader />
        </template>
    </div>
</template>
