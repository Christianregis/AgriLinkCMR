<template>
    <!-- ORDER HISTORY -->
    <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-neutral-title">
                Historique des Commandes
            </h3>
            <div class="flex gap-2">
                <button class="px-3 py-1.5 text-xs font-bold text-brand-primary bg-brand-bg rounded-lg">
                    Récent
                </button>
            </div>
        </div>
        <div v-if="recentOrders.data.length >= 1" class="divide-y divide-gray-50">
            <!-- Order Item  -->
            <div v-for="order in recentOrders.data" :key="order.id"
                class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-neutral-bg/30 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl overflow-hidden border border-gray-200">
                        <img :src="`https://ui-avatars.com/api/?name=` + order.order_number + `&background=2D6A4F&color=fff`"
                            class="w-full h-full object-cover" />
                    </div>
                    <div>
                        <h4 class="font-bold text-neutral-title">Commande {{ order.order_number }}</h4>
                        <p class="text-xs text-neutral-muted mt-1">
                            Vendeur :
                            <span class="text-brand-primary font-semibold">{{ order.farmer.name
                            }}</span>
                        </p>
                        <p class="text-[10px] text-neutral-muted mt-0.5">
                            {{ order.created_at }} • {{ order.total_amount }} FCFA
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-between md:justify-end gap-6">
                    <span :class="[
                        'px-3 py-1 text-[10px] font-bold rounded-full uppercase',
                        order.status === 'pending' ? 'bg-blue-100 text-blue-700' :
                            order.status === 'preparation' ? 'bg-yellow-100 text-yellow-700' :
                                order.status === 'ready' ? 'bg-green-100 text-green-700' :
                                    order.status === 'success' ? 'bg-green-100 text-green-700' :
                                        order.status === 'cancel' ? 'bg-red-100 text-red-700' :
                                            order.status === 'dispute' ? 'bg-purple-100 text-purple-700' :
                                                'bg-gray-100 text-gray-700'
                    ]">
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
                    <Link :href="buyerOrderTracking(order.id)"
                        class="px-4 py-2 border border-gray-200 rounded-xl text-xs font-bold text-neutral-title hover:bg-gray-50 transition-all">
                        Détails
                    </Link>
                </div>
            </div>
            <div class="p-4 bg-neutral-bg/50 text-center">
                <Link class="text-xs font-bold text-brand-primary hover:underline" :href="buyerOrderShow()">
                    Afficher les autres commandes
                </Link>
            </div>
        </div>
        <div v-else class="p-10 text-center">
            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
            <p class="text-sm text-gray-500 font-semibold">
                Aucune commande pour le moment
            </p>

            <Link :href="catalog.url()"
                class="inline-block mt-4 px-5 py-2 bg-brand-primary text-white text-xs font-bold rounded-xl hover:bg-brand-hover transition">
                Voir les produits
            </Link>
        </div>
    </div>

    <!-- SIDEBAR: FAVORITES & MESSAGES -->
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { buyerOrderShow, buyerOrderTracking, catalog } from '@/routes';
interface Farmer {
    id: number,
    name: string,
}
interface Order {
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
    },

}

defineProps<Order>()
</script>
