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
                Menu Principal
            </div>
            <Link :href="dashboard()" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-tachometer-alt w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-semibold">Vue d'ensemble</span>
            </Link>
            <Link :href="farmerProductsShow.url()"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-box w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Mes Produits</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-receipt w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Commandes</span>
                <span class="ml-auto bg-accent-cta text-white text-[10px] px-2 py-0.5 rounded-full">4</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-comment-dots w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Messages</span>
                <span class="ml-auto bg-brand-primary text-white text-[10px] px-2 py-0.5 rounded-full">2</span>
            </Link>
            <Link href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-star w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Avis Clients</span>
            </Link>

            <div class="pt-8 text-[10px] font-bold uppercase tracking-widest text-neutral-muted mb-4 px-4">
                Mon Compte
            </div>
            <Link :href="farmerProfile()"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
            <i class="fas fa-user-circle w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
            <span class="font-medium">Mon Profil</span>
            </Link>
            <a href="#"
                class="flex items-center space-x-3 px-4 py-3 rounded-xl text-neutral-body hover:bg-brand-bg hover:text-brand-primary transition-all group">
                <i class="fas fa-cog w-5 text-center text-neutral-muted group-hover:text-brand-primary"></i>
                <span class="font-medium">Paramètres</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-50">
            <Link :href="logout()"
                class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-semibold">
            <i class="fas fa-sign-out-alt w-5 text-center"></i> <span>Déconnexion</span>
            </Link>
        </div>
    </aside>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { dashboard, farmerProductsShow, logout } from '@/routes';
import { farmerProfile } from '@/routes';
</script>
