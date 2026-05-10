<template>
    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 border-b border-gray-100 bg-[#f3f4f6] w-full ">
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
                    <Link :href="farmersImpact()" class="transition-colors text-neutral-muted hover:text-brand-primary">
                        Agriculteurs
                    </Link>
                    <Link :href="about()" class="transition-colors text-neutral-muted hover:text-brand-primary">À propos
                    </Link>
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
                    <button @click="toggleMobileMenu"
                        class="p-2 text-neutral-body hover:text-brand-primary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-primary">
                        <i :class="[showMobileMenu ? 'fas fa-times' : 'fas fa-bars', 'text-2xl']"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <transition enter-active-class="transition ease-out duration-200 transform"
            enter-from-class="opacity-0 -translate-x-full" enter-to-class="opacity-100 translate-x-0"
            leave-active-class="transition ease-in duration-200 transform" leave-from-class="opacity-100 translate-x-0"
            leave-to-class="opacity-0 -translate-x-full">
            <div v-if="showMobileMenu" class="fixed inset-0 z-9999 md:hidden">
                <!-- Overlay -->
                <div @click="toggleMobileMenu" class="absolute inset-0 bg-opacity-50"></div>

                <!-- Menu Content -->
                <div class="relative w-64 max-w-full h-full bg-white shadow-xl flex flex-col py-4 space-y-4">
                    <!-- Close Button -->
                    <div class="px-4 flex justify-end">
                        <button @click="toggleMobileMenu"
                            class="p-2 text-neutral-body hover:text-brand-primary focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-primary">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                <div class="flex items-center space-x-2 px-4 py-2">
                    <div class="p-2 rounded-lg bg-brand-primary">
                        <i class="text-xl text-white fas fa-leaf"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-brand-dark">AgriLink<span
                            class="text-brand-primary">.cm</span></span>
                </div>
                    <!-- Mobile Navigation Links -->
                    <Link :href="home()" @click="toggleMobileMenu"
                        class="block px-4 py-2 text-lg font-semibold text-neutral-title hover:text-brand-primary hover:bg-gray-50 transition-colors">
                        Accueil</Link>
                    <Link :href="catalog()" @click="toggleMobileMenu"
                        class="block px-4 py-2 text-lg font-semibold text-neutral-title hover:text-brand-primary hover:bg-gray-50 transition-colors">
                        Catalogue</Link>
                    <Link :href="farmersImpact()" @click="toggleMobileMenu"
                        class="block px-4 py-2 text-lg font-semibold text-neutral-title hover:text-brand-primary hover:bg-gray-50 transition-colors">
                        Agriculteurs
                    </Link>
                    <Link :href="about()" @click="toggleMobileMenu"
                        class="block px-4 py-2 text-lg font-semibold text-neutral-title hover:text-brand-primary hover:bg-gray-50 transition-colors">
                        À propos
                    </Link>

                    <!-- Mobile Auth Buttons -->
                    <div class="px-4 pt-4 border-t border-gray-100 space-y-3">
                        <button @click="openSidebar"
                            class="relative w-full flex items-center justify-center py-2 rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors">
                            <i class="fas fa-shopping-cart text-lg mr-2"></i> Panier
                            <span
                                class="absolute top-1 right-1 bg-accent-cta text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{
                                    store.totalItems }}</span>
                        </button>
                        <Link :href="connexion()" @click="toggleMobileMenu"
                            class="block w-full text-center px-4 py-2 font-medium text-neutral-body hover:text-brand-primary rounded-lg hover:bg-gray-50">
                            Connexion</Link>
                        <Link :href="inscription()" @click="toggleMobileMenu"
                            class="block w-full text-center bg-brand-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-brand-hover transition-all shadow-sm hover:shadow-md">
                            Rejoindre</Link>
                    </div>
                </div>
            </div>
        </transition>
    </nav>
    <CartSidebar ref="cartSidebarRef" />
    <slot />
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import CartSidebar from "@/Components/CartSidebar.vue";
import { useCartStore } from "@/Pages/store/cartStore";
import { about, catalog, connexion } from "@/routes";
import { inscription } from "@/routes";
import { home } from "@/routes";
import { farmersImpact } from "@/routes";

const store = useCartStore();
const cartSidebarRef = ref<InstanceType<typeof CartSidebar> | null>(null);

const openSidebar = () => {
    cartSidebarRef.value?.openCart();
};

const showMobileMenu = ref(false);

const toggleMobileMenu = () => {
    showMobileMenu.value = !showMobileMenu.value;
};

</script>

<style scoped>
.glass-nav {
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.8);
}
</style>
