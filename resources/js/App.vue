<template>
    <div class="d-flex flex-column min-vh-100">
        <!-- Header -->
        <header class="bg-primary text-white p-3 mb-4">
            <div class="container d-flex justify-content-between align-items-center">
                <router-link to="/" class="text-white text-decoration-none">
                    <h1 class="m-0 h4">Car-part</h1>
                </router-link>
                <nav>
                    <router-link to="/" class="text-white me-3">Domov</router-link>
                    <router-link to="/car" class="text-white me-3">Auta</router-link>
                    <router-link to="/part" class="text-white">Časti</router-link>
                </nav>
            </div>
        </header>

        <!-- Main content -->
        <main class="container flex-grow-1">
            <router-view />
        </main>
    </div>
</template>
