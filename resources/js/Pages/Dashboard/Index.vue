<template>
<FlashMessage />
<div v-if="user.role=== 'buyer'">
<BuyerDashboard :user="page.props.auth.user"/>
</div>
<div v-if="user.role=== 'farmer'">
<FarmerDashboard :user="page.props.auth.user"/>
</div>
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import BuyerDashboard from '@/Components/Buyer/BuyerDashboard.vue';
import FarmerDashboard from '@/Components/Farmer/FarmerDashboard.vue';
import FlashMessage from '@/Components/FlashMessage.vue';


const page = usePage();
const user = page.props.auth.user.data;
</script>
