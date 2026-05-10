<template>
    <FlashMessage/>
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <BuyerSidebar ref="buyerSidebarRef"/>

        <!-- MAIN CONTENT -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <BuyerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo" @openbuyer-sidebar="openSidebar"/>

            <!-- ORDER TRACKING CONTENT -->
            <div class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 space-y-6 sm:space-y-8">
                <!-- PAGE HEADER -->
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-neutral-title">Suivi de Commande #{{
                            order.data.order_number }}</h1>
                        <p class="text-sm text-neutral-muted mt-1">
                            Détails et progression de votre commande.
                        </p>
                    </div>
                    <Link :href="buyerOrderShow()"
                        class="inline-flex items-center px-4 py-2 bg-brand-primary text-white font-bold rounded-xl hover:bg-brand-hover transition-all">
                        <i class="fas fa-arrow-left mr-2"></i> Mes Commandes
                    </Link>
                </div>

                <!-- ORDER STATUS TIMELINE -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 lg:p-8">
                    <h3 class="text-lg font-bold text-neutral-title mb-6">Progression de la Commande</h3>
                    <div class="relative flex justify-between items-center py-4">
                        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -translate-y-1/2 z-0"></div>

                        <div v-for="(step) in statusSteps" :key="step.status"
                            class="flex flex-col items-center flex-1 z-10">
                            <div :class="[
                                'w-12 h-12 sm:w-16 sm:h-16 rounded-full flex items-center justify-center text-xl sm:text-2xl font-bold transition-all duration-300 mb-3 sm:mb-4',
                                isStepCompleted(step.status)
                                    ? step.completedClasses
                                    : isStepCurrent(step.status)
                                        ? step.currentClasses
                                        : 'bg-gray-100 text-gray-400'
                            ]">
                                <i :class="step.icon"></i>
                            </div>
                            <p :class="[
                                'text-xs sm:text-sm font-bold text-center',
                                isStepCompleted(step.status) || isStepCurrent(step.status)
                                    ? 'text-neutral-title'
                                    : 'text-gray-400'
                            ]">
                                {{ step.label }}
                            </p>
                            <p v-if="getStepDate(step.status)" class="text-xs text-neutral-muted text-center mt-1">
                                {{ getStepDate(step.status) }}
                            </p>
                        </div>
                    </div>
                    <!-- Cancel Status (if applicable) -->
                    <div v-if="order.data.status === 'cancel'"
                        class="mt-8 p-4 bg-red-50 border-2 border-red-200 rounded-xl flex items-center gap-3">
                        <i class="fas fa-ban text-red-600 text-xl"></i>
                        <div>
                            <p class="font-bold text-red-600">Commande Annulée</p>
                            <p class="text-sm text-red-500">Cette commande a été annulée et aucune action supplémentaire
                                n'est possible.</p>
                        </div>
                    </div>

                    <!-- Conditional Actions -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                        <!-- Annuler la commande (si PENDING) -->
                        <button v-if="order.data.status === 'pending'" @click="showCancelModal = true"
                            class="px-6 py-3 border-2 border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i> Annuler la Commande
                        </button>

                        <!-- Effectuer le paiement (si PENDING et momo) -->
                        <button v-if="order.data.status === 'pending' && order.data.payment_method === 'momo'"
                            @click="makePayment(order.data.id)"
                            class="px-6 py-3 bg-brand-primary hover:bg-brand-hover text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-money-bill-wave"></i> Effectuer le Paiement
                        </button>

                        <!-- Laisser un avis (si DELIVERED) -->
                        <button v-if="order.data.status === 'success'" @click="leaveReview(order.data.id)"
                            class="px-6 py-3 bg-accent-cta hover:bg-accent-cta/90 text-white font-bold rounded-xl transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-star"></i> Laisser un Avis
                        </button>

                        <!-- Continuer les achats -->
                        <Link :href="catalog()"
                            class="px-6 py-3 border-2 border-gray-200 text-neutral-title font-bold rounded-xl hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-shopping-cart"></i> Continuer les achats
                        </Link>
                    </div>
                </div>

                <!-- ORDER DETAILS & ITEMS -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                    <!-- LEFT COLUMN: ORDER INFORMATION -->
                    <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Informations de la Commande</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-1">Numéro de Commande
                                    </p>
                                    <p class="text-base font-bold text-neutral-title">#{{ order.data.order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-1">Date de Commande</p>
                                    <p class="text-base font-bold text-neutral-title">{{
                                        formatDate(order.data.created_at) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-1">Méthode de Paiement
                                    </p>
                                    <p class="text-base font-bold text-neutral-title">{{
                                        formatPaymentMethod(order.data.payment_method) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-1">Adresse de Livraison
                                    </p>
                                    <p class="text-base font-bold text-neutral-title">{{ order.data.delivery_address ||
                                        'Récupération en personne' }}</p>
                                </div>
                                <div v-if="order.data.notes" class="md:col-span-2">
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-1">Notes</p>
                                    <p class="text-sm text-neutral-title">{{ order.data.notes }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- ORDERED PRODUCTS SECTION -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Produits Commandés</h3>

                            <div class="space-y-4">
                                <div v-for="item in order.data.order_items" :key="item.id"
                                    class="flex items-center gap-4 p-3 sm:p-4 bg-neutral-bg/50 rounded-xl border border-gray-100">
                                    <div
                                        class="shrink-0 w-16 h-16 sm:w-20 sm:h-20 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                                        <img v-if="getPrimaryImage(item.product)"
                                            :src="getPrimaryImage(item.product) ?? '#'" :alt="item.product.title"
                                            class="w-full h-full object-cover" />
                                        <div v-else
                                            class="w-full h-full flex items-center justify-center bg-linear-to-br from-gray-100 to-gray-200">
                                            <i class="fas fa-image text-gray-400 text-xl"></i>
                                        </div>
                                    </div>
                                    <div class="grow">
                                        <Link :href="productInfo(item.product.id)"
                                            class="text-base sm:text-lg font-bold text-neutral-title hover:text-brand-primary transition-colors">
                                            {{ item.product.title }}
                                        </Link>
                                        <p class="text-sm text-neutral-muted">{{ item.quantity }} {{ item.product.unit
                                        }} x {{ item.unit_price.toLocaleString() }} FCFA</p>
                                    </div>
                                    <div class="shrink-0 text-right">
                                        <p class="text-base sm:text-lg font-bold text-brand-primary">{{
                                            item.subtotal.toLocaleString() }} FCFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: FARMER INFO & TOTALS -->
                    <div class="lg:col-span-1 space-y-6 sm:space-y-8">
                        <!-- FARMER INFORMATION -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6 text-center">
                            <h3 class="text-lg font-bold text-neutral-title mb-4">Vendeur</h3>
                            <img :src="order.data.farmer.profile_photo || `https://ui-avatars.com/api/?name=${order.data.farmer.name}&background=random`"
                                class="w-20 h-20 rounded-full mx-auto mb-3 border-2 border-brand-primary/50" />
                            <p class="text-lg font-bold text-neutral-title">{{ order.data.farmer.name }}</p>
                            <Link :href="showFarmerInfo(order.data.farmer.id)"
                                class="text-sm text-brand-primary hover:underline mt-1 inline-block">
                                Voir le profil
                            </Link>
                        </div>

                        <!-- ORDER TOTALS -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 sm:p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Récapitulatif</h3>
                            <div class="space-y-3">
                                <div class="flex justify-between text-neutral-body">
                                    <span>Sous-total</span>
                                    <span>{{ (order.data.total_amount - (order.data.delivery_address ? 2000 :
                                        0)).toLocaleString() }} FCFA</span>
                                </div>
                                <div v-if="order.data.delivery_address" class="flex justify-between text-neutral-body">
                                    <span>Frais de livraison</span>
                                    <span>2,000 FCFA</span>
                                </div>
                                <div class="flex justify-between font-bold text-lg border-t border-gray-100 pt-3 mt-3">
                                    <span>Total</span>
                                    <span class="text-brand-primary">{{ order.data.total_amount.toLocaleString() }}
                                        FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- CANCEL CONFIRMATION MODAL -->
        <div v-if="showCancelModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-lg">
                <h3 class="text-xl font-bold text-neutral-title mb-4">Annuler la Commande</h3>
                <p class="text-neutral-muted mb-6">Êtes-vous sûr de vouloir annuler cette commande ? Cette action ne
                    peut pas être annulée.</p>

                <div class="flex gap-3">
                    <button @click="showCancelModal = false"
                        class="flex-1 px-4 py-2 border-2 border-gray-200 text-neutral-title font-bold rounded-xl hover:bg-gray-50 transition-all">
                        Annuler
                    </button>
                    <button @click="updateOrderStatus()" :disabled="isUpdating"
                        class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirmer l'Annulation
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';

import { computed, ref } from 'vue';
import BuyerNavbar from '@/Components/Buyer/Navbar/BuyerNavbar.vue';
import BuyerSidebar from '@/Components/Buyer/Sidebar/BuyerSidebar.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { buyerOrderShow, catalog, buyerOrderCancel, productInfo, showFarmerInfo } from '@/routes';
import type { OrderStatus } from '@/types/Order';
import { formatDate } from '@/utils/formatDate';

// --- Interfaces TypeScript ---
interface UserProfile {
    profile_photo?: string;
}

interface User {
    id: number;
    name: string;
    profile_photo?: string;
    farmer_profile?: UserProfile;
}

interface ProductImage {
    id: number;
    path: string;
}

interface Product {
    id: number;
    title: string;
    product_images?: ProductImage[];
    unit: string;
}

interface OrderItem {
    id: number;
    product_id: number;
    unit_price: number;
    quantity: number;
    subtotal: number;
    product: Product;
}

interface OrderStatusLog {
    id: number;
    old_status: OrderStatus;
    new_status: OrderStatus;
    created_at: string;
}

interface StatusStep {
    status: OrderStatus
    label: string
    icon: string
    completedClasses: string
    currentClasses: string
}

interface Order {
    id: number;
    order_number: string;
    buyer_id: number;
    farmer_id: number;
    status: OrderStatus;
    payment_method: 'momo' | 'cash' | 'stripe';
    delivery_address?: string;
    total_amount: number;
    notes?: string;
    created_at: string;
    updated_at: string;
    farmer: User; // Assuming farmer details are loaded
    order_items: OrderItem[];
    order_status_logs: OrderStatusLog[];
}

interface BuyerOrderTrackingProps {
    order: { data: Order };
}

const props = defineProps<BuyerOrderTrackingProps>();

// --- Computed properties for status tracking ---
const statusSteps: StatusStep[] = [
    {
        status: 'pending',
        label: 'En Attente',
        icon: 'fas fa-clock',
        completedClasses: 'bg-blue-100 text-blue-600 border-4 border-blue-300',
        currentClasses: 'bg-blue-600 text-white border-4 border-blue-400 shadow-lg shadow-blue-500/50'
    },
    {
        status: 'preparation',
        label: 'En Préparation',
        icon: 'fas fa-box',
        completedClasses: 'bg-yellow-100 text-yellow-600 border-4 border-yellow-300',
        currentClasses: 'bg-yellow-600 text-white border-4 border-yellow-400 shadow-lg shadow-yellow-500/50'
    },
    {
        status: 'ready',
        label: 'Prêt',
        icon: 'fas fa-check-circle',
        completedClasses: 'bg-purple-100 text-purple-600 border-4 border-purple-300',
        currentClasses: 'bg-purple-600 text-white border-4 border-purple-400 shadow-lg shadow-purple-500/50'
    },
    {
        status: 'success',
        label: 'Livrée',
        icon: 'fas fa-truck',
        completedClasses: 'bg-green-100 text-green-600 border-4 border-green-300',
        currentClasses: 'bg-brand-primary text-white border-4 border-brand-primary shadow-lg shadow-brand-primary/50'
    }
]

const currentStatusIndex = computed(() => {
    return statusSteps.findIndex(step => step.status === props.order.data.status);
});

const isStepCompleted = (stepStatus: Order['status']) => {
    const stepIndex = statusSteps.findIndex(step => step.status === stepStatus);

    return stepIndex !== -1 && stepIndex < currentStatusIndex.value;
};

const isStepCurrent = (stepStatus: Order['status']) => {
    return props.order.data.status === stepStatus;
};

const getStepDate = (stepStatus: Order['status']) => {
    const log = props.order.data.order_status_logs.find(log => log.new_status === stepStatus);

    return log ? formatDate(log.created_at) : '';
};

const formatPaymentMethod = (method: Order['payment_method']) => {
    switch (method) {
        case 'momo': return 'Mobile Money';
        case 'cash': return 'Paiement en Espèces';
        case 'stripe': return 'Stripe';
        default: return 'Inconnu';
    }
};

const getPrimaryImage = (product: Product) => {
    return product.product_images?.[0]?.path;
};


const showCancelModal = ref<boolean>(false)
const isUpdating = ref<boolean>(false)

const updateOrderStatus = () => {
    const form = useForm({
        _method: 'put',
    });
    form.post(buyerOrderCancel.url(props.order.data.id), {
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

const makePayment = (orderId: number) => {
    // Implement payment logic here. This might redirect to a payment gateway
    // or open a payment modal. For now, a placeholder.
    alert(`Procéder au paiement pour la commande ${orderId} via Mobile Money.`);
    // Example: form.post(route('buyer.orders.pay', orderId));
};

const leaveReview = (orderId: number) => {
    // Implement review modal or redirect to review page
    alert(`Laisser un avis pour la commande ${orderId}.`);
    // Example: Inertia.visit(route('buyer.orders.review', orderId));
};

const buyerSidebarRef = ref<InstanceType<typeof BuyerSidebar> | null>(null)

const openSidebar = () => {

    buyerSidebarRef.value?.toggleSidebar()
}

const page = usePage();
const user = page.props.auth.user;
</script>

<style scoped>
/* Custom styles if needed, but Tailwind handles most */
.hero-gradient {
    background: linear-gradient(135deg, #1A3D3B 0%, #2D6A4F 100%);
}
</style>
