<template>
    <header class="h-20 glass-header border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-30">
        <div class="flex items-center">
            <button class="lg:hidden text-neutral-body mr-4" @click="handleOpenBuyerSidebar">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h1 class="text-xl font-bold text-neutral-title">Mon Espace Acheteur</h1>
        </div>

        <div class="flex items-center space-x-6">
            <div class="hidden md:flex items-center bg-gray-50 rounded-xl px-4 py-2 border border-gray-100">
                <i class="fas fa-search text-gray-400 mr-2"></i>
                <input type="text" placeholder="Rechercher une commande..."
                    class="bg-transparent border-none focus:ring-0 text-sm text-neutral-body w-48" />
            </div>
            <button @click="openSidebar"
                class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors">
                <i class="fas fa-shopping-cart text-lg"></i>
                <span
                    class="absolute -top-1 -right-1 bg-accent-cta text-white text-[9px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{
                        store.totalItems }}</span>
            </button>
            <div class="flex items-center space-x-3 pl-6 border-l border-gray-100">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-neutral-title">{{ props.name }}</p>
                    <p class="text-[10px] font-bold text-brand-primary uppercase tracking-wider">
                        Acheteur Premium
                    </p>
                </div>
                <img :src="props.profile_photo ? props.profile_photo : `https://ui-avatars.com/api/?name=` + props.name + `&background=2D6A4F&color=fff`"
                    class="w-11 h-11 rounded-xl shadow-sm border border-gray-100" />
            </div>
        </div>
    </header>
    <CartSidebar ref="cartSidebarRef" />
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import CartSidebar from '@/Components/CartSidebar.vue';
import { useCartStore } from '@/Pages/store/cartStore';

interface User {
    name: string
    profile_photo?: string,
}
const props = defineProps<User>();
const store = useCartStore();
const cartSidebarRef = ref<InstanceType<typeof CartSidebar> | null>(null);

const openSidebar = () => {
    cartSidebarRef.value?.openCart()
}

const emit = defineEmits(['openbuyerSidebar'])
const handleOpenBuyerSidebar = () => {
    emit('openbuyerSidebar');
}
</script>
