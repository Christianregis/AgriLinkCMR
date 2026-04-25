<template>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div :class="['w-14 h-14 rounded-2xl flex items-center justify-center text-2xl', bg_brand, text_brand]">
            <i :class="icon"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-neutral-muted uppercase tracking-wider">
                {{ label }}
            </p>
            <h3 class="text-2xl font-bold text-neutral-title">{{ value }}</h3>
        </div>
    </div>
</template>
<script setup lang="ts">
interface Props {
    label: string;
    value: number | string;
    bg_brand: string;
    text_brand: string;
    icon: string;
}

defineProps<Props>();
</script>
