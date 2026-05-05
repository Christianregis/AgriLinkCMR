<template>
    <Transition name="modal">
        <div v-if="isOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-opacity-60 backdrop-blur-sm" @click="closeModal"></div>

            <!-- Modal Content -->
            <div
                class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full text-center transform transition-all duration-300 scale-100 opacity-100">
                <div
                    :class="['w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6', type === 'success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600']">
                    <i :class="['text-4xl', type === 'success' ? 'fas fa-check' : 'fas fa-times']"></i>
                </div>

                <h2 :class="['text-2xl font-bold mb-3', type === 'success' ? 'text-green-700' : 'text-red-700']">
                    {{ type === 'success' ? 'Paiement Réussi !' : 'Paiement Échoué' }}
                </h2>

                <p class="text-neutral-muted mb-6">
                    {{ message }}
                </p>

                <div class="space-y-4">
                    <Link :href="buttonLink ? buttonLink : '#'" @click="closeModal" :class="[
                        'block w-full py-3 rounded-xl font-bold text-center transition-all',
                        type === 'success'
                            ? 'bg-brand-primary hover:bg-brand-hover text-white'
                            : 'bg-red-500 hover:bg-red-600 text-white'
                    ]">
                        {{ buttonText }}
                    </Link>
                    <button v-if="type === 'failure'" @click="closeModal"
                        class="w-full py-3 text-neutral-muted hover:text-brand-primary transition-colors font-medium">
                        Réessayer le paiement
                    </button>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

interface Props {
    isOpen: boolean;
    type: 'success' | 'failure';
    message: string;
    buttonText: string;
    buttonLink?: string;
}

defineProps<Props>();
const emit = defineEmits(['close']);

const closeModal = () => {
    emit('close');
};

// Transitions for modal
// .modal-enter-active, .modal-leave-active { transition: opacity 0.3s ease; }
// .modal-enter-from, .modal-leave-to { opacity: 0; }
// .modal-enter-active .modal-content, .modal-leave-active .modal-content {
//   transition: all 0.3s ease;
// }
// .modal-enter-from .modal-content, .modal-leave-to .modal-content {
//   -webkit-transform: scale(1.1);
//   transform: scale(1.1);
//   opacity: 0;
// }
</script>

<style scoped>
.modal-enter-active .relative,
.modal-leave-active .relative {
    transition: all 0.3s ease-in-out;
}

.modal-enter-from .relative,
.modal-leave-to .relative {
    opacity: 0;
    transform: scale(0.9);
}

.modal-enter-active div:first-child,
.modal-leave-active div:first-child {
    transition: opacity 0.3s ease-in-out;
}

.modal-enter-from div:first-child,
.modal-leave-to div:first-child {
    opacity: 0;
}
</style>
