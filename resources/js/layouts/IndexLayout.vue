<script setup lang="ts">
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

const props = defineProps<{
    store: any;
    title: string;
    type: string;
}>();

const router = useRouter();

const goToCreate = () => router.push(`/${props.type}/create`);
const goToEdit = (id: number) => router.push(`/${props.type}/${id}/edit`);
const deleteCar = async (id: number) => {
    if (!confirm('Naozaj chcete vymazať toto auto?')) return;

    await props.store.deleteItem(id);
};

onMounted(async () => {
    await props.store.fetchItems();
});
</script>
<template>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">{{ title }}</h1>
            <button class="btn btn-primary" @click="goToCreate"><i class="bi bi-plus-lg"></i> Pridať</button>
        </div>

        <slot name="filter" />

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead>
                    <slot name="head" />
                </thead>
                <tbody>
                    <tr v-for="row in props.store.items" :key="row.id">
                        <slot name="row" :row="row" />

                        <td>
                            <button @click="goToEdit(row.id)" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-fill"></i> Upraviť</button>
                            <button @click="deleteCar(row.id)" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Odstrániť</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
