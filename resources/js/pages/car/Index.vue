<script setup lang="ts">
import IndexLayout from '@/layouts/IndexLayout.vue';
import { useCarStore } from '@/stores/useCarStore';
</script>
<template>
    <IndexLayout :store="useCarStore()" title="Zoznam dielov" type="car">
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
        </template>
    </IndexLayout>
</template>
