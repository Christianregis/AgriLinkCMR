<template>
    <div class="min-h-screen bg-neutral-bg flex flex-col">
        <!-- NAVBAR -->
        <AuthLayout />

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- SIDEBAR FILTERS -->
                <FilterSidebar :categories="props.categories" :regions="props.regions"/>

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
import FilterSidebar from '@/Components/FilterSidebar.vue';
import ProductCard from '@/Components/ProductCard.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';

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

// Filtres reactifs
const selectedCategories = ref<number[]>([]);
const selectedRegion = ref<number | string>('');
const maxPrice = ref<number>(50000);
const minRating = ref<number>(0);
const sortBy = ref<string>('latest');
const displayMode = ref<'grid' | 'list'>('grid'); // 'grid' or 'list'


// Watch for savoir quel element a changer pour potentielement recharger la page
watch([selectedCategories, selectedRegion, maxPrice, minRating, sortBy], () => {
    console.log('Filters changed, re-fetching products...');
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
    cursor: pointer;
    border: 2px solid white;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.5);
}

.glass-nav {
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.8);
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}
</style>
