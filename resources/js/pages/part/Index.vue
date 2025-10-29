<script setup lang="ts">
import IndexLayout from '@/layouts/IndexLayout.vue';
import { usePartStore } from '@/stores/usePartStore';
</script>
<template>
    <IndexLayout :store="usePartStore()" title="Zoznam dielov" type="part">
        <template #head>
            <tr>
                <th>ID</th>
                <th>Názov</th>
                <th>Sériové číslo</th>
                <th>Auto</th>
                <th>Akcie</th>
            </tr>
        </template>

        <template #row="{ row }">
            <td>{{ row.id }}</td>
            <td>{{ row.name }}</td>
            <td>{{ row.serial_number || '-' }}</td>
            <td>
                <router-link :to="`/car/${row.car.id}/edit`">{{ row.car.name }}</router-link>
            </td>
        </template>
    </IndexLayout>
</template>
