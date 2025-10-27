<script lang="ts" setup>
import { Car } from '@/types/Car';
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3';
import { computed, reactive } from 'vue';

const props = defineProps<{ model: Car }>();

// Form data
const form = reactive({
    name: props.model.name || '',
    registration_number: props.model.registration_number || '',
    is_registered: props.model.is_registered || false,
});

// Zisti, či ide o edit alebo create
const isEdit = computed(() => !!props.model.id);

// Submit handler
const submit = () => {
    if (isEdit.value) {
        Inertia.put(`/car/${props.model.id}`, form);
    } else {
        Inertia.post('/car', form);
    }
};
</script>
<template>
    <div class="container py-5">
        <h1 class="mb-4">{{ isEdit ? 'Upraviť auto' : 'Pridať auto' }}</h1>

        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="name" class="form-label">Názov</label>
                <input type="text" id="name" v-model="form.name" class="form-control" />
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="is_registered" v-model="form.is_registered" class="form-check-input" :checked="form.is_registered" />
                <label for="is_registered" class="form-check-label">Registrované</label>
            </div>

            <div v-if="form.is_registered" class="mb-3">
                <label for="registration_number" class="form-label">Registračné číslo</label>
                <input type="text" id="registration_number" v-model="form.registration_number" class="form-control" required />
            </div>

            <button type="submit" class="btn btn-primary">{{ isEdit ? 'Upraviť' : 'Pridať' }}</button>
            <Link href="/car" class="btn btn-secondary ms-2">Späť</Link>
        </form>
    </div>
</template>
