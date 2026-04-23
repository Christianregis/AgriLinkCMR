<template>
    <aside class="hidden lg:flex flex-col w-72 bg-white border-r border-gray-100 sticky top-0 h-screen z-40">
        <div class="p-8 border-b border-gray-50">
            <div class="flex items-center space-x-2">
                <div class="bg-brand-primary p-2 rounded-lg">
                    <i class="fas fa-leaf text-white text-xl"></i>
                </div>
                <span class="text-2xl font-bold text-brand-dark tracking-tight">AgriLink<span
                        class="text-brand-primary">.cm</span></span>
            </div>
        </div>

        <nav class="flex-1 p-6 space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-widest text-neutral-muted mb-4 px-4">
                Menu Acheteur
            </div>
            <Link :href="dashboard()" class="flex items-center space-x-3 px-4 py-3 rounded-xl sidebar-active">
                <i class="fas fa-th-large w-5 text-center"></i>
                <span class="font-semibold">Tableau de bord</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-search w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Explorer le Marché</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-shopping-bag w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Mes Commandes</span>
                <span class="ml-auto bg-brand-primary text-white text-[10px] px-2 py-0.5 rounded-full">2</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-heart w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Mes Favoris</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-envelope w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Messagerie</span>
            </Link>

            <div class="pt-8 text-[10px] font-bold uppercase tracking-widest text-neutral-muted mb-4 px-4">
                Paramètres
            </div>
            <Link :href="buyerProfile()"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-user w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Mon Profil</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-map-marker-alt w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Adresses</span>
            </Link>
        </nav>

        <div class="p-6 border-t border-gray-50">
            <Link :href="logout()"
                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-semibold">
            <i class="fas fa-sign-out-alt w-5 text-center"></i> <span>Déconnexion</span>
            </Link>
        </div>
    </aside>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
import { dashboard, logout } from '@/routes';
import { buyerProfile } from '@/routes';
</script>
