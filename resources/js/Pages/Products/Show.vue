<template>
    <div class="min-h-screen bg-neutral-bg">
        <!-- NAVBAR -->
        <nav class="glass-nav sticky top-0 z-50 border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="bg-brand-primary p-2 rounded-lg"><i class="fas fa-leaf text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold text-brand-dark tracking-tight">AgriLink<span
                                class="text-brand-primary">.cm</span></span>
                    </a>
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="/" class="text-neutral-muted hover:text-brand-primary transition-colors">Accueil</a>
                        <a href="/catalogue" class="text-brand-primary font-semibold">Catalogue</a>
                        <a href="/farmers"
                            class="text-neutral-muted hover:text-brand-primary transition-colors">Agriculteurs</a>
                    </div>
                    <div class="flex items-center space-x-6">
                        <button @click="cartSidebarRef?.openCart()"
                            class="relative text-neutral-body hover:text-brand-primary transition-colors">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            <span v-if="cartStore.totalItems > 0"
                                class="absolute -top-2 -right-2 bg-accent-cta text-white text-[10px] font-bold w-5 h-5 flex items-center justify-center rounded-full">{{
                                    cartStore.totalItems }}</span>
                        </button>
                        <a href="/login"
                            class="hidden md:block text-neutral-body font-medium hover:text-brand-primary">Connexion</a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div
                class="grid grid-cols-1 lg:grid-cols-2 gap-10 bg-white rounded-2xl shadow-lg p-6 md:p-10 border border-gray-100">
                <!-- Product Image Gallery -->
                <div class="flex flex-col">
                    <div class="relative h-96 w-full rounded-xl overflow-hidden mb-4 shadow-md">
                        <img :src="mainImage" alt="Product Main Image" class="w-full h-full object-cover" />
                    </div>
                    <div v-if="product.data.product_images.length > 1" class="grid grid-cols-4 gap-3">
                        <img v-for="(image) in product.data.product_images" :key="image.id" :src="image.path"
                            alt="Product Thumbnail"
                            class="w-full h-20 object-cover rounded-lg cursor-pointer border-2 transition-all"
                            :class="{ 'border-brand-primary shadow-md': mainImage === image.path, 'border-transparent hover:border-gray-300': mainImage !== image.path }"
                            @click="setMainImage(image.path)" />
                    </div>
                </div>

                <!-- Product Details -->
                <div class="space-y-6">
                    <h1 class="text-4xl font-extrabold text-neutral-title">{{ product.data.title }}</h1>
                    <div class="flex items-center space-x-4">
                        <div class="flex text-accent-star">
                            <i v-for="i in 5" :key="i"
                                :class="[i <= product.data.farmer_profile.average_rating ? 'fas' : 'far', 'fa-star']"></i>
                        </div>
                        <span class="text-neutral-muted text-sm">({{ product.data.farmer_profile.reviews_count || 0
                        }}
                            avis)</span>
                        <span class="text-sm font-medium text-brand-primary bg-brand-bg px-3 py-1 rounded-full">{{
                            product.data.category.name }}</span>
                    </div>

                    <p class="text-3xl font-bold text-brand-primary">{{ product.data.price }} <span class="text-lg">FCFA
                            / {{
                                product.data.unit }}</span></p>
                    <p v-if="product.data.price_negotiable" class="text-sm text-neutral-muted"><i
                            class="fas fa-handshake mr-1"></i> Prix négociable</p>

                    <p class="text-neutral-body leading-relaxed">{{ product.data.description }}</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-neutral-body">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-boxes text-brand-primary"></i>
                            <span>Quantité disponible: <span class="font-semibold">{{ product.data.quantity }} {{
                                product.data.unit }}</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-weight-hanging text-brand-primary"></i>
                            <span>Commande min.: <span class="font-semibold">{{ product.data.min_order_qty }} {{
                                product.data.unit
                                    }}</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar-alt text-brand-primary"></i>
                            <span>Récolté le: <span class="font-semibold">{{ formatDate(product.data.harvest_date)
                            }}</span></span>
                        </div>
                        <div v-if="product.data.expires_at" class="flex items-center space-x-2">
                            <i class="fas fa-hourglass-end text-brand-primary"></i>
                            <span>Expire le: <span class="font-semibold">{{ formatDate(product.data.expires_at)
                            }}</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-map-marker-alt text-brand-primary"></i>
                            <span>Région: <span class="font-semibold">{{ product.data.region.name }}</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-circle-info text-brand-primary"></i>
                            <span>Statut: <span class="font-semibold">{{ productStatusText(product.data.status)
                            }}</span></span>
                        </div>
                    </div>

                    <!-- Add to Cart / Quantity Selector -->
                    <div class="flex items-center space-x-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button @click="updateLocalQuantity(localQuantity - 1)"
                                :disabled="localQuantity <= product.data.min_order_qty"
                                class="px-3 py-2 text-neutral-body hover:bg-gray-100 rounded-l-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" v-model.number="localQuantity"
                                @change="updateLocalQuantity(localQuantity)"
                                class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none focus:ring-0"
                                :min="product.data.min_order_qty" :max="product.data.quantity" />
                            <button @click="updateLocalQuantity(localQuantity + 1)"
                                :disabled="localQuantity >= product.data.quantity"
                                class="px-3 py-2 text-neutral-body hover:bg-gray-100 rounded-r-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <button @click="addToCart()"
                            :disabled="localQuantity === 0 || localQuantity > product.data.quantity"
                            class="flex-1 py-3 bg-brand-primary text-white font-bold rounded-xl hover:bg-brand-hover transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-cart-plus mr-2"></i> Ajouter au panier
                        </button>
                    </div>

                    <!-- Seller Information -->
                    <div class="pt-6 border-t border-gray-100">
                        <h2 class="text-xl font-bold text-neutral-title mb-4">Informations sur le vendeur</h2>
                        <div class="flex items-center space-x-4">
                            <!-- <img :src="product.data.user.profile_photo_url || 'https://via.placeholder.com/80x80?text=Agriculteur'"
                                alt="Seller Profile Photo"
                                class="w-16 h-16 rounded-full object-cover border-2 border-brand-primary" /> -->
                            <div>
                                <!-- <h3 class="font-semibold text-neutral-title">{{ product.data.user.name }}</h3> -->
                                <div class="flex items-center text-sm text-neutral-muted">
                                    <div class="flex text-accent-star mr-2">
                                        <i v-for="i in 5" :key="i"
                                            :class="[i <= product.data.farmer_profile.average_rating ? 'fas' : 'far', 'fa-star']"></i>
                                    </div>
                                    <span>({{ product.data.farmer_profile.reviews_count || 0 }} avis)</span>
                                </div>
                                <Link :href="route('farmer.profile', product.data.farmer_profile.id)"
                                    class="text-sm text-brand-primary hover:underline mt-1 block">Voir le profil</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Cart Sidebar -->
        <CartSidebar ref="cartSidebarRef" />
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import CartSidebar from '@/Components/CartSidebar.vue'; // Adjust path as needed
import { useCartStore } from '../store/cartStore';

