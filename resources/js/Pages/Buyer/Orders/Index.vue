<template>
    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <BuyerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- NAVBAR -->
            <BuyerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo" />

            <!-- PAGE CONTENT -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8">
                <div class="max-w-6xl mx-auto">
                    <!-- HEADER -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-neutral-title">Récapitulatif de commande</h1>
                            <p class="text-neutral-muted mt-1">Vérifiez vos articles et choisissez votre mode de
                                livraison</p>
                        </div>
                        <Link :href="catalog()"
                            class="inline-flex items-center text-brand-primary font-bold hover:underline">
                            <i class="fas fa-arrow-left mr-2"></i> Continuer les courses
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- LEFT COLUMN: ITEMS & DELIVERY -->
                        <div class="lg:col-span-2 space-y-6">
                            <!-- ITEMS LIST -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                                <div class="p-6 border-b border-gray-50">
                                    <h2 class="text-xl font-bold text-neutral-title flex items-center">
                                        <i class="fas fa-shopping-basket mr-3 text-brand-primary"></i>
                                        Vos Articles ({{ cartStore.totalItems }})
                                    </h2>
                                </div>
                                <div class="divide-y divide-gray-50">
                                    <div v-for="item in cartStore.cartItems" :key="item.product.id"
                                        class="p-6 flex items-center gap-4 group">
                                        <div
                                            class="w-20 h-20 rounded-2xl overflow-hidden shrink-0 border border-gray-100">
                                            <img :src="item.product.primary_image_url || 'https://via.placeholder.com/80x80?text=Produit'"
                                                class="w-full h-full object-cover" />
                                        </div>
                                        <div class="grow">
                                            <div class="flex justify-between items-start">
                                                <Link :href="productInfo(item.product.id)"
                                                    class="text-lg font-bold text-neutral-title hover:text-brand-primary transition-colors">
                                                    {{ item.product.title }}
                                                </Link>
                                                <span class="font-bold text-neutral-title">{{ (item.product.price *
                                                    item.quantity).toLocaleString() }} FCFA</span>
                                            </div>
                                            <p class="text-sm text-neutral-muted mb-3">{{
                                                item.product.price.toLocaleString() }} FCFA / {{ item.product.unit }}
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center bg-neutral-bg rounded-xl p-1">
                                                    <button
                                                        @click="cartStore.updateQuantity(item.product.id, item.quantity - 1)"
                                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm transition-all text-neutral-body">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <span class="w-10 text-center font-bold text-neutral-title">{{
                                                        item.quantity }}</span>
                                                    <button
                                                        @click="cartStore.updateQuantity(item.product.id, item.quantity + 1)"
                                                        :disabled="item.quantity >= item.product.stock"
                                                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white hover:shadow-sm transition-all text-neutral-body disabled:opacity-30">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                                <button @click="cartStore.removeItem(item.product.id)"
                                                    class="text-red-400 hover:text-red-600 text-sm font-medium flex items-center gap-1">
                                                    <i class="fas fa-trash-alt"></i> Supprimer
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-if="cartStore.cartItems.length === 0" class="p-12 text-center">
                                    <div
                                        class="w-20 h-20 bg-neutral-bg rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-shopping-cart text-3xl text-neutral-muted"></i>
                                    </div>
                                    <p class="text-neutral-muted font-medium">Votre panier est vide</p>
                                    <Link :href="catalog()" class="mt-4 inline-block text-brand-primary font-bold">Aller
                                        au catalogue</Link>
                                </div>
                            </div>

                            <!-- DELIVERY OPTIONS -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                                <h2 class="text-xl font-bold text-neutral-title mb-6 flex items-center">
                                    <i class="fas fa-truck mr-3 text-brand-primary"></i>
                                    Mode de livraison
                                </h2>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                    <label
                                        class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                        :class="form.delivery_method === 'delivery' ? 'border-brand-primary bg-brand-bg/10' : 'border-gray-100 hover:border-brand-primary/30'">
                                        <input type="radio" v-model="form.delivery_method" value="delivery"
                                            class="sr-only" />
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-neutral-title">Livraison à domicile</span>
                                            <i class="fas fa-home"
                                                :class="form.delivery_method === 'delivery' ? 'text-brand-primary' : 'text-neutral-muted'"></i>
                                        </div>
                                        <p class="text-xs text-neutral-muted">Nous livrons directement à votre adresse
                                            indiquée.</p>
                                    </label>

                                    <label
                                        class="relative flex flex-col p-4 border-2 rounded-2xl cursor-pointer transition-all"
                                        :class="form.delivery_method === 'pickup' ? 'border-brand-primary bg-brand-bg/10' : 'border-gray-100 hover:border-brand-primary/30'">
                                        <input type="radio" v-model="form.delivery_method" value="pickup"
                                            class="sr-only" />
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="font-bold text-neutral-title">Récupération en personne</span>
                                            <i class="fas fa-handshake"
                                                :class="form.delivery_method === 'pickup' ? 'text-brand-primary' : 'text-neutral-muted'"></i>
                                        </div>
                                        <p class="text-xs text-neutral-muted">Récupérez vos produits directement chez
                                            l'agriculteur.</p>
                                    </label>
                                </div>

                                <!-- ADDRESS FIELD (Conditional) -->
                                <Transition enter-active-class="transition duration-300 ease-out"
                                    enter-from-class="transform scale-95 opacity-0"
                                    enter-to-class="transform scale-100 opacity-100"
                                    leave-active-class="transition duration-200 ease-in"
                                    leave-from-class="transform scale-100 opacity-100"
                                    leave-to-class="transform scale-95 opacity-0">
                                    <div v-if="form.delivery_method === 'delivery'" class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-bold text-neutral-title mb-2">Adresse
                                                complète de livraison</label>
                                            <div class="relative">
                                                <i
                                                    class="fas fa-map-marker-alt absolute left-4 top-4 text-brand-primary"></i>
                                                <textarea v-model="form.delivery_address" rows="3"
                                                    placeholder="Ex: Rue 123, Quartier Bastos, Yaoundé (Précisez des points de repère)"
                                                    class="w-full pl-12 pr-4 py-3 bg-neutral-bg border-none rounded-2xl focus:ring-2 focus:ring-brand-primary text-neutral-body placeholder:text-neutral-muted resize-none"></textarea>
                                            </div>
                                            <p v-if="form.errors.delivery_address" class="mt-1 text-xs text-red-500">{{
                                                form.errors.delivery_address }}</p>
                                        </div>
                                    </div>
                                </Transition>

                                <!-- OPTIONAL NOTE -->
                                <div class="mt-6">
                                    <label class="block text-sm font-bold text-neutral-title mb-2">Note optionnelle pour
                                        le vendeur</label>
                                    <input v-model="form.note" type="text"
                                        placeholder="Ex: Merci de bien emballer les tomates..."
                                        class="w-full px-4 py-3 bg-neutral-bg border-none rounded-2xl focus:ring-2 focus:ring-brand-primary text-neutral-body placeholder:text-neutral-muted" />
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT COLUMN: SUMMARY & PAYMENT -->
                        <div class="space-y-6">
                            <!-- PAYMENT METHOD -->
                            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                                <h2 class="text-lg font-bold text-neutral-title mb-4">Mode de paiement</h2>
                                <div class="space-y-3">
                                    <label
                                        class="flex items-center p-3 border border-gray-100 rounded-xl cursor-pointer hover:bg-neutral-bg transition-colors"
                                        :class="form.payment_method === 'momo' ? 'border-brand-primary bg-brand-bg/5' : ''">
                                        <input type="radio" v-model="form.payment_method" value="momo"
                                            class="sr-only" />
                                        <div
                                            class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-mobile-alt text-white"></i>
                                        </div>
                                        <span class="font-bold text-neutral-title grow">Mobile Money / Orange
                                            Money</span>
                                        <i v-if="form.payment_method === 'momo'"
                                            class="fas fa-check-circle text-brand-primary"></i>
                                    </label>

                                    <label
                                        class="flex items-center p-3 border border-gray-100 rounded-xl cursor-pointer hover:bg-neutral-bg transition-colors"
                                        :class="form.payment_method === 'cash' ? 'border-brand-primary bg-brand-bg/5' : ''">
                                        <input type="radio" v-model="form.payment_method" value="cash"
                                            class="sr-only" />
                                        <div
                                            class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-truck text-white"></i>
                                        </div>
                                        <span class="font-bold text-neutral-title grow">Paiement à la livraison</span>
                                        <i v-if="form.payment_method === 'cash'"
                                            class="fas fa-check-circle text-brand-primary"></i>
                                    </label>

                                    <label
                                        class="flex items-center p-3 border border-gray-100 rounded-xl cursor-pointer hover:bg-neutral-bg transition-colors"
                                        :class="form.payment_method === 'stripe' ? ' border-b-gray-800 bg-brand-bg/5' : ''">
                                        <input type="radio" v-model="form.payment_method" value="stripe"
                                            class="sr-only" />
                                        <div
                                            class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fab fa-stripe text-white"></i>
                                        </div>
                                        <span class="font-bold text-neutral-title grow">Paiement par Stripe</span>
                                        <i v-if="form.payment_method === 'stripe'"
                                            class="fas fa-check-circle text-brand-primary"></i>
                                    </label>
                                </div>
                            </div>

                            <!-- FINAL SUMMARY -->
                            <div class="bg-brand-dark rounded-3xl p-6 text-white shadow-xl relative overflow-hidden">
                                <i
                                    class="fas fa-receipt absolute -bottom-4 -right-4 text-white/5 text-8xl rotate-12"></i>

                                <h2 class="text-xl font-bold mb-6 relative z-10">Résumé financier</h2>

                                <div class="space-y-4 mb-6 relative z-10">
                                    <div class="flex justify-between text-brand-light/70">
                                        <span>Sous-total</span>
                                        <span>{{ cartStore.totalPrice.toLocaleString() }} FCFA</span>
                                    </div>
                                    <div class="flex justify-between text-brand-light/70">
                                        <span>Frais de livraison</span>
                                        <span>{{ form.delivery_method === 'delivery' ? deleveryTax : '0' }} FCFA</span>
                                    </div>
                                    <div class="pt-4 border-t border-white/10 flex justify-between items-end">
                                        <span class="font-bold">Total à payer</span>
                                        <div class="text-right">
                                            <p class="text-2xl font-bold text-brand-primary">
                                                {{ (cartStore.totalPrice + (form.delivery_method === 'delivery' ? deleveryTax :
                                                0)).toLocaleString() }} FCFA
                                            </p>
                                            <p class="text-[10px] text-brand-light/50 uppercase tracking-widest">TVA
                                                Incluse</p>
                                        </div>
                                    </div>
                                </div>

                                <button @click="submitOrder"
                                    :disabled="form.processing || cartStore.cartItems.length === 0"
                                    class="w-full py-4 bg-brand-primary hover:bg-brand-hover text-white font-bold rounded-2xl shadow-lg shadow-brand-primary/20 transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed relative z-10">
                                    <i v-if="form.processing" class="fas fa-spinner fa-spin"></i>
                                    <span v-else>Confirmer la commande</span>
                                </button>

                                <p class="text-[10px] text-center text-brand-light/40 mt-4 relative z-10">
                                    En confirmant, vous acceptez nos conditions générales de vente et de livraison.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </main>
