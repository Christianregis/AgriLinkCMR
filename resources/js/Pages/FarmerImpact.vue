<template>
    <AuthLayout />
        <main class="antialiased">
            <!-- Hero Section -->
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
                    <h1 class="mb-8 text-4xl font-extrabold leading-tight text-white md:text-6xl">
                        L'Impact de nos <span class="text-brand-border">Agriculteurs</span>
                    </h1>
                    <p class="max-w-3xl mx-auto text-lg leading-relaxed md:text-xl text-brand-light/90">
                        Découvrez comment les agriculteurs transforment l'agriculture camerounaise grâce à AgriLink.cm.
                    </p>
                </div>
            </section>

            <!-- Impact Section -->
            <section class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h2 class="mb-12 text-4xl font-bold text-center text-neutral-title">Une Communauté qui Cultive l'Avenir</h2>
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-yellow-500/10 rounded-full text-yellow-500 text-3xl">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Accès Direct au Marché</h3>
                        <p class="text-neutral-body">AgriLink.cm offre aux agriculteurs une plateforme pour vendre leurs produits directement aux consommateurs, éliminant les intermédiaires et augmentant leurs revenus.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-500/10 rounded-full text-blue-500 text-3xl">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Croissance Économique</h3>
                        <p class="text-neutral-body">En facilitant les transactions, nous contribuons à la croissance économique des régions rurales et à l'amélioration des conditions de vie des familles d'agriculteurs.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-green-500/10 rounded-full text-green-500 text-3xl">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Autonomisation</h3>
                        <p class="text-neutral-body">Nous donnons aux agriculteurs les outils et la visibilité nécessaires pour gérer leur activité, prendre des décisions éclairées et se développer.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-purple-500/10 rounded-full text-purple-500 text-3xl">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Communauté et Partage</h3>
                        <p class="text-neutral-body">AgriLink.cm favorise les échanges entre agriculteurs et acheteurs, créant une communauté solidaire autour de l'alimentation locale.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-orange-500/10 rounded-full text-orange-500 text-3xl">
                            <i class="fas fa-globe-africa"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Développement Durable</h3>
                        <p class="text-neutral-body">En valorisant les circuits courts, nous réduisons l'empreinte carbone et soutenons des pratiques agricoles respectueuses de l'environnement.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-red-500/10 rounded-full text-red-500 text-3xl">
                            <i class="fas fa-hand-holding-heart"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Sécurité Alimentaire</h3>
                        <p class="text-neutral-body">Nos agriculteurs sont au cœur de la garantie d'un accès à des produits frais et sains pour tous les Camerounais.</p>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="px-4 py-20 bg-brand-dark text-white text-center">
                <div class="max-w-4xl mx-auto">
                    <h2 class="mb-6 text-3xl font-bold md:text-4xl">Vous êtes Agriculteur ? Rejoignez-nous !</h2>
                    <p class="mb-10 text-lg text-brand-light/90">
                        Faites partie de cette révolution et donnez une nouvelle dimension à votre production.
                    </p>
                    <Link :href="register()"
                        class="inline-block px-10 py-4 font-bold text-white transition-all rounded-xl bg-brand-primary hover:bg-brand-hover">
                        Devenir Vendeur
                    </Link>
                </div>
            </section>
        </main>
        <FooterLayout />
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import AuthLayout from "@/Layouts/AuthLayout.vue";
import FooterLayout from "@/Layouts/FooterLayout.vue";
import { register } from "@/routes";

</script>

<style scoped>
.hero-gradient {
    background: linear-gradient(135deg, #1A3D3B 0%, #2D6A4F 100%);
}
</style>
