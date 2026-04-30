<template>
    <FlashMessage />
    <div>
        <BuyerDashboard :user="page.props.auth.user" />
    </div>
</template>
<script setup lang="ts">
import { usePage } from "@inertiajs/vue3";
import BuyerDashboard from "@/Components/Buyer/BuyerDashboard.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

const page = usePage();
</script>
