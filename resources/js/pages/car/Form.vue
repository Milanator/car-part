<script lang="ts" setup>
import { useCarStore } from '@/stores/useCarStore';
import { Car } from '@/types/Car';
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();

const carStore = useCarStore();

const id = route.params.id as string | undefined;

const form = reactive<Car>({
    name: '',
    registration_number: '',
    is_registered: false,
});

const errors = ref<Record<string, string>>({});

const isEdit = computed(() => !!id);

onMounted(async () => {
    if (isEdit.value) {
        const data = await carStore.getItem(id);

        Object.assign(form, data);
    }
});

const submit = async () => {
    errors.value = {};

    if (isEdit.value) {
        await carStore.updateItem(id, form);
    } else {
        await carStore.createItem(form);
    }

    goBack();
};

const goBack = () => router.push('/car');
</script>
<template>
    <div class="container py-5">
        <h1 class="mb-4">{{ isEdit ? 'Upraviť auto' : 'Pridať auto' }}</h1>

        <form @submit.prevent="submit">
            <div class="mb-3">
                <label for="name" class="form-label">Názov</label>
                <input type="text" id="name" v-model="form.name" class="form-control" />
                <div v-if="errors.name" class="text-danger mt-1">{{ errors.name }}</div>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="is_registered" v-model="form.is_registered" class="form-check-input" :checked="form.is_registered" />
                <label for="is_registered" class="form-check-label">Registrované</label>
            </div>

            <div v-if="form.is_registered" class="mb-3">
                <label for="registration_number" class="form-label">Registračné číslo</label>
                <input type="text" id="registration_number" v-model="form.registration_number" class="form-control" required />
                <div v-if="errors.registration_number" class="text-danger mt-1">{{ errors.registration_number }}</div>
            </div>

            <button type="submit" class="btn btn-primary">{{ isEdit ? 'Upraviť' : 'Pridať' }}</button>
            <button type="button" @click="goBack" class="btn btn-secondary ms-2">Späť</button>
        </form>
    </div>
</template>
