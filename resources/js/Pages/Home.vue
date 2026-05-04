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

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                <!-- Product Card Loop -->
                <ProductCard v-for="product in products.data" :key="product.id" :product="product"
                    :display-mode="'grid'" />
            </div>
        </section>

        <!-- CTA SECTION -->
        <section class="px-4 py-20 bg-brand-bg">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="mb-4 text-3xl font-bold text-neutral-title">Prêt à vendre vos produits ?</h2>
                <p class="mb-8 text-lg text-neutral-muted">
                    Rejoignez des milliers d'agriculteurs et touchez des clients dans tout le Cameroun.
                </p>
                <Link :href="register()"
                    class="inline-block px-10 py-4 font-bold text-white transition-all rounded-xl bg-brand-primary hover:bg-brand-hover">
                    Devenir Vendeur
                </Link>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="px-4 py-16 bg-brand-dark">
            <div class="grid max-w-6xl grid-cols-1 gap-12 mx-auto lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <div class="flex items-center mb-4 space-x-2">
                        <div class="p-2 rounded-lg bg-brand-primary">
                            <i class="text-xl text-white fas fa-leaf"></i>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-white">AgriLink<span
                                class="text-brand-primary">.cm</span></span>
                    </div>
                    <p class="text-brand-light/70">
                        La première plateforme qui connecte directement les agriculteurs et les acheteurs au Cameroun.
                    </p>
                </div>
                <div>
                    <h3 class="mb-4 font-bold text-white">Liens Rapides</h3>
                    <ul class="space-y-2 text-brand-light/70">
                        <li><a href="#" class="hover:text-white">À Propos</a></li>
                        <li><a href="#" class="hover:text-white">Catalogue</a></li>
                        <li><a href="#" class="hover:text-white">Comment ça marche ?</a></li>
                        <li><a href="#" class="hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="mb-4 font-bold text-white">Suivez-nous</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-brand-light/70 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-brand-light/70 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-brand-light/70 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    </main>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ProductCard from '@/Components/ProductCard.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';
import { catalog, register } from '@/routes';



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

interface HomeProps {
    products: {
        data: Product[]
    };
}

defineProps<HomeProps>();

</script>

<style scoped>
.hero-gradient {
    background: linear-gradient(135deg, #1A3D3B 0%, #2D6A4F 100%);
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.07);
}
</style>
