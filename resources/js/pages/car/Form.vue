<script lang="ts" setup>
import Autocomplete from '@/components/Autocomplete.vue';
import Loader from '@/components/Loader.vue';
import Repeater from '@/components/Repeater.vue';
import { useCarStore } from '@/stores/useCarStore';
import { Car } from '@/types/Car';
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();

const carStore = useCarStore();

const id = route.params.id as number | undefined;

const form = reactive<Car>({
    name: '',
    registration_number: '',
    is_registered: false,
    parts: [],
});

const errors = ref<Record<string, string>>({});
const loaded = ref<boolean>(false);

const isEdit = computed(() => !!id);
const title = computed(() => (isEdit.value ? `Upraviť auto ${form.name}` : 'Pridať auto'));

onMounted(async () => {
    if (isEdit.value) {
        const data = await carStore.getItem(id);

        Object.assign(form, data);
    }

    loaded.value = true;
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

const isNewPart = (item: object) => item.name && !item.id;

const goBack = () => router.push('/car');
</script>
<template>
    <div class="container py-5">
        <template v-if="loaded">
            <h1 class="mb-4">{{ title }}</h1>

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

                <div class="mb-3">
                    <label for="registration_number" class="form-label">Registračné číslo <span v-show="form.is_registered">*</span></label>
                    <input
                        type="text"
                        id="registration_number"
                        v-model="form.registration_number"
                        class="form-control"
                        :required="form.is_registered"
                    />
                    <div v-if="errors.registration_number" class="text-danger mt-1">{{ errors.registration_number }}</div>
                </div>

                <h2>Časti</h2>
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
                                <label class="form-label">Sériové číslo</label>
                                <input type="text" v-model="item.serial_number" class="form-control" required :readonly="!isNewPart(item)" />
                                <div v-if="errors.serial_number" class="text-danger mt-1">{{ errors.serial_number }}</div>
                            </div>

                            <div v-if="isNewPart(item)" class="alert alert-warning" role="alert">
                                Časť zatiaľ neexistuje. Po uložení bude vytvorená.
                            </div>
                        </div>
                    </template>
                </Repeater>

                <button type="submit" class="btn btn-primary">Uložiť</button>
                <button type="button" @click="goBack" class="btn btn-secondary ms-2">Späť</button>
            </form>
        </template>
        <template v-else>
            <Loader />
        </template>
    </div>
</template>
