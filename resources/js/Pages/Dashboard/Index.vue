<template>
    <FlashMessage />
    <div v-if="user.role === 'buyer'">
        <BuyerDashboard :user="page.props.auth.user" />
    </div>
    <div v-if="user.role === 'farmer'">
        <FarmerDashboard :user="page.props.auth.user" :count-products-avaliable="countProductsAvaliable" :products-low="productsLow"
            :sum-amount-orders="sumAmountOrders" />
    </div>
</template>
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import BuyerDashboard from "@/Components/Buyer/BuyerDashboard.vue";
import FarmerDashboard from "@/Components/Farmer/FarmerDashboard.vue";
import FlashMessage from "@/Components/FlashMessage.vue";


interface StatisticDashboard {
    countProductsAvaliable: number;
    sumAmountOrders: number;
    productsLow: ProductsLow,
}

interface ProductsLow {
    data: {
        id: string,
        title: string,
        quantity: number,
        unit: string,
    }[]
}

defineProps<StatisticDashboard>();
const page = usePage();
const user = page.props.auth.user.data;
</script>
