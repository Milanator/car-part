<script setup lang="ts">
import IndexLayout from '@/layouts/IndexLayout.vue';
import { useCarStore } from '@/stores/useCarStore';
import { useRouter } from 'vue-router';

const carStore = useCarStore();
const router = useRouter();

const goToEdit = (id: number) => router.push(`/car/${id}/edit`);

const deleteCar = async (id: number) => {
    if (!confirm('Naozaj chcete vymazať toto auto?')) return;

    await carStore.deleteItem(id);
};
</script>
<template>
    <IndexLayout :store="carStore" title="Zoznam áut" type="car">
        <template #head>
            <tr>
                <th>ID</th>
                <th>Názov</th>
                <th>Reg. číslo</th>
                <th>Registrované</th>
                <th>Akcie</th>
            </tr>
        </template>

        <template #row="{ row }">
            <td>{{ row.id }}</td>
            <td>{{ row.name }}</td>
            <td>{{ row.registration_number || '-' }}</td>
            <td>
                <span class="badge" :class="row.is_registered ? 'bg-success' : 'bg-secondary'">
                    {{ row.is_registered_text }}
                </span>
            </td>
            <td>
                <button @click="goToEdit(row.id)" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-fill"></i> Upraviť</button>
                <button @click="deleteCar(row.id)" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Odstrániť</button>
            </td>
        </template>
    </IndexLayout>
</template>
