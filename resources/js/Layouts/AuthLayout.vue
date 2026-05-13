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
                <div v-if="user && user.role === 'buyer'" class="flex items-center space-x-6">
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
                    <div class="relative">
                        <button @click="toggleProfileMenu"
                            class="w-11 h-11 rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            <img :src="user.profile_photo ? user.profile_photo : `https://ui-avatars.com/api/?name=` + user.name + `&background=2D6A4F&color=fff`"
                                class="w-full h-full object-cover" />
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <div v-if="isProfileMenuOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-sm font-bold text-neutral-title">{{ user.name }}</p>
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
                    </div>

                    <!-- Overlay to close menu -->
                    <div v-if="isProfileMenuOpen" @click="isProfileMenuOpen = false" class="fixed inset-0 z-40">
                    </div>

                </div>
                <div v-else-if="user && user.role === 'farmer'" class="flex items-center space-x-6">
                    <button
                        class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors">
                        <i class="far fa-bell text-lg"></i>
                        <span
                            class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    <div class="flex items-center space-x-3 pl-6 border-l border-gray-100">
                        <div class="relative">
                            <button @click="toggleProfileMenu"
                                class="w-11 h-11 rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                                <img :src="user.profile_photo ? user.profile_photo : `https://ui-avatars.com/api/?name=` + user.name + `&background=2D6A4F&color=fff`"
                                    class="w-full h-full object-cover" />
                            </button>

                            <!-- Profile Dropdown Menu -->
                            <transition enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95">
                                <div v-if="isProfileMenuOpen"
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                                    <div class="px-4 py-3 border-b border-gray-50">
                                        <p class="text-sm font-bold text-neutral-title">{{ user.name }}</p>
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
                            <div v-if="isProfileMenuOpen" @click="isProfileMenuOpen = false" class="fixed inset-0 z-40">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="items-center hidden space-x-4 md:flex" v-else>
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
                    <div v-if="user && user.role === 'buyer'" class="flex items-center space-x-6">
                        <button @click="toggleProfileMenu"
                            class="w-11 h-11 rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                            <img :src="user.profile_photo ? user.profile_photo : `https://ui-avatars.com/api/?name=` + user.name + `&background=2D6A4F&color=fff`"
                                class="w-full h-full object-cover" />
                        </button>

                        <!-- Profile Dropdown Menu -->
                        <transition enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <div v-if="isProfileMenuOpen"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50">
                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-sm font-bold text-neutral-title">{{ user.name }}</p>
                                    <p class="text-xs text-neutral-muted mt-1">Acheteur Premium</p>
                                </div>
                                <nav class="py-2">
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
                        <div v-if="isProfileMenuOpen" @click="isProfileMenuOpen = false" class="fixed inset-0 z-40">
                        </div>

                    </div>
                    <div v-else-if="user && user.role === 'farmer'" class="flex items-center space-x-6">
                        <button
                            class="relative w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 text-neutral-muted hover:text-brand-primary transition-colors">
                            <i class="far fa-bell text-lg"></i>
                            <span
                                class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        <div class="flex items-center space-x-3 pl-6 border-l border-gray-100">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-bold text-neutral-title">{{ user.name }}</p>
                                <p class="text-[10px] font-bold text-brand-primary uppercase tracking-wider">
                                    Producteur Certifié
                                </p>
                            </div>
                            <img :src="user.profile_photo ? user.profile_photo : `https://ui-avatars.com/api/?name=` + user.name + `&background=2D6A4F&color=fff`"
                                class="w-11 h-11 rounded-xl shadow-sm border border-gray-100" />
                        </div>
                    </div>
                    <div v-else class="px-4 pt-4 border-t border-gray-100 space-y-3">
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
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import CartSidebar from "@/Components/CartSidebar.vue";
import { useCartStore } from "@/Pages/store/cartStore";
import { about, buyerOrderShow, buyerProfile, catalog, connexion, dashboard, farmerOrdersShow, farmerProductsShow, farmerProfile, logout } from "@/routes";
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

const isProfileMenuOpen = ref<boolean>(false)

const toggleProfileMenu = (): void => {
    isProfileMenuOpen.value = !isProfileMenuOpen.value
    console.log("Profile menu toggled:", isProfileMenuOpen.value);

}

const page = usePage();
const user = page.props.auth.user?.data;

</script>

<style scoped>
.glass-nav {
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.8);
}
</style>
