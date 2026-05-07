<template>
    <FlashMessage />
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <FarmerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- NAVBAR -->
            <FarmerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo" />

            <!-- DASHBOARD CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <!-- PAGE HEADER WITH BACK BUTTON -->
                <div class="flex items-center gap-4">
                    <Link href="#" @click.prevent="goBack" class="p-2 hover:bg-white rounded-xl transition-all">
                        <i class="fas fa-arrow-left text-neutral-title text-xl"></i>
                    </Link>
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-title">Commande #{{ order.data.order_number }}</h1>
                        <p class="text-sm text-neutral-muted mt-1">
                            Détails complets et suivi de la commande
                        </p>
                    </div>
                </div>

                <!-- ORDER STATUS STEPPER -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-lg font-bold text-neutral-title mb-8">Suivi de la Commande</h3>

                    <!-- Status Timeline -->
                    <div class="flex items-center justify-between relative">
                        <!-- Background line -->
                        <div class="absolute top-1/2 left-0 right-0 h-1 bg-gray-200 -translate-y-1/2 -z-10"></div>

                        <!-- Status Steps -->
                        <div v-for="(step) in statusSteps" :key="step.status" class="flex flex-col items-center flex-1">
                            <!-- Circle with icon -->
                            <div :class="[
                                'w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold transition-all relative z-10 mb-4',
                                isStepCompleted(step.status)
                                    ? step.completedClasses
                                    : isStepCurrent(step.status)
                                        ? step.currentClasses
                                        : 'bg-gray-100 text-gray-400 border-4 border-gray-200'
                            ]">
                                <i :class="step.icon"></i>
                            </div>

                            <!-- Step label -->
                            <p :class="[
                                'text-sm font-bold text-center',
                                isStepCompleted(step.status) || isStepCurrent(step.status)
                                    ? 'text-neutral-title'
                                    : 'text-gray-400'
                            ]">
                                {{ step.label }}
                            </p>

                            <!-- Step date -->
                            <p v-if="isStepCompleted(step.status)" class="text-xs text-neutral-muted text-center mt-1">
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

                    <!-- Action Buttons -->
                    <div v-if="order.data.status !== 'cancel' && order.data.status !== 'dispute' && order.data.status !== 'success'"
                        class="mt-8 flex gap-3 flex-wrap">
                        <!-- Accept Order (Pending -> Preparation) -->
                        <button v-if="order.data.status === 'pending'" @click="updateOrderStatus('preparation')"
                            :disabled="isUpdating"
                            class="px-6 py-3 bg-brand-primary hover:bg-brand-hover text-white font-bold rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <i class="fas fa-check"></i>
                            Accepter la Commande
                        </button>

                        <!-- Mark as Ready (Preparation -> Ready) -->
                        <button v-if="order.data.status === 'preparation'" @click="updateOrderStatus('ready')"
                            :disabled="isUpdating"
                            class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <i class="fas fa-box"></i>
                            Marquer comme Prête
                        </button>

                        <!-- Mark as Delivered (Ready -> Success) -->
                        <button v-if="order.data.status === 'ready'" @click="updateOrderStatus('success')"
                            :disabled="isUpdating"
                            class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                            <i class="fas fa-truck"></i>
                            Marquer comme Livrée
                        </button>

                        <!-- Cancel Order -->
                        <button @click="showCancelModal = true"
                            class="px-6 py-3 border-2 border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-50 transition-all flex items-center gap-2">
                            <i class="fas fa-times"></i>
                            Annuler la Commande
                        </button>
                    </div>
                </div>

                <!-- MAIN CONTENT GRID -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- LEFT COLUMN: ORDER DETAILS & ITEMS -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- ORDER INFORMATION -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Informations de la Commande</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Order Number -->
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-2">Numéro de Commande
                                    </p>
                                    <p class="text-lg font-bold text-neutral-title">#{{ order.data.order_number }}</p>
                                </div>

                                <!-- Order Date -->
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-2">Date de Commande</p>
                                    <p class="text-lg font-bold text-neutral-title">{{ formatDate(order.data.created_at)
                                        }}</p>
                                </div>

                                <!-- Payment Method -->
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-2">Méthode de Paiement
                                    </p>
                                    <p class="text-lg font-bold text-neutral-title">{{ order.data.payment_method ===
                                        'momo' ? 'Mobile Money' : order.data.payment_method === 'stripe' ? 'Stripe' :
                                        order.data.payment_method === 'cash' ? 'Paiement en Espèces' : 'Inconnu' }}</p>
                                </div>

                                <!-- Delivery Address -->
                                <div>
                                    <p class="text-xs text-neutral-muted uppercase font-bold mb-2">Adresse de Livraison
                                    </p>
                                    <p class="text-lg font-bold text-neutral-title">{{ order.data.delivery_address }}
                                    </p>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div v-if="order.data.notes" class="mt-6 pt-6 border-t border-gray-100">
                                <p class="text-xs text-neutral-muted uppercase font-bold mb-2">Notes</p>
                                <p class="text-sm text-neutral-title">{{ order.data.notes }}</p>
                            </div>
                        </div>

                        <!-- ORDER ITEMS SECTION -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Produits Commandés</h3>

                            <div class="space-y-4">
                                <div v-for="item in order.data.order_items" :key="item.id"
                                    class="group flex items-center gap-4 p-5 bg-linear-to-r from-neutral-bg to-white hover:from-brand-bg/30 hover:to-white rounded-xl border border-gray-100 hover:border-brand-primary/30 transition-all duration-300 cursor-pointer">

                                    <!-- PRODUCT IMAGE -->
                                    <div class="relative shrink-0">
                                        <div
                                            class="w-20 h-20 rounded-lg overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                                            <img v-if="getPrimaryImage(item.product)"
                                                :src="getPrimaryImage(item.product) ?? '#'" :alt="item.product.title"
                                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300" />
                                            <div v-else
                                                class="w-full h-full flex items-center justify-center bg-linear-to-br from-gray-100 to-gray-200">
                                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                                            </div>
                                        </div>
                                        <!-- Image count badge -->
                                        <div v-if="item.product.product_images && item.product.product_images.length > 1"
                                            class="absolute -bottom-2 -right-2 bg-brand-primary text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">
                                            +{{ item.product.product_images.length - 1 }}
                                        </div>
                                    </div>

                                    <!-- PRODUCT DETAILS -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-4">
                                            <div class="flex-1">
                                                <p
                                                    class="font-bold text-neutral-title text-base group-hover:text-brand-primary transition-colors truncate">
                                                    {{ item.product.title }}
                                                </p>
                                                <div class="flex items-center gap-2 mt-2">
                                                    <span
                                                        class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-50 text-blue-600 text-xs font-bold rounded-lg border border-blue-100">
                                                        <i class="fas fa-box-open text-xs"></i>
                                                        Quantité: {{ item.quantity }}
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- PRICING SECTION -->
                                            <div class="text-right shrink-0">
                                                <div class="flex flex-col items-end gap-1">
                                                    <p class="text-lg font-bold text-brand-primary">
                                                        {{ formatAmount(item.subtotal) }} FCFA
                                                    </p>
                                                </div>
                                                <p class="text-xs text-neutral-muted mt-2">
                                                    {{ formatAmount(item.unit_price) }} FCFA/ {{ item.product.unit }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ACTION ICON -->
                                    <div class="shrink-0 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <Link :href="farmerProductsEdit(item.product.id)"
                                            class="w-10 h-10 rounded-lg bg-brand-primary/10 flex items-center justify-center text-brand-primary">
                                            <i class="fas fa-arrow-right text-sm"></i>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN: BUYER & SUMMARY -->
                    <div class="space-y-8">
                        <!-- BUYER INFORMATION -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Informations de l'Acheteur</h3>

                            <div class="flex items-center gap-4 mb-6">
                                <img :src="order.data.buyer.profile_photo || `https://ui-avatars.com/api/?name=${order.data.buyer.name}&background=2D6A4F&color=fff`"
                                    :alt="order.data.buyer.name" class="w-16 h-16 rounded-xl object-cover" />
                                <div>
                                    <p class="font-bold text-neutral-title">{{ order.data.buyer.name }}</p>
                                    <p class="text-sm text-neutral-muted">{{ order.data.buyer.email }}</p>
                                </div>
                            </div>

                            <button
                                class="w-full px-4 py-2 border-2 border-brand-primary text-brand-primary font-bold rounded-xl hover:bg-brand-bg transition-all">
                                <i class="fas fa-envelope mr-2"></i>
                                Contacter l'Acheteur
                            </button>
                        </div>

                        <!-- ORDER SUMMARY -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-neutral-title mb-6">Résumé de la Commande</h3>

                            <div class="space-y-4">
                                <!-- Subtotal -->
                                <div class="flex justify-between items-center">
                                    <p class="text-neutral-muted">Sous-total</p>
                                    <p class="font-bold text-neutral-title">{{ formatAmount(subtotal) }} FCFA</p>
                                </div>

                                <!-- Shipping (if applicable) -->
                                <div class="flex justify-between items-center">
                                    <p class="text-neutral-muted">Frais de Livraison</p>
                                    <p class="font-bold text-neutral-title">{{ formatAmount(shippingFee) }} FCFA</p>
                                </div>

                                <!-- Total -->
                                <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                                    <p class="font-bold text-neutral-title">Total</p>
                                    <p class="text-2xl font-bold text-brand-primary">{{
                                        formatAmount(order.data.total_amount) }} FCFA</p>
                                </div>
                            </div>
                        </div>

                        <!-- STATUS BADGE -->
                        <div :class="[
                            'rounded-2xl shadow-sm border p-6 text-center',
                            getStatusBadgeClasses()
                        ]">
                            <i :class="[getStatusIcon(), 'text-4xl mb-3']"></i>
                            <p class="text-sm font-bold uppercase tracking-wider">{{ getStatusLabel() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

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
                    <button @click="updateOrderStatus('cancel')" :disabled="isUpdating"
                        class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        Confirmer l'Annulation
                    </button>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FarmerNavbar from '@/Components/Farmer/Navbar/FarmerNavbar.vue'
import FarmerSidebar from '@/Components/Farmer/Sidebar/FarmerSidebar.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import { farmerOrderChangeStatus, farmerProductsEdit } from '@/routes'
import { formatAmount } from '@/utils/formatAmount'
import { formatDate } from '@/utils/formatDate'

/**
 * Types et interfaces
 */
interface Buyer {
    id: number
    name: string
    email: string
    profile_photo?: string
}

interface ProductImages {
    id: number,
    path: string,
    is_primary: boolean,
    order: number,
}

interface Product {
    id: number
    title: string,
    unit: string,
    product_images: ProductImages[]
}

interface OrderItem {
    id: number
    quantity: number
    subtotal: number
    unit_price: number
    product_id: number
    product: Product
}

interface Order {
    id: number
    order_number: string
    farmer_id: number
    buyer_id: number
    status: OrderStatus
    payment_method: string
    delivery_address: string
    total_amount: number
    notes?: string
    created_at: string
    updated_at: string
    deleted_at?: string | null
    buyer: Buyer
    order_items: OrderItem[]
}

type OrderStatus = 'pending' | 'preparation' | 'ready' | 'success' | 'cancel' | 'dispute'

interface StatusStep {
    status: OrderStatus
    label: string
    icon: string
    completedClasses: string
    currentClasses: string
}


interface Props {
    order: {
        data: Order
    }
}

/**
 * Props definition
 */
const props = defineProps<Props>()

/**
 * Reactive state
 */
const showCancelModal = ref<boolean>(false)
const isUpdating = ref<boolean>(false)

/**
 * Status steps configuration
 */
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

/**
 * Computed properties
 */
const subtotal = computed<number>(() => {
    return props.order.data.order_items.reduce((sum, item) => sum + item.subtotal, 0)
})

const shippingFee = computed<number>(() => {
    return props.order.data.total_amount - subtotal.value
})

/**
 * Methods
 */

/**
 * Check if a step is completed
 */
const isStepCompleted = (status: OrderStatus): boolean => {
    const statusOrder = ['pending', 'preparation', 'ready', 'success']
    const currentIndex = statusOrder.indexOf(props.order.data.status as string)
    const stepIndex = statusOrder.indexOf(status)

    return stepIndex < currentIndex
}

/**
 * Check if a step is current
 */
const isStepCurrent = (status: OrderStatus): boolean => {
    return props.order.data.status === status
}

/**
 * Get step date (placeholder - you can customize this)
 */
const getStepDate = (status: OrderStatus): string => {
    if (status === props.order.data.status) {
        return formatDate(props.order.data.updated_at)
    }

    return ''
}

/**
 * Get status label
 */
const getStatusLabel = (): string => {
    const labels: Record<OrderStatus, string> = {
        pending: 'En Attente',
        preparation: 'En Préparation',
        ready: 'Prêt pour la Livraison',
        success: 'Livrée',
        cancel: 'Annulée',
        dispute: 'Litige'
    }

    return labels[props.order.data.status]
}

/**
 * Get status icon
 */
const getStatusIcon = (): string => {
    const icons: Record<OrderStatus, string> = {
        pending: 'fas fa-clock',
        preparation: 'fas fa-box',
        ready: 'fas fa-check-circle',
        success: 'fas fa-truck',
        cancel: 'fas fa-ban',
        dispute: 'fas fa-exclamation-triangle'
    }

    return icons[props.order.data.status]
}

/**
 * Get status badge classes
 */
const getStatusBadgeClasses = (): string => {
    const classes: Record<OrderStatus, string> = {
        pending: 'bg-blue-50 border-blue-200 text-blue-600',
        preparation: 'bg-yellow-50 border-yellow-200 text-yellow-600',
        ready: 'bg-purple-50 border-purple-200 text-purple-600',
        success: 'bg-green-50 border-green-200 text-green-600',
        cancel: 'bg-red-50 border-red-200 text-red-600',
        dispute: 'bg-orange-50 border-orange-200 text-orange-600'
    }

    return classes[props.order.data.status]
}

const getPrimaryImage = (product: Product): string | null => {
    if (!product.product_images || product.product_images.length === 0) {
        return null
    }

    const primaryImage = product.product_images.find(img => img.is_primary)

    return primaryImage ? primaryImage.path : product.product_images[0].path
}

/**
 * Mise a jour du status de la commande
 */
const updateOrderStatus = (newStatus: OrderStatus)=>{
    const form = useForm({
        _method: 'put',
        status: newStatus,
        order_id: props.order.data.id
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

/**
 * Go back to previous page
 */
const goBack = (): void => {
    window.history.back()
}


const page = usePage();
const user = page.props.auth.user;
</script>

<style scoped>
/* Smooth transitions */
* {
    transition: all 0.3s ease;
}

/* Hover effects for better UX */
button:hover:not(:disabled) {
    transform: translateY(-1px);
}

/* Focus states for accessibility */
input:focus,
select:focus {
    outline: none;
}

/* Status stepper line animation */
.status-line-active {
    animation: fillLine 0.6s ease-out forwards;
}

@keyframes fillLine {
    from {
        width: 0;
    }

    to {
        width: 100%;
    }
}
</style>
