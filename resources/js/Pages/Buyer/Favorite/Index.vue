<template>
    <main class="bg-neutral-bg flex min-h-screen antialiased">

        <!-- SIDEBAR -->
        <BuyerSidebar ref="buyerSidebarRef" />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- NAVBAR -->
            <BuyerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo"
                @openbuyer-sidebar="openSidebar" />

            <!-- PAGE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">

                <!-- PAGE HEADER -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-title tracking-tight">
                            Mes Favoris
                        </h1>
                        <p class="text-sm text-neutral-muted mt-1">
                            {{ props.favorites.data.length }} produit{{ props.favorites.data.length > 1 ? 's' : '' }}
                            sauvegardé{{ props.favorites.data.length > 1 ? 's' : '' }}
                        </p>
                    </div>

                    <!-- Sort / Filter bar -->
                    <div class="flex items-center gap-3">
                        <button v-for="filter in filters" :key="filter.value" @click="activeFilter = filter.value"
                            :class="[
                                'px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200',
                                activeFilter === filter.value
                                    ? 'bg-brand-dark text-white shadow-sm'
                                    : 'bg-white text-neutral-muted border border-gray-100 hover:border-gray-300'
                            ]">
                            {{ filter.label }}
                        </button>
                    </div>
                </div>

                <!-- EMPTY STATE -->
                <div v-if="filteredFavorites.length === 0"
                    class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-20 h-20 bg-gray-50 rounded-3xl flex items-center justify-center mb-5">
                        <i class="fas fa-heart text-3xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-neutral-title mb-2">Aucun favori pour le moment</h3>
                    <p class="text-sm text-neutral-muted max-w-xs leading-relaxed mb-6">
                        Parcourez le catalogue et ajoutez vos produits préférés ici pour les retrouver facilement.
                    </p>
                    <Link :href="catalog.url()"
                        class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-hover text-white px-6 py-3 rounded-xl font-bold text-sm transition-all">
                        <i class="fas fa-store text-xs"></i>
                        Découvrir le catalogue
                    </Link>
                </div>

                <!-- FAVORITES GRID -->
                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    <div v-for="fav in filteredFavorites" :key="fav.id"
                        class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col">
                        <!-- Product Image -->
                        <div class="relative h-44 bg-gray-50 overflow-hidden">
                            <img v-if="fav.product.product_images && fav.product.product_images.length > 0"
                                :src="fav.product.product_images[0].path" :alt="fav.product.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                            <div v-else class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-seedling text-4xl text-gray-200"></i>
                            </div>

                            <!-- Status badge -->
                            <span :class="[
                                'absolute top-3 left-3 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wide',
                                fav.product.status === 'available'
                                    ? 'bg-green-50 text-green-600'
                                    : 'bg-red-50 text-red-500'
                            ]">
                                {{ fav.product.status === 'available' ? 'Disponible' : 'Indisponible' }}
                            </span>

                            <!-- Remove button -->
                            <button @click="handleBuyerFavoriteDelete(fav.id)"
                                class="absolute top-3 right-3 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center text-red-400 hover:text-red-600 hover:bg-white shadow-sm transition-all duration-200 opacity-0 group-hover:opacity-100"
                                title="Retirer des favoris">
                                <i class="fas fa-heart text-xs"></i>
                            </button>

                            <!-- Negotiable tag -->
                            <span v-if="fav.product.price_negotiable"
                                class="absolute bottom-3 left-3 text-[10px] font-bold px-2 py-1 rounded-full bg-accent-light text-accent-cta uppercase tracking-wide">
                                Prix négociable
                            </span>
                        </div>

                        <!-- Card Body -->
                        <div class="flex flex-col flex-1 p-4 gap-3">

                            <!-- Category + Region -->
                            <div class="flex items-center gap-2 flex-wrap">
                                <span v-if="fav.product.category"
                                    class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                                    {{ fav.product.category.name }}
                                </span>
                                <span v-if="fav.product.region"
                                    class="text-[10px] font-semibold text-neutral-muted bg-gray-50 px-2 py-0.5 rounded-full flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-[8px]"></i>
                                    {{ fav.product.region.name }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="font-bold text-neutral-title text-sm leading-snug line-clamp-2">
                                {{ fav.product.title }}
                            </h3>

                            <!-- Price + Unit -->
                            <div class="flex items-end justify-between mt-auto">
                                <div>
                                    <p class="text-lg font-extrabold text-brand-dark leading-none">
                                        {{ formatAmount(fav.product.price) }}
                                        <small class="text-xs font-semibold text-neutral-muted"> FCFA</small>
                                    </p>
                                    <p class="text-[10px] text-neutral-muted mt-0.5">
                                        / {{ fav.product.unit }} · min. {{ fav.product.min_order_qty }} {{
                                            fav.product.unit }}
                                    </p>
                                </div>

                                <!-- Stock pill -->
                                <span
                                    class="text-[10px] font-semibold text-neutral-muted bg-gray-50 border border-gray-100 px-2 py-1 rounded-lg flex items-center gap-1">
                                    <i class="fas fa-box text-[8px]"></i>
                                    {{ fav.product.quantity }} {{ fav.product.unit }}
                                </span>
                            </div>

                            <!-- Divider -->
                            <hr class="border-gray-100" />

                            <!-- Farmer info -->
                            <div v-if="fav.product.farmer_profile" class="flex items-center gap-2">
                                <img v-if="fav.product.farmer_profile.profile_photo"
                                    :src="fav.product.farmer_profile.profile_photo"
                                    :alt="fav.product.farmer_profile.name"
                                    class="w-7 h-7 rounded-full object-cover ring-2 ring-white shadow-sm" />
                                <div v-else
                                    class="w-7 h-7 rounded-full bg-brand-dark/10 flex items-center justify-center">
                                    <i class="fas fa-user text-[10px] text-brand-dark"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[11px] font-semibold text-neutral-title truncate">
                                        <Link :href="showFarmerInfo(fav.product.id)">{{ fav.product.farmer_profile.name
                                            }}</Link>
                                    </p>
                                    <div class="flex items-center gap-0.5">
                                        <i v-for="star in 5" :key="star" :class="[
                                            'fas fa-star text-[8px]',
                                            star <= Math.round(fav.product.farmer_profile.average_rating ?? 0)
                                                ? 'text-yellow-400'
                                                : 'text-gray-200'
                                        ]"></i>
                                        <span class="text-[10px] text-neutral-muted ml-1">
                                            {{ fav.product.farmer_profile.average_rating ?? '—' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA -->
                            <Link :href="productInfo(fav.product.id)"
                                class="w-full flex items-center justify-center gap-2 bg-brand-dark hover:bg-brand-primary text-white rounded-xl py-2.5 text-xs font-bold transition-all duration-200 mt-1">
                                <i class="fas fa-eye text-[10px]"></i>
                                Voir le produit
                            </Link>
                        </div>
                    </div>
                </div>
                <div v-if="filteredFavorites.length > 0" class="flex justify-center mt-8">
                    <Pagination :meta="favorites.meta" />
                </div>
            </div>
        </main>
    </main>
</template>

<script lang="ts" setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import BuyerNavbar from "@/Components/Buyer/Navbar/BuyerNavbar.vue";
import BuyerSidebar from "@/Components/Buyer/Sidebar/BuyerSidebar.vue";
import Pagination from "@/Components/Pagination.vue";
import { buyerFavoriteDelete, catalog, productInfo, showFarmerInfo } from "@/routes";
import { formatAmount } from "@/utils/formatAmount";
// ─── Types ────────────────────────────────────────────────────────────────────

interface Category {
    id: number;
    name: string;
}

interface Region {
    id: number;
    name: string;
}

interface FarmerProfile {
    id: number;
    name: string;
    profile_photo: string | null;
    average_rating: number | null;
    reviews_count: number;
}

interface ProductImage {
    id: number;
    path: string;
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
    harvest_date: string | null;
    expires_at: string | null;
    status: string;
    category?: Category;
    region?: Region;
    farmer_profile?: FarmerProfile;
    product_images?: ProductImage[];
}

interface Favorite {
    id: number;
    user_id: number;
    product_id: number;
    product: Product;
}

interface FavoritesPageProps {
    favorites: {
        data: Favorite[];
        meta: {
            links: PaginationLink[];
        }
    };
}
interface PaginationLink {
    label?: string,
    url?: string,
    active: boolean,
}

// ─── Props ────────────────────────────────────────────────────────────────────

const props = defineProps<FavoritesPageProps>();

// ─── Sidebar ──────────────────────────────────────────────────────────────────

const buyerSidebarRef = ref<InstanceType<typeof BuyerSidebar> | null>(null);

const openSidebar = () => {
    buyerSidebarRef.value?.toggleSidebar();
};

// ─── Filters ─────────────────────────────────────────────────────────────────

const filters = [
    { label: "Tous", value: "all" },
    { label: "Disponibles", value: "available" },
    { label: "Prix négociable", value: "negotiable" },
] as const;

type FilterValue = (typeof filters)[number]["value"];

const activeFilter = ref<FilterValue>("all");

const filteredFavorites = computed<Favorite[]>(() => {
    const list = props.favorites.data;

    if (activeFilter.value === "available") {
        return list.filter((f) => f.product.status === "available");
    }

    if (activeFilter.value === "negotiable") {
        return list.filter((f) => f.product.price_negotiable);
    }

    return list;
});

// ─── Helpers ─────────────────────────────────────────────────────────────────

const handleBuyerFavoriteDelete = (favId: number) => {
    const form = useForm({
        _method: 'delete',
        favorite_id: favId
    });

    form.post(buyerFavoriteDelete.url(), {
        preserveState: true,
        preserveScroll: true,
        onError: (errors) => {
            console.log(errors)
        }
    })

}


const page = usePage();
const user = page.props.auth.user;
</script>

<style scoped>
body {
    font-family: "Inter", sans-serif;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
