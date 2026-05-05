<template>
    <div class="relative z-50">
        <!-- Overlay -->
        <Transition enter-active-class="transition-opacity ease-linear duration-300" enter-from-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition-opacity ease-linear duration-300"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <div v-if="isOpen" @click="closeCart" class="fixed inset-0 bg-opacity-60 backdrop-blur-sm"></div>
        </Transition>

        <!-- Cart Sidebar -->
        <Transition enter-active-class="transition ease-in-out duration-300 transform"
            enter-from-class="translate-x-full" enter-to-class="translate-x-0"
            leave-active-class="transition ease-in-out duration-300 transform" leave-from-class="translate-x-0"
            leave-to-class="translate-x-full">
            <div v-if="isOpen"
                class="fixed inset-y-0 right-0 w-full md:w-96 bg-white shadow-lg flex flex-col overflow-hidden">
                <div class="flex items-center justify-between p-6 border-b border-gray-100">
                    <h2 class="text-xl font-bold text-neutral-title">Votre Panier ({{ cartStore.totalItems }})</h2>
                    <button @click="closeCart" class="text-neutral-muted hover:text-brand-primary transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <div v-if="cartStore.cartItems.length === 0" class="flex-1 flex items-center justify-center">
                    <div class="text-center text-neutral-muted">
                        <i class="fas fa-shopping-cart text-6xl mb-4"></i>
                        <p class="text-lg">Votre panier est vide.</p>
                        <button @click="closeCart" class="mt-4 text-brand-primary hover:underline">Continuer vos
                            achats</button>
                    </div>
                </div>

                <div v-else class="flex-1 overflow-y-auto p-6 space-y-6">
                    <div v-for="item in cartStore.cartItems" :key="item.product.id" class="flex items-center space-x-4">
                        <img :src="item.product.primary_image_url || `https://via.placeholder.com/80x80?text=${item.product.title}`"
                            alt="Product Image" class="w-20 h-20 object-cover rounded-lg border border-gray-100" />
                        <div class="flex-1">
                            <h3 class="font-semibold text-neutral-title text-base">{{ item.product.title }}</h3>
                            <p class="text-sm text-neutral-muted">{{ item.product.price }} FCFA / {{ item.product.unit
                                }}</p>
                            <div class="flex items-center mt-2">
                                <button @click="cartStore.updateQuantity(item.product.id, item.quantity - 1)"
                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-neutral-bg text-neutral-body hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <span class="mx-3 text-neutral-title font-medium">{{ item.quantity }}</span>
                                <button @click="cartStore.updateQuantity(item.product.id, item.quantity + 1)"
                                    :disabled="item.quantity >= item.product.stock"
                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-neutral-bg text-neutral-body hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                                <button @click="cartStore.removeItem(item.product.id)"
                                    class="ml-auto text-red-500 hover:text-red-700 transition-colors">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-semibold text-neutral-title">Total:</span>
                        <span class="text-xl font-bold text-brand-primary">{{ cartStore.totalPrice }} FCFA</span>
                    </div>
                    <Link :href="buyerOrderConfirm()"
                        class="block w-full text-center py-3 bg-brand-primary text-white font-bold rounded-xl hover:bg-brand-hover transition-colors">
                    Procéder au paiement
                    </Link>
                    <button @click="cartStore.clearCart()"
                        class="w-full py-2 text-neutral-muted hover:text-brand-primary transition-colors text-sm">
                        Vider le panier
                    </button>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useCartStore } from '@/Pages/store/cartStore'; // Adjust path as needed
import { buyerOrderConfirm } from '@/routes';

const cartStore = useCartStore();

const isOpen = ref<boolean>(false);

const openCart = () => {
    isOpen.value = true;
};

const closeCart = () => {
    isOpen.value = false;
};


// Permet d'exposer ( Acceder aux ) les methodes openCart et closeCart au ( depuis le ) composant parent
defineExpose({
    openCart,
    closeCart,
});
</script>

<style scoped></style>
