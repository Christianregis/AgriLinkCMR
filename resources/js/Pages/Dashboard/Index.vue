<template>
<FlashMessage />
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import FlashMessage from '@/Components/FlashMessage.vue';

const page = usePage();
console.log(page.props.auth.user.data.role)
</script>
