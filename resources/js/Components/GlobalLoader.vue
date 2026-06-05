<template>
    <Transition name="loader">
        <div v-if="isLoading"
            class="fixed inset-0 z-99999 bg-black/30 backdrop-blur-sm flex flex-col items-center justify-center">
            <!-- Logo AgriLink -->
            <div
                class="w-24 h-24 bg-brand-primary rounded-3xl flex items-center justify-center shadow-2xl animate-pulse">
                <i class="fas fa-leaf text-white text-4xl animate-spin"></i>
            </div>

            <p class="mt-6 text-white font-semibold tracking-wide">
                Chargement...
            </p>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { isLoading } from '../Composables/useGlobalLoader'
</script>

<style scoped>
.loader-enter-active,
.loader-leave-active {
    transition: all .25s ease;
}

.loader-enter-from,
.loader-leave-to {
    opacity: 0;
}

.loader-enter-from div,
.loader-leave-to div {
    transform: scale(.9);
}
</style>