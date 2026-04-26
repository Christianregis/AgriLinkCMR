<template>
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
                    <label v-for="cat in allCategories" :key="cat.id" class="flex items-center group cursor-pointer">
                        <input type="checkbox" :value="cat.id" v-model="selectedCategories"
                            class="w-5 h-5 rounded border-gray-300 text-brand-primary focus:ring-brand-primary" />
                        <span class="ml-3 text-neutral-body group-hover:text-brand-primary transition-colors">{{
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
                <Link :href="inscription()" class="inline-block bg-accent-cta px-4 py-2 rounded-lg text-sm font-bold">En
                    savoir
                    plus</Link>
            </div>
            <i class="fas fa-wheat-awn absolute -bottom-4 -right-4 text-white/10 text-8xl rotate-12"></i>
        </div>
    </aside>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { watch } from 'vue';
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

interface Props {
    categories: {
        data: Category[];
    }
    regions: {
        data: Region[]
    };
}

const selectedCategories = ref<number[]>([]);
const selectedRegion = ref<number | string>('');
const maxPrice = ref<number>(50000);
const minRating = ref<number>(0);
const sortBy = ref<string>('latest');

const resetFilters = () => {
    selectedCategories.value = [];
    selectedRegion.value = '';
    maxPrice.value = 50000;
    minRating.value = 0;
    sortBy.value = 'latest';
    // Zone pour reinitialiser les donnees
    console.log('Filters reset');
};

const props = defineProps<Props>()

const allCategories = props.categories.data;
const allRegions = props.regions.data;

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
