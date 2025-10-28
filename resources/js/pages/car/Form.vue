<script lang="ts" setup>
import Autocomplete from '@/components/Autocomplete.vue';
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

const isNewPart = (item: object) => item.name && !item.id;
</script>
<template>
    <FormLayout :store="carStore" type="car" title="auto" :data="data">
        <template #fields="{ form, errors }">
            <div class="mb-3">
                <label for="name" class="form-label">Názov</label>
                <input type="text" id="name" v-model="form.name" class="form-control" required />
                <div v-if="errors.name" class="text-danger mt-1">{{ errors.name }}</div>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" id="is_registered" v-model="form.is_registered" class="form-check-input" :checked="form.is_registered" />
                <label for="is_registered" class="form-check-label">Registrované</label>
            </div>

            <div class="mb-3">
                <label for="registration_number" class="form-label">Registračné číslo <span v-show="form.is_registered">*</span></label>
                <input type="text" id="registration_number" v-model="form.registration_number" class="form-control" :required="form.is_registered" />
                <div v-if="errors.registration_number" class="text-danger mt-1">{{ errors.registration_number }}</div>
            </div>

            <h2>Diely</h2>
            <Repeater v-model="form.parts">
                <template #default="{ item, index }">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-sm">
                            <label class="form-label">Názov</label>
                            <Autocomplete
                                api-url="/api/part"
                                search-attribute="name"
                                :required="true"
                                v-model="item.name"
                                @select="Object.assign(item, $event)"
                            />
                        </div>
                        <!-- Serial number -->
                        <div class="col-sm">
                            <label class="form-label">Sériové číslo <span v-show="isNewPart(item)">*</span></label>
                            <input type="text" v-model="item.serial_number" class="form-control" required :readonly="!isNewPart(item)" />
                            <div v-if="errors.serial_number" class="text-danger mt-1">{{ errors.serial_number }}</div>
                        </div>

                        <div v-if="isNewPart(item)" class="alert alert-warning" role="alert">Diel zatiaľ neexistuje. Po uložení bude vytvorená.</div>
                    </div>
                </template>
            </Repeater>
        </template>
    </FormLayout>
</template>
