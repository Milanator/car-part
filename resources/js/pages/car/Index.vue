<script lang="ts" setup>
import { useCarStore } from '@/stores/useCarStore';
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const carStore = useCarStore();

onMounted(async () => {
    await carStore.fetchItems();
});

const deleteCar = async (id: number) => {
    if (!confirm('Naozaj chcete vymazať toto auto?')) return;

 await carStore.deleteItem(id);
};

const goToCreate = () => router.push('/car/create');
const goToEdit = (id: number) => router.push(`/car/${id}/edit`);
</script>
<template>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Zoznam áut</h1>
            <button @click="goToCreate" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Pridať auto</button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Názov</th>
                        <th scope="col">Reg. číslo</th>
                        <th scope="col">Registrované</th>
                        <th scope="col">Akcie</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="car in carStore.items" :key="car.id">
                        <td>{{ car.id }}</td>
                        <td>{{ car.name }}</td>
                        <td>{{ car.registration_number || '-' }}</td>
                        <td>
                            <span class="badge" :class="car.is_registered ? 'bg-success' : 'bg-secondary'">
                                {{ car.is_registered_text }}
                            </span>
                        </td>
                        <td>
                            <button @click="goToEdit(car.id)" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-fill"></i> Upraviť</button>
                            <button @click="deleteCar(car.id)" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i> Odstrániť</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
