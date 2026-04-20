<script setup lang="ts">
import { usePage } from '@inertiajs/vue3'
import { computed, ref, watch } from 'vue'
import ToastMessage from './ToastMessage.vue'

const page = usePage()

const flash = computed(() => page.props.flash)

const messages = ref<{ id: number; text: string; type: 'success' | 'error' }[]>([])

let id = 0

watch(flash, (newFlash: any) => {
  if (newFlash.success) {
    messages.value.push({
      id: id++,
      text: newFlash.success,
      type: 'success',
    })
  }

  if (newFlash.error) {
    messages.value.push({
      id: id++,
      text: newFlash.error,
      type: 'error',
    })
  }

  // Auto remove après 4s
  setTimeout(() => {
    messages.value.shift()
  }, 4000)

}, { immediate: true })
</script>

<template>
  <div class="fixed z-50 space-y-3 top-5 right-5">
    <ToastMessage
      v-for="msg in messages"
      :key="msg.id"
      :message="msg.text"
      :type="msg.type"
    />
  </div>
</template>
