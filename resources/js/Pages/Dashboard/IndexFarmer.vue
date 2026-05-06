<template>
    <FlashMessage />
    <div v-if="user.role === 'farmer'">
        <FarmerDashboard :user="page.props.auth.user" :count-products-avaliable="countProductsAvaliable"
            :products-low="productsLow" :sum-amount-orders="sumAmountOrders" :recents-orders="recentsOrders" :count-orders-pending="countOrdersPending"
            :farmer_average_rating="farmer_average_rating"/>
    </div>
</template>
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import FarmerDashboard from "@/Components/Farmer/FarmerDashboard.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

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

interface StatisticDashboardFarmer {
    farmer_average_rating: number,
    countProductsAvaliable: number;
    sumAmountOrders: string;
    countOrdersPending: number,
    productsLow: ProductsLow,
    recentsOrders: RecentsOrders,
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
