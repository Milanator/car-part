<script lang="ts" setup>
import Autocomplete from '@/components/form/Autocomplete.vue';
import Checkbox from '@/components/form/Checkbox.vue';
import Input from '@/components/form/Input.vue';
import Repeater from '@/components/Repeater.vue';
import FormLayout from '@/layouts/FormLayout.vue';
import { useCarStore } from '@/stores/useCarStore';
import { Car } from '@/types/Car';
import { reactive } from 'vue';

const carStore = useCarStore();

const data = reactive<Car>({
    name: '',
    registration_number: '',
    is_registered: false,
    parts: [],
});

const updatePartName = (payload, item, index) => {
    // Object.assign(item, payload)
    console.log(payload);
    data.parts[index] = payload;

    console.log(data.parts);
};
</script>
<template>
    <FormLayout :store="carStore" type="car" title="auto" :data="data">
        <template #fields="{ form }">
            <Input id="name" label="Názov" v-model="form.name" :required="true" />

            <Checkbox id="is_registered" label="Registrované" v-model="form.is_registered" />

            <Input id="registration_number" label="Registračné číslo" v-model="form.registration_number" :required="Boolean(form.is_registered)" />

            <h2>Diely</h2>
            <Repeater v-model="form.parts">
                <template #default="{ item, index }">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-sm">
                            <Autocomplete
                                :id="`name-${index}`"
                                label="Názov"
                                label-field="name"
                                api-url="/api/part"
                                :required="true"
                                v-model="item.name"
                                @select="updatePartName($event, item, index)"
                            />
                        </div>
                        <!-- Serial number -->
                        <div class="col-sm">
                            <Input :id="`registration_number-${index}`" label="Sériové číslo" v-model="item.serial_number" :required="true" />
                        </div>
                    </div>
                </template>
            </Repeater>
        </template>
    </FormLayout>
</template>
