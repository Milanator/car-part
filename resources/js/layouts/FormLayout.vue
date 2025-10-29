<script setup lang="ts">
import Loader from '@/components/Loader.vue';
import { useFormLayout } from '@/composables/useFormLayout';
import { FormLayoutProps } from '@/types/FormLayoutProps';

const props = defineProps<FormLayoutProps>();

const { form, loaded, title, submit, goBack } = useFormLayout(props);
</script>
<template>
    <div class="container py-5">
        <template v-if="loaded">
            <h1 class="mb-4">{{ title }}</h1>

            <form @submit.prevent="submit">
                <slot name="fields" :form="form" />
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Uložiť</button>
                    <button type="button" @click="goBack" class="btn btn-secondary ms-2">Späť</button>
                </div>
            </form>
        </template>

        <template v-else>
            <Loader />
        </template>
    </div>
</template>
