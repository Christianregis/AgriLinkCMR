<template>
    <FlashMessage />
    <div>
        <BuyerDashboard :user="page.props.auth.user" :stats="props.stats" :recent-orders="props.recentOrders" />
    </div>
</template>
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import BuyerDashboard from "@/Components/Buyer/BuyerDashboard.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

interface Farmer {
    id: number,
    name: string,

}

interface StatisticBuyerDashboard {
    stats: {
        countOrdersPending: number | string,
        countOrdersSuccess: number |string,
        totalExpenses: number | string,
    },
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
    }
}
const props = defineProps<StatisticBuyerDashboard>()

const page = usePage();
</script>
