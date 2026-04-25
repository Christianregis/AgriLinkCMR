<template>
    <div class="min-h-screen bg-neutral-bg flex flex-col">
        <!-- NAVBAR -->
        <AuthLayout />

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- SIDEBAR FILTERS -->
                <aside class="w-full lg:w-72 space-y-8">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-lg font-bold text-neutral-title">Filtres</h2>
                            <button @click="resetFilters"
                                class="text-sm text-brand-primary font-medium hover:underline">Réinitialiser</button>
                        </div>

                        <!-- Categories -->
                        <div class="mb-8">
                            <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Catégories
                            </h3>
                            <div class="space-y-3">
                                <label v-for="cat in allCategories" :key="cat.id"
                                    class="flex items-center group cursor-pointer">
                                    <input type="checkbox" :value="cat.id" v-model="selectedCategories"
                                        class="w-5 h-5 rounded border-gray-300 text-brand-primary focus:ring-brand-primary" />
                                    <span
                                        class="ml-3 text-neutral-body group-hover:text-brand-primary transition-colors">{{
                                            cat.name }}</span>
                                </label>
                            </div>
                        </div>

                        <!-- Region -->
                        <div class="mb-8">
                            <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Région</h3>
                            <select v-model="selectedRegion"
                                class="w-full bg-neutral-bg border border-neutral-border rounded-lg px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary transition-all">
                                <option value="">Toutes les régions</option>
                                <option v-for="reg in allRegions" :key="reg.id" :value="reg.id">
                                    {{ reg.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="mb-8">
                            <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Prix Max
                                (FCFA)</h3>
                            <input type="range" min="500" max="50000" step="500" v-model="maxPrice"
                                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-brand-primary" />
                            <div class="flex justify-between mt-2 text-sm text-neutral-muted font-medium">
                                <span>{{ maxPrice }}</span>
                                <span>50,000+</span>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div>
                            <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Note Vendeur
                            </h3>
                            <div class="space-y-2">
                                <button v-for="n in 5" :key="n" @click="minRating = n" :class="[
                                    'flex items-center text-sm',
                                    minRating === n ? 'text-brand-primary' : 'text-neutral-body hover:text-brand-primary'
                                ]">
                                    <div class="flex text-accent-star mr-2">
                                        <i v-for="i in 5" :key="i" :class="[i <= n ? 'fas' : 'far', 'fa-star']"></i>
                                    </div>
                                    & {{ n }} et plus
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Promo Card -->
                    <div class="bg-brand-dark rounded-2xl p-6 text-white relative overflow-hidden">
                        <div class="relative z-10">
                            <h4 class="font-bold text-xl mb-2">Devenir Vendeur ?</h4>
                            <p class="text-brand-light/70 text-sm mb-4">Vendez vos récoltes directement aux clients.</p>
                            <Link :href="inscription()"
                                class="inline-block bg-accent-cta px-4 py-2 rounded-lg text-sm font-bold">En savoir
                                plus</Link>
                        </div>
                        <i class="fas fa-wheat-awn absolute -bottom-4 -right-4 text-white/10 text-8xl rotate-12"></i>
                    </div>
                </aside>

                <!-- PRODUCT LIST -->
                <div class="flex-1">
                    <!-- Toolbar -->
                    <div
                        class="bg-white rounded-2xl p-4 mb-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                        <p class="text-neutral-body font-medium">Affichage de <span
                                class="text-brand-primary font-bold">{{ products.data.length }} produits</span></p>
                        <div class="flex items-center gap-4 w-full md:w-auto">
                            <span class="text-sm text-neutral-muted whitespace-nowrap">Trier par :</span>
                            <select v-model="sortBy"
                                class="bg-neutral-bg border-none rounded-lg px-4 py-2 text-sm font-semibold focus:ring-0 cursor-pointer">
                                <option value="latest">Plus récents</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                                <option value="rating">Mieux notés</option>
                            </select>
                            <div class="flex border-l border-gray-200 pl-4 gap-2">
                                <button @click="displayMode = 'grid'"
                                    :class="['w-9 h-9 flex items-center justify-center rounded-lg', displayMode === 'grid' ? 'bg-brand-primary text-white' : 'text-neutral-muted hover:bg-gray-100']"><i
                                        class="fas fa-th-large"></i></button>
                                <button @click="displayMode = 'list'"
                                    :class="['w-9 h-9 flex items-center justify-center rounded-lg', displayMode === 'list' ? 'bg-brand-primary text-white' : 'text-neutral-muted hover:bg-gray-100']"><i
                                        class="fas fa-list"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Product Grid/List -->
                    <div v-if="products.data.length > 0"
                        :class="{ 'grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6': displayMode === 'grid', 'space-y-6': displayMode === 'list' }">
                        <div v-for="product in products.data" :key="product.id"
                            :class="['bg-white rounded-2xl overflow-hidden border border-gray-100 card-hover group', { 'flex flex-col md:flex-row': displayMode === 'list' }]">
                            <ProductCard :product="product" :display-mode="displayMode"/>
                        </div>
                    </div>
                    <div v-else class="text-center py-12 text-neutral-muted text-lg">
                        Aucun produit ne correspond à vos critères de recherche.
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        <div class="flex items-center justify-between mt-6">
                            <div class="flex justify-center gap-4 mt-6">
                                <Link v-if="products.links.prev" :href="products.links.prev"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-gray-200 text-sm font-medium text-neutral-muted hover:bg-gray-100 hover:text-neutral-title transition">
                                    <i class="fas fa-arrow-left text-xs"></i>
                                    Précédent
                                </Link>

                                <Link v-if="products.links.next" :href="products.links.next"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-brand-primary text-white text-sm font-medium hover:bg-brand-primary/90 transition">
                                    Suivant
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import ProductCard from '@/Components/ProductCard.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { inscription } from '@/routes';

// Types
interface Category {
    id: number;
    name: string;
}

interface Region {
    id: number;
    name: string;
}

interface Product {
    id: number;
    title: string;
    description: string;
    quantity: number;
    unit: string;
    price: number;
    min_order_qte: number;
    price_negotiable: boolean;
    harvest_date: string | null;
    expire_at: string | null;
    status: string;
    primary_image_url?: string;
    category: Category;
    region: Region;
    average_rating: number;
    reviews_count: number;
}

interface PaginationLink {
    next: string,
    prev: string
}

interface ProductsData {
    data: Product[];
    links: PaginationLink;
}

interface ProductCatalogBuyerProps {
    products: ProductsData;
    categories: {
        data: Category[];
    }
    regions: {
        data: Region[]
    };
}

const props = defineProps<ProductCatalogBuyerProps>();

const allRegions = props.regions.data;
const allCategories = props.categories.data;
// Filtres reactifs
const selectedCategories = ref<number[]>([]);
const selectedRegion = ref<number | string>('');
const maxPrice = ref<number>(50000);
const minRating = ref<number>(0);
const sortBy = ref<string>('latest');
const displayMode = ref<'grid' | 'list'>('grid'); // 'grid' or 'list'


// Function to reset filters
const resetFilters = () => {
    selectedCategories.value = [];
    selectedRegion.value = '';
    maxPrice.value = 50000;
    minRating.value = 0;
    sortBy.value = 'latest';
    // Zone pour reinitialiser les donnees
    console.log('Filters reset');
};

// Watch for filter changes to potentially re-fetch products
watch([selectedCategories, selectedRegion, maxPrice, minRating, sortBy], () => {
    console.log('Filters changed, re-fetching products...');
    // In a real Inertia app, you'd make an Inertia.get request here
    // Example: Inertia.get(route('buyer.products.index'), {
    //   categories: selectedCategories.value,
    //   region: selectedRegion.value,
    //   max_price: maxPrice.value,
    //   min_rating: minRating.value,
    //   sort_by: sortBy.value
    // }, { preserveState: true });
});

</script>

<style scoped>
/* Custom styles for the range input thumb */
input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    height: 18px;
    width: 18px;
    border-radius: 50%;
    background: var(--color-brand-primary, #2D6A4F);
    /* Fallback for custom property */
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
}

/* Glassmorphism effect for navbar */
.glass-nav {
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.8);
}

/* Card hover effect */
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}
</style>
