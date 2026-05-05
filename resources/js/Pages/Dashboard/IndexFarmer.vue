<template>
    <FlashMessage />
    <div v-if="user.role === 'farmer'">
        <FarmerDashboard :user="page.props.auth.user" :count-products-avaliable="countProductsAvaliable" :products-low="productsLow"
            :sum-amount-orders="sumAmountOrders" />
    </div>
</template>
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import FarmerDashboard from "@/Components/Farmer/FarmerDashboard.vue";
import FlashMessage from "@/Components/FlashMessage.vue";


interface StatisticDashboardFarmer {
    countProductsAvaliable: number;
    sumAmountOrders: number;
    productsLow: ProductsLow,
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
