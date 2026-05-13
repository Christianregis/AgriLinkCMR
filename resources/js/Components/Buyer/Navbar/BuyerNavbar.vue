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
                <div class="relative">
                    <button @click="toggleProfileMenu"
                        class="w-11 h-11 rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <img :src="props.profile_photo ? props.profile_photo : `https://ui-avatars.com/api/?name=` + props.name + `&background=2D6A4F&color=fff`"
                            class="w-full h-full object-cover" />
                    </button>

                    <!-- Profile Dropdown Menu -->
                    <transition enter-active-class="transition ease-out duration-100"
                        enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                        leave-active-class="transition ease-in duration-75"
                        leave-from-class="transform opacity-100 scale-100"
                        leave-to-class="transform opacity-0 scale-95">
                        <div v-if="isProfileMenuOpen"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-sm font-bold text-neutral-title">{{ props.name }}</p>
                                <p class="text-xs text-neutral-muted mt-1">Acheteur Premium</p>
                            </div>
                            <nav class="py-2">
                                <Link :href="dashboard()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-tachometer-alt text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Tableau de bord
                                </Link>
                                <Link :href="buyerOrderShow()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-receipt text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Mes Commandes
                                </Link>
                                <Link :href="buyerProfile()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-user-circle text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Profil
                                </Link>
                            </nav>
                            <div class="border-t border-gray-50 py-2">
                                <Link :href="logout()"
                                    class="flex items-center px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors group">
                                    <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                    Déconnexion
                                </Link>
                            </div>
                        </div>
                    </transition>

                    <!-- Overlay to close menu -->
                    <div v-if="isProfileMenuOpen" @click="isProfileMenuOpen = false" class="fixed inset-0 z-40"></div>
                </div>
            </div>
        </div>
    </header>
    <CartSidebar ref="cartSidebarRef" />
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import CartSidebar from '@/Components/CartSidebar.vue'
import { useCartStore } from '@/Pages/store/cartStore'
import { buyerOrderShow, buyerProfile, dashboard, logout } from '@/routes'

interface User {
    name: string
    profile_photo?: string
}

const props = defineProps<User>()
const store = useCartStore()
const cartSidebarRef = ref<InstanceType<typeof CartSidebar> | null>(null)
const isProfileMenuOpen = ref<boolean>(false)

const openSidebar = (): void => {
    cartSidebarRef.value?.openCart()
}

const toggleProfileMenu = (): void => {
    isProfileMenuOpen.value = !isProfileMenuOpen.value
}

const emit = defineEmits(['openbuyerSidebar'])
const handleOpenBuyerSidebar = (): void => {
    emit('openbuyerSidebar')
}
</script>
