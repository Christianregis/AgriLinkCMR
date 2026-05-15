<template>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-neutral-title">
                Commandes Reçues
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-neutral-bg/50 text-neutral-muted text-[10px] uppercase font-bold tracking-widest">
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
                    <tr v-for="order in data" :key="order.id" class="hover:bg-neutral-bg/30 transition-colors">
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
                                'bg-purple-100 text-purple-700': order.status === 'dispute',
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
                            <Link :href="farmerOrderView(order.id)"
                                class="p-2 text-brand-primary hover:bg-brand-bg rounded-lg transition-all">
                                <i class="fas fa-eye"></i>
                            </Link>
                        </td>
                        <!-- CANCEL CONFIRMATION MODAL -->
                        <div v-if="showCancelModal"
                            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-lg">
                                <h3 class="text-xl font-bold text-neutral-title mb-4">Annuler la Commande</h3>
                                <p class="text-neutral-muted mb-6">Êtes-vous sûr de vouloir annuler cette commande ?
                                    Cette action ne
                                    peut pas être annulée.</p>

                                <div class="flex gap-3">
                                    <button @click="showCancelModal = false"
                                        class="flex-1 px-4 py-2 border-2 border-gray-200 text-neutral-title font-bold rounded-xl hover:bg-gray-50 transition-all">
                                        Annuler
                                    </button>
                                    <button @click="updateOrderStatus('cancel', order.id)" :disabled="isUpdating"
                                        class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        Confirmer l'Annulation
                                    </button>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <tr v-if="data.length === 0">
                        <td colspan="6" class="px-8 py-5 text-center text-neutral-muted">
                            Aucune commande récente.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import { farmerOrderChangeStatus, farmerOrderView } from '@/routes'
import type { OrderStatus } from '@/types/Order'
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
const showCancelModal = ref<boolean>(false)
const isUpdating = ref<boolean>(false)

/**
 * Mise a jour du status de la commande
 */
const updateOrderStatus = (newStatus: OrderStatus, order_id: number) => {
    const form = useForm({
        _method: 'put',
        status: newStatus,
        order_id: order_id
    });
    form.post(farmerOrderChangeStatus.url(), {
        onStart: () => {
            isUpdating.value = true;
            showCancelModal.value = false;
        },
        onFinish: () => {
            isUpdating.value = false;
        },
        onError: () => {
            console.error('Erreur lors de la mise à jour du statut');
        }
    });
}
defineProps<RecentsOrders>()
</script>
