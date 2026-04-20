<template>
  <div
    class="flex items-center gap-2 px-4 py-3 text-white shadow-lg rounded-xl animate-slide-in"
    :class="{
      'bg-green-600': type === 'success',
      'bg-red-500': type === 'error',
    }"
  >
    <span v-if="type === 'success'"><i class="fa-solid fa-circle-check"></i></span>
    <span v-if="type === 'error'"><i class="fa-solid fa-xmark"></i></span>
    <span>{{ message }}</span>
  </div>
</template>

<style scoped>
@keyframes slide-in {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

.animate-slide-in {
  animation: slide-in 0.3s ease;
}
</style>
<script setup lang="ts">
defineProps<{
  message: string;
  type: 'success' | 'error';
}>();
</script>