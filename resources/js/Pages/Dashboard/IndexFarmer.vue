<template>
    <FlashMessage />
    <div v-if="user.role === 'farmer'">
        <FarmerDashboard :user="page.props.auth.user" :count-products-avaliable="countProductsAvaliable"
            :products-low="productsLow" :sum-amount-orders="sumAmountOrders" :recents-orders="recentsOrders"
            :count-orders-pending="countOrdersPending" :farmer_average_rating="farmer_average_rating ?? 0"
            :revenue-chart-data="revenueChartData" :last-messages="lastMessages"/>
    </div>
</template>
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import FarmerDashboard from "@/Components/Farmer/FarmerDashboard.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import type { User } from "@/types";

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

interface RevenueChartData {
    labels: string[]
    data: number[]
}

interface StatisticDashboardFarmer {
    farmer_average_rating?: number,
    countProductsAvaliable: number | string;
    sumAmountOrders: string | number;
    countOrdersPending: number | string,
    productsLow: ProductsLow,
    recentsOrders: RecentsOrders,
    revenueChartData: RevenueChartData
    lastMessages: {
        data: Message[]
    }
}

interface Message {
    id: number,
    sender: User,
    body: string,
    created_at: string
}
interface ProductsLow {
    data: {
        id: number,
        title: string,
        quantity: number,
        unit: string,
    }[]
}

defineProps<StatisticDashboardFarmer>();
const page = usePage();
const user = page.props.auth.user.data;
</script>
