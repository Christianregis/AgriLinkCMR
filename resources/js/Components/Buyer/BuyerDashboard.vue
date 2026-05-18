<template>
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <BuyerSidebar ref="buyerSidebarRef" />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- NAVBAR -->
            <BuyerNavbar :name="props.user.data.name" :profile_photo="props.user.data.profile_photo"
                @openbuyer-sidebar="openSidebar" />

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
                        <Link :href="catalog.url()"
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
                        <h3 class="text-2xl font-bold text-neutral-title">{{ props.stats.countOrdersPending }}</h3>
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
                                class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">LIVRÉES</span>
                        </div>
                        <h3 class="text-2xl font-bold text-neutral-title">{{ props.stats.countOrdersSuccess }}</h3>
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
                            {{ props.stats.totalExpenses }} <small class="text-xs">FCFA</small>
                        </h3>
                        <p class="text-xs text-neutral-muted font-medium uppercase tracking-wider mt-1">
                            Montant total dépensé
                        </p>
                    </div>
                </div>

                <RecentsOrder :recent-orders="props.recentOrders" />
            </div>
        </main>
    </main>
</template>
<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { catalog } from "@/routes";
import type { Auth } from "@/types";
import BuyerNavbar from "./Navbar/BuyerNavbar.vue";
import RecentsOrder from "./Order/RecentsOrder.vue";
import BuyerSidebar from "./Sidebar/BuyerSidebar.vue";

interface Farmer {
    id: number,
    name: string,
}

interface StatisticBuyerDashboard {
    stats: {
        countOrdersPending: number | string,
        countOrdersSuccess: number | string,
        totalExpenses: number | string,
    },
    recentOrders: {
        data: {
            id: number,
            order_number: number,
            buyer_id: number,
            farmer_id: number,
            status: string,
            payment_method: string,
            delivery_address?: string,
            total_amount: number,
            created_at: Date,
            updated_at: Date,
            farmer: Farmer
        }[]
    }
}

interface Props extends Auth, StatisticBuyerDashboard { }

const props = defineProps<Props>();
const buyerSidebarRef = ref<InstanceType<typeof BuyerSidebar> | null>(null)

const openSidebar = () => {

    buyerSidebarRef.value?.toggleSidebar()
}

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