// Type definitions based on your provided PHP model and existing components
interface UserProfile {
    id: number,
    profile_photo_url?: string;
    average_rating: number;
    reviews_count: number;
}

interface Category {
    id: number;
    name: string;
}

interface Region {
    id: number;
    name: string;
}

interface ProductImage {
    id: number;
    path: string; // URL of the image
    is_primary: boolean;
    order: number;
}

interface Product {
    id: number;
    title: string;
    description: string;
    quantity: number;
    unit: string;
    price: number;
    min_order_qty: number;
    price_negotiable: boolean;
    harvest_date: string; // YYYY-MM-DD format
    expires_at: string | null; // YYYY-MM-DD format
    status: 'available' | 'out_of_stock' | 'coming_soon';
    user_id: number;
    category_id: number;
    region_id: number;
    product_images: ProductImage[];
    farmer_profile: UserProfile; // Include user/seller info
    category: Category;
    region: Region;
}

interface ProductShowProps {
    product: {
        data: Product;
    };
}

const props = defineProps<ProductShowProps>();

const cartStore = useCartStore();
const cartSidebarRef = ref<InstanceType<typeof CartSidebar> | null>(null);

const mainImage = ref<string>('');
const localQuantity = ref<number>(props.product.data.min_order_qty > 0 ? props.product.data.min_order_qty : 1);

onMounted(() => {
    if (props.product.data.product_images.length > 0) {
        mainImage.value = props.product.data.product_images[0].path;
    } else {
        mainImage.value = `https://via.placeholder.com/600x400?text=${props.product.data.title}`;
    }
});

const setMainImage = (imagePath: string) => {
    mainImage.value = imagePath;
};

const formatDate = (dateString: string | null) => {
    if (!dateString) {
        return 'N/A';
    }

    const options: Intl.DateTimeFormatOptions = { year: 'numeric', month: 'long', day: 'numeric' };

    return new Date(dateString).toLocaleDateString('fr-FR', options);
};

const productStatusText = (status: 'available' | 'out_of_stock' | 'coming_soon') => {
    switch (status) {
        case 'available': return 'Disponible';
        case 'out_of_stock': return 'En rupture de stock';
        case 'coming_soon': return 'Bientôt disponible';
        default: return status;
    }
};

const updateLocalQuantity = (newQty: number) => {
    if (newQty < props.product.data.min_order_qty) {
        localQuantity.value = props.product.data.min_order_qty;
    } else if (newQty > props.product.data.quantity) {
        localQuantity.value = props.product.data.quantity;
    } else {
        localQuantity.value = newQty;
    }
};

const addToCart = () => {
    const productToAdd = {
        id: props.product.data.id,
        title: props.product.data.title,
        price: props.product.data.price,
        unit: props.product.data.unit,
        primary_image_url: props.product.data.product_images[0]?.path || `https://via.placeholder.com/80x80?text=${props.product.data.title}`,
        stock: props.product.data.quantity,
    };
    cartStore.addItem(productToAdd, localQuantity.value);
    cartSidebarRef.value?.openCart(); // Open cart sidebar after adding item
};

// Helper to get Inertia route, assuming it's globally available or imported
const route = (name: string, params?: any) => {
    // This is a placeholder. In a real Inertia app, you'd use the actual route helper.
    console.log(`Route: ${name}`, params);

    if (name === 'farmer.profile' && params) {
        return `/farmers/${params}`;
    }

    return '#';
};
</script>

<style scoped>
/* Glassmorphism effect for navbar */
.glass-nav {
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.8);
}
</style>
