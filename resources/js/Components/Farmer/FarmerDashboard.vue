<template>
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <FarmerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- HEADER -->
            <FarmerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo" />
            <!-- DASHBOARD CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <!-- TOP STATS -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <ProductStatCard :label="`Produits Actifs`" :value="countProductsAvaliable"
                        :icon="`fas fa-seedling`" :bg_brand="`bg-brand-bg`" :text_brand="`text-brand-primary`" />
                    <ProductStatCard :label="`Commande en cours`" :value="countOrdersPending" :icon="`fas fa-shopping-basket`"
                        :bg_brand="`bg-blue-50`" :text_brand="`text-blue-600`" />
                    <ProductStatCard :label="`C.A du mois`" :value="sumAmountOrders + ` FCFA`" :icon="`fas fa-wallet`"
                        :bg_brand="`bg-accent-light`" :text_brand="`text-accent-cta`" />
                    <ProductStatCard :label="`Note Moyenne`" :value="farmer_average_rating +` / 5`" :icon="`fas fa-star`"
                        :text_brand="`text-accent-star`" :bg_brand="`bg-orange-50`" />
                </div>

                <!-- CHARTS & NOTIFICATIONS -->
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                    <!-- Sales Chart -->
                    <div class="xl:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-lg font-bold text-neutral-title">Évolution des Ventes</h3>
                                <p class="text-sm text-neutral-muted italic">
                                    Nombre de commandes et revenus (7 derniers jours)
                                </p>
                            </div>
                        </div>
                        <div class="h-75 w-full">
                            <ChartRevenus :chart-data="revenueChartData" />
                        </div>
                    </div>

                    <!-- Low Stock & Messages -->
                    <div class="space-y-8">
                        <!-- Low Stock -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-md font-bold text-neutral-title mb-4 flex items-center gap-2">
                                <i class="fas fa-exclamation-triangle text-red-500"></i> Alertes Stock
                                Faible
                            </h3>
                            <div class="space-y-4">
                                <div v-if="productsLow.data.length == 0"
                                    class="bg-green-50 rounded-xl border border-green-100 p-3 flex items-center justify-between text-green-500">
                                    Aucun Produit Faible
                                </div>
                                <div v-else>
                                    <div v-for="product in productsLow.data" :key="product.id"
                                        class="flex items-center justify-between p-3 mb-1.5 bg-red-50 rounded-xl border border-red-100">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-red-500 font-bold shadow-sm text-xs">
                                                {{ product.title.substring(0, 3).toUpperCase() }}.
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-neutral-title">{{ product.title }}</p>
                                                <p class="text-[10px] text-red-600 font-bold">Reste : {{
                                                    product.quantity }}
                                                    {{ product.unit }}</p>
                                            </div>
                                        </div>
                                        <Link class="text-brand-primary hover:underline text-xs font-bold"
                                            :href="farmerProductsEdit(product.id)">
                                            Réappro.
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Messages -->
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-md font-bold text-neutral-title">Derniers Messages</h3>
                                <span
                                    class="bg-brand-primary text-white text-[10px] px-2 py-0.5 rounded-full font-bold">2
                                    Nouveaux</span>
                            </div>
                            <div class="space-y-4">
                                <div
                                    class="flex items-start gap-3 p-2 hover:bg-neutral-bg rounded-xl transition-colors cursor-pointer">
                                    <img src="https://ui-avatars.com/api/?name=Samuel+E&background=random"
                                        class="w-10 h-10 rounded-lg" />
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between">
                                            <p class="text-xs font-bold text-neutral-title truncate">
                                                Samuel Eto'o
                                            </p>
                                            <span class="text-[9px] text-neutral-muted">14:20</span>
                                        </div>
                                        <p class="text-[11px] text-neutral-muted truncate">
                                            Bonjour, est-ce que le poivre de Penja est disponible en gros ?
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex items-start gap-3 p-2 hover:bg-neutral-bg rounded-xl transition-colors cursor-pointer">
                                    <img src="https://ui-avatars.com/api/?name=Marie+C&background=random"
                                        class="w-10 h-10 rounded-lg" />
                                    <div class="flex-1 min-w-0">
                                        <div class="flex justify-between">
                                            <p class="text-xs font-bold text-neutral-title truncate">
                                                Marie Claire
                                            </p>
                                            <span class="text-[9px] text-neutral-muted">Hier</span>
                                        </div>
                                        <p class="text-[11px] text-neutral-muted truncate">
                                            Merci pour la livraison, les tomates sont superbes !
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RECENT ORDERS TABLE -->
                <OrderTable :data="recentsOrders.data"/>
            </div>
        </main>
    </main>
</template>
<script lang="ts" setup>
import { Link } from "@inertiajs/vue3";
import { farmerProductsEdit } from "@/routes";
import type { Auth } from "@/types";
import FarmerNavbar from "./Navbar/FarmerNavbar.vue";
import ChartRevenus from "./Order/ChartRevenus.vue";
import OrderTable from "./Order/OrderTable.vue";
import ProductStatCard from "./Product/ProductStatCard.vue";
import FarmerSidebar from "./Sidebar/FarmerSidebar.vue";

interface Buyer {
    name: string,
    email: string,
    profile_photo?: string
}

interface OrderItems {
    quantity: number,
    subtotal: number
    unit_price: number,
}

interface RevenueChartData {
    labels: string[]
    data: number[]
}

interface RecentsOrders {
    data: {
        id: number,
        status: string,
        buyer: Buyer,
        order_number: string
        order_items: OrderItems[],
        total_amount: number,

    }[]
}

// Types de donnees pour les Statistiques du Dashboard
interface StatisticDashboardFarmer {
    countProductsAvaliable: number;
    sumAmountOrders: string;
    countOrdersPending: number,
    farmer_average_rating:number,
    productsLow: ProductsLow,
    recentsOrders: RecentsOrders
    revenueChartData: RevenueChartData,
}

interface ProductsLow {
    data: {
        id: number,
        title: string,
        quantity: number,
        unit: string,
    }[]
}

// Fusioner les deux types dans la meme interface Props
interface Props extends Auth, StatisticDashboardFarmer { }

defineProps<Props>();
</script>
