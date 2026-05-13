<template>
    <header class="h-20 glass-header border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-30">
        <div class="flex items-center">
            <button class="lg:hidden text-neutral-body mr-4" @click="toggleSidebar">
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
                                <p class="text-xs text-neutral-muted mt-1">Producteur Certifié</p>
                            </div>
                            <nav class="py-2">
                                <Link :href="dashboard()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-tachometer-alt text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Tableau de bord
                                </Link>
                                <Link :href="farmerOrdersShow()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-receipt text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Commandes
                                </Link>
                                <Link :href="farmerProductsShow()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-box text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Mes Produits
                                </Link>
                                <Link :href="farmerProfile()"
                                    class="flex items-center px-4 py-2.5 text-sm text-neutral-body hover:bg-gray-50 hover:text-brand-primary transition-colors group">
                                    <i
                                        class="fas fa-user-circle text-neutral-muted group-hover:text-brand-primary mr-3 w-4"></i>
                                    Profil
                                </Link>
                            </nav>
                            <div class="border-t border-gray-50 py-2">
                                <Link href="#"
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
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import { dashboard, farmerOrdersShow, farmerProductsShow, farmerProfile } from '@/routes';

interface User {
    name: string
    profile_photo?: string
}

const props = defineProps<User>()
const isProfileMenuOpen = ref<boolean>(false)

const emit = defineEmits(['toggleSidebar'])

const toggleSidebar = (): void => {
    emit('toggleSidebar')
}

const toggleProfileMenu = (): void => {
    isProfileMenuOpen.value = !isProfileMenuOpen.value
}
</script>
