<template>
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <BuyerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- NAVBAR -->
            <BuyerNavbar :name="props.user.data.name" />

            <!-- DASHBOARD CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <!-- WELCOME CARD -->
                <div class="bg-brand-dark rounded-3xl p-8 text-white relative overflow-hidden shadow-xl">
                    <div class="relative z-10 max-w-lg">
                        <h2 class="text-3xl font-bold mb-4">Bienvenue, {{ props.user.data.name }} ! <i
                                class="text-5xl text-green-600 fas fa-carrot"></i></h2>
                        <p class="text-brand-light/70 mb-6 leading-relaxed">
                            Vos produits frais préférés de Penja et Foumbot vous attendent. Profitez de
                            -10% sur votre prochaine commande avec le code
                            <span class="font-bold text-white">AGRI2026</span>.
                        </p>
                        <Link href="catalogue.html"
                            class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-hover px-6 py-3 rounded-xl font-bold transition-all">
                            Faire mes courses <i class="fas fa-arrow-right text-sm"></i>
                    </Link>
                    </div>
                    <i class="fas fa-carrot absolute -bottom-10 -right-10 text-white/10 text-[200px] rotate-12"></i>
                </div>

                <!-- STATS GRID -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-xl">
                                <i class="fas fa-truck-loading"></i>
                            </div>
                            <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">EN
                                COURS</span>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-title">02</h3>
                        <p class="text-xs text-neutral-muted font-medium uppercase tracking-wider mt-1">
                            Commandes en livraison
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center text-xl">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <span
                                class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">COMPLÉTÉES</span>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-title">15</h3>
                        <p class="text-xs text-neutral-muted font-medium uppercase tracking-wider mt-1">
                            Commandes livrées
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <div
                                class="w-12 h-12 bg-accent-light text-accent-cta rounded-xl flex items-center justify-center text-xl">
                                <i class="fas fa-coins"></i>
                            </div>
                            <span
                                class="text-[10px] font-bold text-accent-cta bg-accent-light px-2 py-1 rounded-full">TOTAL</span>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-title">
                            85,400 <small class="text-xs">FCFA</small>
                        </h3>
                        <p class="text-xs text-neutral-muted font-medium uppercase tracking-wider mt-1">
                            Montant total dépensé
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <!-- ORDER HISTORY -->
                    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-neutral-title">
                                Historique des Commandes
                            </h3>
                            <div class="flex gap-2">
                                <button
                                    class="px-3 py-1.5 text-xs font-bold bg-neutral-bg text-neutral-muted rounded-lg hover:text-brand-primary">
                                    Tout
                                </button>
                                <button class="px-3 py-1.5 text-xs font-bold text-brand-primary bg-brand-bg rounded-lg">
                                    Récent
                                </button>
                            </div>
                        </div>
                        <div class="divide-y divide-gray-50">
                            <!-- Order Item 1 -->
                            <div
                                class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-neutral-bg/30 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200">
                                        <img src="https://images.unsplash.com/photo-1550989460-0adf9ea622e2?auto=format&fit=crop&q=80&w=100"
                                            class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-title">Commande #AGL-2026-00452</h4>
                                        <p class="text-xs text-neutral-muted mt-1">
                                            Vendeur :
                                            <span class="text-brand-primary font-semibold">Ferme de Penja</span>
                                        </p>
                                        <p class="text-[10px] text-neutral-muted mt-0.5">
                                            18 Avril 2026 • 14,500 FCFA
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between md:justify-end gap-6">
                                    <span
                                        class="px-3 py-1 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full uppercase">En
                                        cours</span>
                                    <button
                                        class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-neutral-title hover:bg-gray-50 transition-all">
                                        Détails
                                    </button>
                                </div>
                            </div>
                            <!-- Order Item 2 -->
                            <div
                                class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-neutral-bg/30 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-16 h-16 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200">
                                        <img src="https://images.unsplash.com/photo-1587593810167-a84920ea0781?auto=format&fit=crop&q=80&w=100"
                                            class="w-full h-full object-cover" />
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-neutral-title">Commande #AGL-2026-00435</h4>
                                        <p class="text-xs text-neutral-muted mt-1">
                                            Vendeur :
                                            <span class="text-brand-primary font-semibold">GIC ProAgro</span>
                                        </p>
                                        <p class="text-[10px] text-neutral-muted mt-0.5">
                                            12 Avril 2026 • 8,200 FCFA
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between md:justify-end gap-6">
                                    <span
                                        class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase">Livrée</span>
                                    <button
                                        class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-neutral-title hover:bg-gray-50 transition-all">
                                        Re-commander
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 bg-neutral-bg/50 text-center">
                            <button class="text-xs font-bold text-brand-primary hover:underline">
                                Afficher les 13 autres commandes
                            </button>
                        </div>
                    </div>

                    <!-- SIDEBAR: FAVORITES & MESSAGES -->
                    <div class="space-y-8">
                        <!-- Favorite Farmers -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-md font-bold text-neutral-title mb-6 flex items-center gap-2">
                                <i class="fas fa-heart text-red-500"></i> Agriculteurs Favoris
                            </h3>
                            <div class="space-y-5">
                                <div class="flex items-center justify-between group cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=Mama+Claire&background=random"
                                            class="w-11 h-11 rounded-xl shadow-sm" />
                                        <div>
                                            <p
                                                class="text-sm font-bold text-neutral-title group-hover:text-brand-primary transition-colors">
                                                Mama Claire
                                            </p>
                                            <p class="text-[10px] text-neutral-muted">
                                                Mbouda • 4.9 <i class="fas fa-star text-accent-star"></i>
                                            </p>
                                        </div>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-gray-300 group-hover:text-brand-primary transition-all text-xs"></i>
                                </div>
                                <div class="flex items-center justify-between group cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name=Ousmanou&background=random"
                                            class="w-11 h-11 rounded-xl shadow-sm" />
                                        <div>
                                            <p
                                                class="text-sm font-bold text-neutral-title group-hover:text-brand-primary transition-colors">
                                                M. Ousmanou
                                            </p>
                                            <p class="text-[10px] text-neutral-muted">
                                                Penja • 4.7 <i class="fas fa-star text-accent-star"></i>
                                            </p>
                                        </div>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-gray-300 group-hover:text-brand-primary transition-all text-xs"></i>
                                </div>
                            </div>
                            <button
                                class="w-full mt-6 py-3 border-2 border-brand-bg text-brand-primary font-bold rounded-xl text-xs hover:bg-brand-primary hover:text-white transition-all">
                                Voir tous mes favoris
                            </button>
                        </div>

                        <!-- Recently Viewed -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-md font-bold text-neutral-title mb-4">
                                Récemment consultés
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="relative group cursor-pointer">
                                    <div class="aspect-square rounded-xl overflow-hidden border border-gray-100">
                                        <img src="https://images.unsplash.com/photo-1590779033100-9f60705a2f3b?auto=format&fit=crop&q=80&w=150"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform" />
                                    </div>
                                    <p class="text-[10px] font-bold text-neutral-title mt-2 truncate">
                                        Tomates Bio
                                    </p>
                                </div>
                                <div class="relative group cursor-pointer">
                                    <div class="aspect-square rounded-xl overflow-hidden border border-gray-100">
                                        <img src="https://images.unsplash.com/photo-1594282486552-05b4d80fbb9f?auto=format&fit=crop&q=80&w=150"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform" />
                                    </div>
                                    <p class="text-[10px] font-bold text-neutral-title mt-2 truncate">
                                        Manioc Frais
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </main>
</template>
<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
import type { Auth } from "@/types";
import BuyerNavbar from "./Navbar/BuyerNavbar.vue";
import BuyerSidebar from "./Sidebar/BuyerSidebar.vue";
const props = defineProps<Auth>();


</script>
<style scoped>
body {
    font-family: "Inter", sans-serif;
}

.sidebar-active {
    background-color: #2d6a4f;
    color: white;
    box-shadow: 0 4px 12px rgba(45, 106, 79, 0.2);
}

.glass-header {
    backdrop-filter: blur(8px);
    background-color: rgba(255, 255, 255, 0.8);
}
</style>
