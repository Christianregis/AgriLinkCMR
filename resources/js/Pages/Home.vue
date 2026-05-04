<template>
    <main class="antialiased">
        <AuthLayout />
        <!-- HERO SECTION -->
        <section class="relative pt-16 pb-24 overflow-hidden hero-gradient lg:pt-32 lg:pb-40">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" fill="none" viewBox="0 0 400 400">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <div class="relative z-10 px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
                <span
                    class="inline-block px-4 py-1.5 rounded-full bg-brand-hover/20 text-brand-light text-sm font-semibold mb-6 border border-brand-light/20">
                    <i class="mr-2 fas fa-star text-accent-star"></i> N°1 de l'agritech au Cameroun
                </span>
                <h1 class="mb-8 text-4xl font-extrabold leading-tight text-white md:text-6xl">
                    Du champ à votre assiette,<br />
                    <span class="text-brand-border">sans intermédiaire</span>
                </h1>
                <p class="max-w-2xl mx-auto mb-12 text-lg leading-relaxed md:text-xl text-brand-light/90">
                    Connectez-vous directement avec les meilleurs agriculteurs locaux. Produits
                    frais, prix équitables et livraison rapide garantis.
                </p>

                <!-- SEARCH BAR -->
                <div
                    class="flex flex-col items-center max-w-3xl gap-2 p-2 mx-auto bg-white shadow-2xl rounded-2xl md:flex-row">
                    <div
                        class="flex items-center flex-1 w-full px-4 py-2 border-b border-gray-100 md:border-b-0 md:border-r">
                        <i class="mr-3 text-gray-400 fas fa-search"></i>
                        <input type="text" placeholder="Que recherchez-vous ? (Ananas, Manioc, Maïs...)"
                            class="w-full bg-transparent focus:outline-none text-neutral-body" />
                    </div>
                    <div
                        class="flex items-center flex-1 w-full px-4 py-2 border-b border-gray-100 md:border-b-0 md:border-r">
                        <i class="mr-3 text-gray-400 fas fa-location-dot"></i>
                        <select class="w-full bg-transparent appearance-none focus:outline-none text-neutral-body">
                            <option>Toutes les régions</option>
                            <option>Centre (Yaoundé)</option>
                            <option>Littoral (Douala)</option>
                            <option>Ouest (Bafoussam)</option>
                        </select>
                    </div>
                    <button
                        class="w-full md:w-auto bg-accent-cta text-white px-8 py-3.5 rounded-xl font-bold hover:bg-opacity-90 transition-all flex items-center justify-center">
                        Rechercher
                    </button>
                </div>
            </div>
        </section>

        <!-- CATEGORIES QUICK FILTERS -->
        <section class="relative z-20 px-4 mx-auto -mt-10 max-w-7xl">
            <div class="grid grid-cols-2 gap-4 p-6 bg-white shadow-lg rounded-2xl md:grid-cols-5">
                <button
                    class="flex flex-col items-center p-4 transition-colors border border-transparent rounded-xl hover:bg-brand-bg group hover:border-brand-border/30">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-3 transition-transform bg-orange-100 rounded-full group-hover:scale-110">
                        <i class="text-xl text-orange-600 fas fa-apple-whole"></i>
                    </div>
                    <span class="font-semibold text-neutral-body">Fruits</span>
                </button>
                <button
                    class="flex flex-col items-center p-4 transition-colors border border-transparent rounded-xl hover:bg-brand-bg group hover:border-brand-border/30">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-3 transition-transform bg-green-100 rounded-full group-hover:scale-110">
                        <i class="text-xl text-green-600 fas fa-carrot"></i>
                    </div>
                    <span class="font-semibold text-neutral-body">Légumes</span>
                </button>
                <button
                    class="flex flex-col items-center p-4 transition-colors border border-transparent rounded-xl hover:bg-brand-bg group hover:border-brand-border/30">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-3 transition-transform bg-yellow-100 rounded-full group-hover:scale-110">
                        <i class="text-xl text-yellow-600 fas fa-wheat-awn"></i>
                    </div>
                    <span class="font-semibold text-neutral-body">Céréales</span>
                </button>
                <button
                    class="flex flex-col items-center p-4 transition-colors border border-transparent rounded-xl hover:bg-brand-bg group hover:border-brand-border/30">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-3 transition-transform bg-red-100 rounded-full group-hover:scale-110">
                        <i class="text-xl text-red-600 fas fa-drumstick-bite"></i>
                    </div>
                    <span class="font-semibold text-neutral-body">Élevage</span>
                </button>
                <button
                    class="flex flex-col items-center p-4 transition-colors border border-transparent rounded-xl hover:bg-brand-bg group hover:border-brand-border/30">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-3 transition-transform bg-blue-100 rounded-full group-hover:scale-110">
                        <i class="text-xl text-blue-600 fas fa-fish"></i>
                    </div>
                    <span class="font-semibold text-neutral-body">Pêche</span>
                </button>
            </div>
        </section>

        <!-- RECENT PRODUCTS GRID -->
        <section class="px-4 py-20 mx-auto max-w-7xl">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="mb-2 text-3xl font-bold text-neutral-title">
                        Produits Frais du Moment
                    </h2>
                    <p class="italic text-neutral-muted">Récoltés cette semaine dans nos régions</p>
                </div>
                <Link :href="catalog()" class="flex items-center font-bold text-brand-primary hover:underline">
                    Voir tout le catalogue <i class="ml-2 text-sm fas fa-arrow-right"></i>
                </Link>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-2">
                <!-- Product Card -->
                <ProductCard v-for="product in products.data" :key="product.id" :product="product" :display-mode="'grid'"/>
            </div>
        </section>

        <FooterLayout />
    </main>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import ProductCard from "@/Components/ProductCard.vue";
import { catalog } from "@/routes";
import AuthLayout from "../Layouts/AuthLayout.vue";
import FooterLayout from "../Layouts/FooterLayout.vue";

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

interface ProductsLatest {
    products: {
        data: Product[];
    }
}

defineProps<ProductsLatest>();
</script>

<style scoped>
main {
    font-family: "Inter", sans-serif;
    background-color: #f3f4f6;
    color: #1f2937;
}

.glass-nav {
    backdrop-filter: blur(12px);
    background-color: rgba(255, 255, 255, 0.8);
}

.hero-gradient {
    background: linear-gradient(135deg, #1a3d2b 0%, #2d6a4f 100%);
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
}
</style>
