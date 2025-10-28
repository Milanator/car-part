<script lang="ts" setup>
import FormLayout from '@/layouts/FormLayout.vue';
import { usePartStore } from '@/stores/usePartStore';
import { Car } from '@/types/Car';
import { Part } from '@/types/Part';
import { reactive } from 'vue';

const partStore = usePartStore();

const data = reactive<Part>({
    name: '',
    serial_number: '',
    car: {
        name: '',
    } as Car,
});
</script>
<template>
    <FormLayout :store="partStore" title="diel" type="part" :data="data">
        <template #fields="{ form, errors }">
            <div class="mb-3">
                <label for="name" class="form-label">Názov</label>
                <input type="text" id="name" v-model="form.name" class="form-control" required />
                <div v-if="errors.name" class="text-danger mt-1">{{ errors.name }}</div>
            </div>

            <div class="mb-3">
                <label for="serial_number" class="form-label">Sériové číslo</label>
                <input type="text" id="serial_number" v-model="form.serial_number" class="form-control" required />
                <div v-if="errors.serial_number" class="text-danger mt-1">{{ errors.serial_number }}</div>
            </div>

            <div class="mb-3">
                <label for="car_name" class="form-label">Auto</label>
                <input type="text" id="car_name" v-model="form.car.name" class="form-control" required readonly />
            </div>
        </template>
    </FormLayout>
</template>
