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
                                        class="flex items-center justify-between p-3 bg-red-50 rounded-xl border border-red-100">
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
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-neutral-title">
                            Dernières Commandes Reçues
                        </h3>
                        <button
                            class="px-4 py-2 bg-brand-bg text-brand-primary rounded-lg text-xs font-bold hover:bg-brand-primary hover:text-white transition-all">
                            Voir tout l'historique
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead
                                class="bg-neutral-bg/50 text-neutral-muted text-[10px] uppercase font-bold tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">ID Commande</th>
                                    <th class="px-6 py-4">Client</th>
                                    <th class="px-6 py-4">Nbres Produits</th>
                                    <th class="px-6 py-4">Montant</th>
                                    <th class="px-6 py-4">Statut</th>
                                    <th class="px-8 py-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                <tr v-for="order in recentsOrders.data" :key="order.id"
                                    class="hover:bg-neutral-bg/30 transition-colors">
                                    <td class="px-8 py-5 font-bold text-neutral-title">#{{ order.order_number }}</td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-2">
                                            <img :src="order.buyer.profile_photo || `https://ui-avatars.com/api/?name=${order.buyer.name}&background=random`"
                                                class="w-7 h-7 rounded-full" />
                                            <span class="text-sm font-medium text-neutral-body">{{ order.buyer.name
                                                }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-neutral-muted">
                                        {{ order.order_items.length }}
                                    </td>
                                    <td class="px-6 py-5 font-bold text-brand-dark text-sm">{{
                                        order.total_amount.toLocaleString() }} FCFA</td>
                                    <td class="px-6 py-5">
                                        <span :class="{
                                            'px-3 py-1 text-[10px] font-bold rounded-full uppercase': true,
                                            'bg-blue-100 text-blue-700': order.status === 'pending',
                                            'bg-yellow-100 text-yellow-700': order.status === 'preparation',
                                            'bg-green-100 text-green-700': order.status === 'success',
                                            'bg-green-200 text-green-800': order.status === 'ready',
                                            'bg-purple-100 text-purple-700' : order.status === 'dispute',
                                            'bg-red-100 text-red-700': order.status === 'cancel',
                                        }">
                                            {{
                                                order.status === 'pending' ? 'En attente' :
                                                    order.status === 'preparation' ? 'En préparation' :
                                                        order.status === 'ready' ? 'Prêt' :
                                                            order.status === 'success' ? 'Livree' :

                                                                order.status === 'cancel' ? 'Annulée' :
                                                                    order.status === 'dispute' ? 'Litige' :
                                                                        'Inconnu'
                                            }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5 text-right">
                                        <Link href="#"
                                            class="p-2 text-brand-primary hover:bg-brand-bg rounded-lg transition-all">
                                            <i class="fas fa-eye"></i>
                                        </Link>
                                        <button v-if="order.status === 'pending'" @click="'#'"
                                            class="p-2 text-red-500 hover:bg-red-100 rounded-lg transition-all ml-2">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="recentsOrders.data.length === 0">
                                    <td colspan="6" class="px-8 py-5 text-center text-neutral-muted">
                                        Aucune commande récente.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
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
