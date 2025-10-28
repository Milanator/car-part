<script setup lang="ts">
import { useFlashMessageStore } from '@/stores/useFlashMessageStore';

const flashMessage = useFlashMessageStore();
</script>
<template>
    <div
        v-if="flashMessage.message"
        :class="['alert', 'alert-' + flashMessage.type, 'alert-dismissible', 'fade', 'show']"
        role="alert"
        class="position-fixed bottom-0 end-0 m-3 shadow-lg"
        style="min-width: 250px; z-index: 2000"
    >
        {{ flashMessage.message }}
        <button type="button" class="btn-close" aria-label="Close" @click="flashMessage.clear()"></button>
    </div>
</template>
