<template>
    <header class="h-20 glass-header border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-30">
        <div class="flex items-center">
            <button class="lg:hidden text-neutral-body mr-4">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-xl font-bold text-neutral-title">
                Agriculteur
            </h1>
        </div>

        <div class="flex items-center space-x-6">
            <button
                class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors">
                <i class="far fa-bell text-lg"></i>
                <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>
            <div class="flex items-center space-x-3 pl-6 border-l border-gray-100">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-neutral-title">{{ props.name }}</p>
                    <p class="text-[10px] font-bold text-brand-primary uppercase tracking-wider">
                        Producteur Certifié
                    </p>
                </div>
                <img :src="`https://ui-avatars.com/api/?name=` +
                    props.name +
                    `&background=2D6A4F&color=fff`
                    " class="w-11 h-11 rounded-xl shadow-sm border border-gray-100" />
            </div>
        </div>
    </header>
</template>
<script setup lang="ts">
interface User {
    name: string;
}
const props = defineProps<User>()
</script>
