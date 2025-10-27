<script lang="ts" setup>
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3';

defineProps({ items: Array });

const deleteCar = (id: number) => {
    if (confirm('Naozaj chcete vymazať toto auto?')) {
        Inertia.delete(`/car/${id}`);
    }
};
</script>
<template>
    <div class="container py-5">
        <h1 class="mb-4">Zoznam áut</h1>

        <div class="mb-3">
            <Link href="/car/create" class="btn btn-primary">+ Pridať auto</Link>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th> 
                    <th>Názov</th>
                    <th>Reg. číslo</th>
                    <th>Registrované</th>
                    <th>Akcie</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="car in items" :key="car.id">
                    <td>{{ car.id }}</td>
                    <td>{{ car.name }}</td>
                    <td>{{ car.registration_number }}</td>
                    <td>
                        <span>
                            {{ car.is_registered_text }}
                        </span>
                    </td>
                    <td>
                        <Link :href="`/car/${car.id}/edit`" class="btn btn-sm btn-warning me-2">Upraviť</Link>
                        <button @click="deleteCar(car.id)" class="btn btn-sm btn-danger">Odstrániť</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
