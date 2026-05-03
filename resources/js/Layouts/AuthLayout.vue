<template>
    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 border-b border-gray-100 glass-nav">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="p-2 rounded-lg bg-brand-primary">
                        <i class="text-xl text-white fas fa-leaf"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-brand-dark">AgriLink<span
                            class="text-brand-primary">.cm</span></span>
                </div>

                <!-- Desktop Menu -->
                <div class="items-center hidden space-x-8 md:flex">
                    <Link :href="home()" class="font-semibold text-brand-primary">Accueil</Link>
                    <Link :href="catalog()" class="transition-colors text-neutral-muted hover:text-brand-primary">
                        Catalogue</Link>
                    <Link href="#" class="transition-colors text-neutral-muted hover:text-brand-primary">Agriculteurs
                    </Link>
                    <Link href="#" class="transition-colors text-neutral-muted hover:text-brand-primary">À propos</Link>
                </div>

                <!-- Auth Buttons -->
                <div class="items-center hidden space-x-4 md:flex">
                    <button @click="openSidebar"
                        class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors">
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span
                            class="absolute -top-1 -right-1 bg-accent-cta text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{
                                store.totalItems }}</span>
                    </button>
                    <Link :href="connexion()" class="px-4 py-2 font-medium text-neutral-body hover:text-brand-primary">
                        Connexion</Link>
                    <Link :href="inscription()"
                        class="bg-brand-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-brand-hover transition-all shadow-sm hover:shadow-md">
                        Rejoindre</Link>
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button class="p-2 text-neutral-body hover:text-brand-primary">
                        <i class="text-2xl fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <CartSidebar ref="cartSidebarRef"/>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import CartSidebar from '@/Components/CartSidebar.vue';
import { useCartStore } from "@/Pages/store/cartStore";
import { catalog, connexion } from "@/routes";
import { inscription } from "@/routes";
import { home } from "@/routes";


const store = useCartStore();
const cartSidebarRef = ref<InstanceType<typeof CartSidebar> | null>(null);

const openSidebar = () =>{
    cartSidebarRef.value?.openCart()
}
</script>
