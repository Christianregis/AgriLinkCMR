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
                        À Propos d'AgriLink<span class="text-brand-border">.cm</span>
                    </h1>
                    <p class="max-w-3xl mx-auto text-lg leading-relaxed md:text-xl text-brand-light/90">
                        Notre mission est de révolutionner l'agriculture au Cameroun en connectant directement les
                        producteurs et les consommateurs.
                    </p>
                </div>
            </section>

            <!-- Mission & Vision Section -->
            <section class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-2">
                    <div>
                        <h2 class="mb-6 text-3xl font-bold text-neutral-title">Notre Mission</h2>
                        <p class="text-lg text-neutral-body leading-relaxed">
                            AgriLink.cm s'engage à créer un écosystème agricole transparent et équitable. Nous mettons
                            en relation les agriculteurs locaux avec les acheteurs, éliminant les intermédiaires pour
                            garantir des prix justes pour les producteurs et des produits frais de qualité pour les
                            consommateurs. Nous croyons en une agriculture durable et en l'autonomisation de nos
                            communautés rurales.
                        </p>
                    </div>
                    <div>
                        <h2 class="mb-6 text-3xl font-bold text-neutral-title">Notre Vision</h2>
                        <p class="text-lg text-neutral-body leading-relaxed">
                            Devenir la plateforme agritech leader au Cameroun, reconnue pour son innovation, son impact
                            social et son engagement envers la sécurité alimentaire. Nous aspirons à un avenir où chaque
                            agriculteur camerounais a un accès direct au marché et où chaque citoyen peut se procurer
                            des produits agricoles frais et sains en toute simplicité.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Values Section -->
            <section class="bg-neutral-bg px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <h2 class="mb-12 text-4xl font-bold text-center text-neutral-title">Nos Valeurs Fondamentales</h2>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-brand-primary/10 rounded-full text-brand-primary text-3xl">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Équité</h3>
                        <p class="text-neutral-body">Nous garantissons des transactions justes et transparentes pour
                            tous les acteurs de la chaîne de valeur agricole.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-green-500/10 rounded-full text-green-500 text-3xl">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Qualité</h3>
                        <p class="text-neutral-body">Nous nous engageons à offrir des produits frais, sains et de la
                            plus haute qualité à nos consommateurs.</p>
                    </div>
                    <div class="p-8 bg-white rounded-2xl shadow-md text-center border border-gray-100">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto mb-6 bg-blue-500/10 rounded-full text-blue-500 text-3xl">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3 class="mb-4 text-xl font-bold text-neutral-title">Innovation</h3>
                        <p class="text-neutral-body">Nous utilisons la technologie pour simplifier l'accès au marché et
                            améliorer l'efficacité agricole.</p>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="px-4 py-20 bg-brand-dark text-white text-center">
                <div class="max-w-4xl mx-auto">
                    <h2 class="mb-6 text-3xl font-bold md:text-4xl">Rejoignez la Révolution Agricole !</h2>
                    <p class="mb-10 text-lg text-brand-light/90">
                        Que vous soyez agriculteur ou acheteur, AgriLink.cm est votre partenaire pour un avenir
                        alimentaire meilleur.
                    </p>
                    <Link :href="register()"
                        class="inline-block px-10 py-4 font-bold text-white transition-all rounded-xl bg-brand-primary hover:bg-brand-hover">
                        Commencer Maintenant
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
