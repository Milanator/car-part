<script lang="ts" setup>
import Autocomplete from '@/components/form/Autocomplete.vue';
import Checkbox from '@/components/form/Checkbox.vue';
import Input from '@/components/form/Input.vue';
import Repeater from '@/components/Repeater.vue';
import FormLayout from '@/layouts/FormLayout.vue';
import { useCarStore } from '@/stores/useCarStore';
import { Car } from '@/types/Car';
import { Part } from '@/types/Part';
import { reactive } from 'vue';

const carStore = useCarStore();

const data = reactive<Car>({
    name: '',
    registration_number: '',
    is_registered: false,
    parts: [],
});

const updatePartName = (payload: Part, index: number) => {
    data.parts[index] = payload || {};
};

const hasPartName = (item: object) => item.name?.trim() !== '' && item.name !== undefined;
</script>
<template>
    <FormLayout :store="carStore" type="car" title="auto" :data="data">
        <template #fields="{ form }">
            <Input id="name" label="Názov" v-model="form.name" :required="true" />

            <Checkbox id="is_registered" label="Registrované" v-model="form.is_registered" />

            <Input id="registration_number" label="Registračné číslo" :required="form.is_registered" v-model="form.registration_number" />

            <h2>Diely</h2>
            <p>Nastav existujúce alebo nové diely.</p>

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
                                :value="item.name"
                                :required="hasPartName(item)"
                                @change="updatePartName($event, index)"
                            />
                        </div>
                        <!-- Serial number -->
                        <div class="col-sm">
                            <Input
                                :id="`registration_number-${index}`"
                                label="Sériové číslo"
                                :required="hasPartName(item)"
                                v-model="item.serial_number"
                            />
                        </div>
                    </div>
                </template>
            </Repeater>
        </template>
    </FormLayout>
</template>
