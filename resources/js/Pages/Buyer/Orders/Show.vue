<template>
    <FlashMessage />
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <BuyerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- NAVBAR -->
            <BuyerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo" />

            <!-- DASHBOARD CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <!-- PAGE HEADER -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-title">Mes Commandes</h1>
                        <p class="text-sm text-neutral-muted mt-1">
                            Gérez et suivez toutes vos commandes en un seul endroit
                        </p>
                    </div>
                    <Link :href="buyerOrderConfirm()"
                        class="inline-flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-hover px-6 py-3 rounded-xl font-bold transition-all text-white">
                        <i class="fas fa-plus text-sm"></i>
                        Nouvelle Commande
                    </Link>
                </div>

                <!-- FILTERS & SEARCH -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <input type="text" v-model="searchQuery" placeholder="Rechercher par numéro de commande..."
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all" />
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <select v-model="selectedStatus"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all">
                                <option value="">Tous les statuts</option>
                                <option value="pending">En attente</option>
                                <option value="preparation">En préparation</option>
                                <option value="ready">Prêt</option>
                                <option value="success">Livrée</option>
                                <option value="cancel">Annulée</option>
                                <option value="dispute">Litige</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <select v-model="sortBy"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary focus:border-transparent transition-all">
                                <option value="recent">Plus récent</option>
                                <option value="oldest">Plus ancien</option>
                                <option value="amount-high">Montant décroissant</option>
                                <option value="amount-low">Montant croissant</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- ORDERS TABLE -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <!-- Table Header -->
                    <div
                        class="hidden md:grid grid-cols-12 gap-4 p-6 border-b border-gray-50 bg-gray-50/50 font-bold text-xs text-neutral-muted uppercase tracking-wider">
                        <div class="col-span-3">Commande</div>
                        <div class="col-span-2">Vendeur</div>
                        <div class="col-span-2">Date</div>
                        <div class="col-span-2">Montant</div>
                        <div class="col-span-1">Statut</div>
                        <div class="col-span-2">Actions</div>
                    </div>

                    <!-- Orders List -->
                    <div v-if="paginatedOrders.length > 0" class="divide-y divide-gray-50">
                        <!-- Order Item -->
                        <div v-for="order in paginatedOrders" :key="order.id"
                            class="p-6 grid grid-cols-1 md:grid-cols-12 md:gap-4 md:items-center hover:bg-neutral-bg/30 transition-all">
                            <!-- Order Number & Image -->
                            <div class="md:col-span-3 flex items-center gap-4 mb-4 md:mb-0">
                                <div
                                    class="w-14 h-14 bg-linear-to-br from-brand-primary to-brand-dark rounded-xl overflow-hidden border border-brand-primary/20 shrink-0">
                                    <img :src="`https://ui-avatars.com/api/?name=${order.order_number}&background=2D6A4F&color=fff`"
                                        class="w-full h-full object-cover" alt="Order" />
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-neutral-title text-sm">Commande #{{ order.order_number }}
                                    </h4>
                                    <p class="text-[10px] text-neutral-muted mt-1">ID: {{ order.id }}</p>
                                </div>
                            </div>

                            <!-- Farmer Name -->
                            <div class="md:col-span-2 mb-4 md:mb-0">
                                <p class="text-[10px] text-neutral-muted uppercase font-bold md:hidden">Vendeur</p>
                                <p class="text-sm font-semibold text-brand-primary">{{ order.farmer.name }}</p>
                            </div>

                            <!-- Date -->
                            <div class="md:col-span-2 mb-4 md:mb-0">
                                <p class="text-[10px] text-neutral-muted uppercase font-bold md:hidden">Date</p>
                                <p class="text-sm text-neutral-title font-medium">{{ formatDate(order.created_at) }}</p>
                            </div>

                            <!-- Amount -->
                            <div class="md:col-span-2 mb-4 md:mb-0">
                                <p class="text-[10px] text-neutral-muted uppercase font-bold md:hidden">Montant</p>
                                <p class="text-sm font-bold text-neutral-title">{{ formatAmount(order.total_amount) }}
                                    <span class="text-[10px] text-neutral-muted">FCFA</span>
                                </p>
                            </div>

                            <!-- Status Badge -->
                            <div class="md:col-span-1 mb-4 md:mb-0">
                                <p class="text-[10px] text-neutral-muted uppercase font-bold md:hidden">Statut</p>
                                <span :class="getStatusClasses(order.status)">
                                    {{ getStatusLabel(order.status) }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="md:col-span-2 flex items-center gap-2">
                                <Link :href="buyerOrderTracking(order.id)"
                                    class="flex-1 md:flex-none px-4 py-2 border border-brand-primary text-brand-primary rounded-xl text-xs font-bold hover:bg-brand-bg transition-all text-center">
                                    <i class="fas fa-eye mr-2"></i>Voir
                                </Link>
                                <Link v-if="order.status === 'pending'" :href="buyerOrderDelete(order.id)" :method="'delete'"
                                    class="flex-1 md:flex-none px-4 py-2 border border-red-200 text-red-600 rounded-xl text-xs font-bold hover:bg-red-50 transition-all">
                                    <i class="fas fa-trash mr-2"></i>Supprimer
                                </Link>
                                <button v-else disabled
                                    class="flex-1 md:flex-none px-4 py-2 border border-gray-200 text-gray-400 rounded-xl text-xs font-bold cursor-not-allowed opacity-50">
                                    <i class="fas fa-trash mr-2"></i>Supprimer
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div v-else class="p-12 text-center">
                        <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-bold text-neutral-title mb-2">Aucune commande trouvée</h3>
                        <p class="text-sm text-neutral-muted mb-6">
                            {{
                                searchQuery || selectedStatus ? 'Essayez de modifier vos filtres' :
                                    'Commencez à faire vos courses maintenant'
                            }}
                        </p>
                        <Link href="#"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-brand-primary text-white text-sm font-bold rounded-xl hover:bg-brand-hover transition-all">
                            <i class="fas fa-shopping-cart"></i>
                            Découvrir les produits
                        </Link>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-6 mb-5">
                        <Pagination :meta="props.orders.meta" />
                    </div>
                </div>
            </div>
        </main>
    </main>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import BuyerNavbar from '@/Components/Buyer/Navbar/BuyerNavbar.vue'
import BuyerSidebar from '@/Components/Buyer/Sidebar/BuyerSidebar.vue'
import FlashMessage from '@/Components/FlashMessage.vue'
import Pagination from '@/Components/Pagination.vue'
import { buyerOrderConfirm, buyerOrderDelete, buyerOrderTracking } from '@/routes'
import { formatAmount } from '@/utils/formatAmount'
import { formatDate } from '@/utils/formatDate'


/**
 * Types et interfaces
 */
interface Farmer {
    id: number
    name: string
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
    farmer: Farmer,
}

type OrderStatus = 'pending' | 'preparation' | 'ready' | 'success' | 'cancel' | 'dispute'


interface PaginationLink {
    label?: string,
    url?: string,
    active: boolean,
}

interface Props {
    orders: {
        data: Order[],
        meta: {
            links: PaginationLink[];
        }
    },
}

const page = usePage();
const user = page.props.auth.user;

/**
 * Props definition
 */
const props = defineProps<Props>()


const searchQuery = ref<string>('')
const selectedStatus = ref<OrderStatus | ''>('')
const sortBy = ref<'recent' | 'oldest' | 'amount-high' | 'amount-low'>('recent')
const currentPage = ref<number>(1)
const itemsPerPage = ref<number>(10)


const filteredOrders = computed<Order[]>(() => {
    let filtered: Order[] = props.orders.data || []

    // Filtrage
    if (searchQuery.value) {
        filtered = filtered.filter(order =>
            order.order_number.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            order.id.toString().includes(searchQuery.value)
        )
    }

    // Filter by status
    if (selectedStatus.value) {
        filtered = filtered.filter(order => order.status === selectedStatus.value)
    }

    // Sort orders
    switch (sortBy.value) {
        case 'recent':
            filtered.sort((a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime())
            break
        case 'oldest':
            filtered.sort((a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime())
            break
        case 'amount-high':
            filtered.sort((a, b) => b.total_amount - a.total_amount)
            break
        case 'amount-low':
            filtered.sort((a, b) => a.total_amount - b.total_amount)
            break
    }

    return filtered
})

const startIndex = computed<number>(() => (currentPage.value - 1) * itemsPerPage.value)
const endIndex = computed<number>(() => startIndex.value + itemsPerPage.value)

const paginatedOrders = computed<Order[]>(() => {
    return filteredOrders.value.slice(startIndex.value, endIndex.value)
})

/**
 * Methods
 */

/**
 * Get CSS classes for status badge
 */
const getStatusClasses = (status: OrderStatus): string[] => {
    const baseClasses = ['inline-block', 'px-3', 'py-1', 'text-[10px]', 'font-bold', 'rounded-full', 'uppercase']

    const statusClasses: Record<OrderStatus, string[]> = {
        pending: [...baseClasses, 'bg-blue-100', 'text-blue-700'],
        preparation: [...baseClasses, 'bg-yellow-100', 'text-yellow-700'],
        ready: [...baseClasses, 'bg-purple-100', 'text-purple-700'],
        success: [...baseClasses, 'bg-green-100', 'text-green-700'],
        cancel: [...baseClasses, 'bg-red-100', 'text-red-700'],
        dispute: [...baseClasses, 'bg-orange-100', 'text-orange-700']
    }

    return statusClasses[status] || [...baseClasses, 'bg-gray-100', 'text-gray-700']
}

/**
 * Get label for order status
 */
const getStatusLabel = (status: OrderStatus): string => {
    const statusLabels: Record<OrderStatus, string> = {
        pending: 'En attente',
        preparation: 'En préparation',
        ready: 'Prêt',
        success: 'Livrée',
        cancel: 'Annulée',
        dispute: 'Litige'
    }

    return statusLabels[status] || 'Inconnu'
}

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
</style>
