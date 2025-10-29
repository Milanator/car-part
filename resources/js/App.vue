<script setup lang="ts">
import FlashMessage from '@/components/FlashMessage.vue';
</script>
<template>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light p-3">
                <router-link to="/" class="text-decoration-none">CarPart</router-link>
            </div>
            <div class="list-group list-group-flush">
                <router-link class="list-group-item list-group-item-action list-group-item-light p-3" to="/car">Autá</router-link>
                <router-link class="list-group-item list-group-item-action list-group-item-light p-3" to="/part">Diely</router-link>
            </div>
        </div>
        <!-- Page content wrapper-->
        <div id="page-content-wrapper">
            <!-- Page content-->
            <div class="container-fluid">
                <router-view />
            </div>
        </div>
    </div>

    <FlashMessage />
</template>
<style>
#sidebar-wrapper {
    min-width: 200px;
}

#page-content-wrapper {
    width: 100%;
}
</style>
