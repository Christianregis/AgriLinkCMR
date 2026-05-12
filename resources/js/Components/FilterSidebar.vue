<template>
    <aside class="w-full lg:w-72 space-y-8">
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-neutral-title">Filtres</h2>
                <button @click="resetFilters"
                    class="text-sm text-brand-primary font-medium hover:underline">Réinitialiser</button>
            </div>

            <!-- Categories with Autocomplete -->
            <div class="mb-8">
                <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Catégories</h3>

                <!-- Search Input -->
                <input v-model="categorySearchQuery" type="text" placeholder="Rechercher une catégorie..."
                    class="w-full bg-neutral-bg border border-neutral-border rounded-lg px-4 py-2.5 mb-4 focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary transition-all text-sm" />

                <!-- Filtered Categories List -->
                <div class="space-y-3 max-h-48 overflow-y-auto">
                    <label v-for="cat in filteredCategories" :key="cat.id"
                        class="flex items-center group cursor-pointer">
                        <input type="checkbox" :value="cat.id" v-model="selectedCategories"
                            class="w-5 h-5 rounded border-gray-300 text-brand-primary focus:ring-brand-primary" />
                        <span class="ml-3 text-neutral-body group-hover:text-brand-primary transition-colors text-sm">
                            {{ cat.name }}
                        </span>
                    </label>

                    <!-- Empty State -->
                    <div v-if="filteredCategories.length === 0" class="text-center py-4">
                        <p class="text-neutral-muted text-sm">Aucune catégorie trouvée</p>
                    </div>
                </div>
            </div>

            <!-- Region with Autocomplete -->
            <div class="mb-8">
                <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Région</h3>

                <!-- Search Input -->
                <input v-model="regionSearchQuery" type="text" placeholder="Rechercher une région..."
                    class="w-full bg-neutral-bg border border-neutral-border rounded-lg px-4 py-2.5 mb-4 focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary transition-all text-sm" />

                <!-- Filtered Regions List -->
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    <button @click="selectedRegion = ''" :class="[
                        'w-full text-left px-4 py-2.5 rounded-lg text-sm transition-all',
                        selectedRegion === ''
                            ? 'bg-brand-bg text-brand-primary font-medium'
                            : 'bg-neutral-bg text-neutral-body hover:bg-brand-bg/50 hover:text-brand-primary'
                    ]">
                        Toutes les régions
                    </button>

                    <button v-for="reg in filteredRegions" :key="reg.id" @click="selectedRegion = reg.id" :class="[
                        'w-full text-left px-4 py-2.5 rounded-lg text-sm transition-all',
                        selectedRegion === reg.id
                            ? 'bg-brand-bg text-brand-primary font-medium'
                            : 'bg-neutral-bg text-neutral-body hover:bg-brand-bg/50 hover:text-brand-primary'
                    ]">
                        {{ reg.name }}
                    </button>

                    <!-- Empty State -->
                    <div v-if="filteredRegions.length === 0" class="text-center py-4">
                        <p class="text-neutral-muted text-sm">Aucune région trouvée</p>
                    </div>
                </div>
            </div>

            <!-- Price Range -->
            <div class="mb-8">
                <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Prix Max
                    (FCFA)</h3>
                <input type="range" min="0" max="500000" step="500" v-model="maxPrice"
                    class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-brand-primary" />
                <div class="flex justify-between mt-2 text-sm text-neutral-muted font-medium">
                    <span>{{ maxPrice }}</span>
                    <span></span>
                </div>
            </div>

            <!-- Rating -->
            <div>
                <h3 class="text-sm font-bold text-neutral-title uppercase tracking-wider mb-4">Note Vendeur
                </h3>
                <div class="space-y-2">
                    <button v-for="n in 5" :key="n" @click="minRating = n" :class="[
                        'flex items-center text-sm p-3 rounded-lg w-full text-left hover:bg-green-100 transition-colors',
                        minRating === n ? 'text-brand-primary bg-green-100' : 'text-neutral-body hover:text-brand-primary'
                    ]">
                        <div class="flex text-accent-star mr-2">
                            <i v-for="i in 5" :key="i" :class="[i <= n ? 'fas' : 'far', 'fa-star']"></i>
                        </div>
                        & {{ n }} et plus
                    </button>
                </div>
            </div>
            <!-- Bouton de filtre -->
            <div class="flex justify-center gap-4 mt-6 text-center">
                <button @click="handleFilter"
                    class="bg-brand-primary text-white font-medium hover:bg-brand-primary/90 transition rounded-md w-full mx-2 p-3">
                    Appliquer les filtres
                </button>
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
import { Link } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import { inscription } from '@/routes'

// Types
interface Category {
    id: number
    name: string
}

interface Region {
    id: number
    name: string
}

interface Props {
    categories: {
        data: Category[]
    }
    regions: {
        data: Region[]
    }
}

// Props
const props = defineProps<Props>()

// State
const selectedCategories = ref<number[]>([])
const selectedRegion = ref<number | string>('')
const maxPrice = ref<number>(0)
const minRating = ref<number>(0)
const sortBy = ref<string>('latest')

// Search queries
const categorySearchQuery = ref<string>('')
const regionSearchQuery = ref<string>('')

// Emits
const emit = defineEmits<{
    (e: 'filter', payload: {
        selectedCategories: number[]
        selectedRegion: number | string
        maxPrice: number
        minRating: number
        sortBy: string
    }): void
}>()

// Computed properties for filtered lists
const filteredCategories = computed(() => {
    if (!categorySearchQuery.value.trim()) {
        return props.categories.data
    }

    const query = categorySearchQuery.value.toLowerCase().trim()

    return props.categories.data.filter(cat =>
        cat.name.toLowerCase().includes(query)
    )
})

const filteredRegions = computed(() => {
    if (!regionSearchQuery.value.trim()) {
        return props.regions.data
    }

    const query = regionSearchQuery.value.toLowerCase().trim()

    return props.regions.data.filter(reg =>
        reg.name.toLowerCase().includes(query)
    )
})

// Methods
const resetFilters = (): void => {
    selectedCategories.value = []
    selectedRegion.value = ''
    maxPrice.value = 50000
    minRating.value = 0
    categorySearchQuery.value = ''
    regionSearchQuery.value = ''

    emit('filter', {
        selectedCategories: [],
        selectedRegion: '',
        maxPrice: 50000,
        minRating: 0,
        sortBy: 'latest'
    })
}

const handleFilter = (): void => {
    emit('filter', {
        selectedCategories: selectedCategories.value,
        selectedRegion: selectedRegion.value,
        maxPrice: maxPrice.value,
        minRating: minRating.value,
        sortBy: sortBy.value
    })
}
</script>

<style scoped>
/* Smooth scrolling for filtered lists */
.space-y-3::-webkit-scrollbar,
.space-y-2::-webkit-scrollbar {
    width: 6px;
}

.space-y-3::-webkit-scrollbar-track,
.space-y-2::-webkit-scrollbar-track {
    background: transparent;
}

.space-y-3::-webkit-scrollbar-thumb,
.space-y-2::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 3px;
}

.space-y-3::-webkit-scrollbar-thumb:hover,
.space-y-2::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}
</style>