</template>

<script setup lang="ts">
import { useForm, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import BuyerNavbar from '@/Components/Buyer/Navbar/BuyerNavbar.vue';
import BuyerSidebar from '@/Components/Buyer/Sidebar/BuyerSidebar.vue';
import { useCartStore } from '@/Pages/store/cartStore';
import { catalog, productInfo } from '@/routes';



const page = usePage();
const user = page.props.auth.user;

const cartStore = useCartStore();
const deleveryTax = ref<number>(2000);

const form = useForm({
    items: cartStore.cartItems.map(item => ({
        product_id: item.product.id,
        quantity: item.quantity,
        price: item.product.price
    })),
    delivery_method: 'delivery' as 'delivery' | 'pickup',
    delivery_address: '',
    payment_method: 'momo' as 'momo' | 'cash' | 'stripe',
    note: '',
    total_amount: cartStore.totalPrice,
});

const submitOrder = () => {
    // Mise à jour des items avant soumission au cas où le panier a changé
    form.items = cartStore.cartItems.map(item => ({
        product_id: item.product.id,
        quantity: item.quantity,
        price: item.product.price
    }));
    form.total_amount = cartStore.totalPrice + (form.delivery_method === 'delivery' ? deleveryTax.value : 0);

    console.log(form.data())
};
</script>

<style scoped>
/* Custom styles if needed, but Tailwind handles most */
.bg-brand-bg {
    background-color: #F0F7F4;
    /* Exemple de variable neutral-bg */
}
</style>
