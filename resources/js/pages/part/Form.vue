<script lang="ts" setup>
import Input from '@/components/form/Input.vue';
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
        <template #fields="{ form }">
            <Input id="name" label="Názov" v-model="form.name" :required="true" />

            <Input id="serial_number" label="Sériové číslo" v-model="form.serial_number" :required="true" />

            <Input id="car_name" label="Auto" v-model="form.car.name" :required="true" :readonly="true" />
        </template>
    </FormLayout>
</template>
