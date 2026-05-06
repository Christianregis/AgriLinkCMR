<template>
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <FarmerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- NAVBAR -->
            <FarmerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo" />

            <!-- DASHBOARD CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <!-- PAGE HEADER -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-neutral-title">Toutes les Commandes</h1>
                        <p class="text-sm text-neutral-muted mt-1">
                            Visualisez et gérez l'ensemble de vos commandes
                        </p>
                    </div>
                </div>

                <!-- FILTERS & SEARCH SECTION -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Input -->
                        <div class="md:col-span-2">
                            <input type="text" v-model="searchQuery"
                                placeholder="Rechercher par numéro de commande ou acheteur..."
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

                <!-- ORDERS TABLE COMPONENT -->
                <OrderTable :data="paginatedOrders" />

                <div class="mt-6 flex justify-center">
                    <Pagination :meta="orders.meta" />
                </div>
                <!-- EMPTY STATE -->
                <div v-if="filteredOrders.length === 0"
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-bold text-neutral-title mb-2">Aucune commande trouvée</h3>
                    <p class="text-sm text-neutral-muted">
                        {{ searchQuery || selectedStatus ? 'Essayez de modifier vos filtres' : 'Vous n\'avez pas encor de commandes' }}
                    </p>
                </div>
            </div>
        </main>
    </main>
</template>

<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import FarmerNavbar from '@/Components/Farmer/Navbar/FarmerNavbar.vue'
import OrderTable from '@/Components/Farmer/Order/OrderTable.vue'
import FarmerSidebar from '@/Components/Farmer/Sidebar/FarmerSidebar.vue'
import Pagination from '@/Components/Pagination.vue'


/**
 * Types et interfaces
 */
interface Buyer {
    id: number
    name: string
    email: string
    profile_photo?: string
}

interface OrderItem {
    id: number
    quantity: number
    subtotal: number
    unit_price: number
    product_id: number
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

interface PaginationLink {
    label?: string,
    url?: string,
    active: boolean,
}

type OrderStatus = 'pending' | 'preparation' | 'ready' | 'success' | 'cancel' | 'dispute'

interface Props {
    orders: {
        data: Order[],
        meta: {
            links: PaginationLink[];
        }
    }
}

const page = usePage()
const user = page.props.auth.user;
/**
 * Props definition
 */
const props = defineProps<Props>()


const searchQuery = ref<string>('')
const selectedStatus = ref<OrderStatus | ''>('')
const sortBy = ref<'recent' | 'oldest' | 'amount-high' | 'amount-low'>('recent')


/**
 * Computed properties - Filtered Orders
 */
const filteredOrders = computed<Order[]>(() => {
    let filtered: Order[] = props.orders.data || []

    // Filter by search query (order number or buyer name)
    if (searchQuery.value) {
        const query = searchQuery.value.toLowerCase()
        filtered = filtered.filter(order =>
            order.order_number.toLowerCase().includes(query) ||
            order.buyer.name.toLowerCase().includes(query) ||
            order.id.toString().includes(query)
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


const paginatedOrders = computed<Order[]>(() => {
    return filteredOrders.value
})

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
