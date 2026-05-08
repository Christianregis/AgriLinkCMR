<template>
    <AuthLayout/>
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
                        Politiques de <span class="text-brand-border">Confidentialité & Paiements</span>
                    </h1>
                    <p class="max-w-3xl mx-auto text-lg leading-relaxed md:text-xl text-brand-light/90">
                        Votre confiance est notre priorité. Découvrez comment nous protégeons vos données et sécurisons
                        vos transactions.
                    </p>
                </div>
            </section>

            <!-- Policies Content Section -->
            <section class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                    <!-- Sidebar Navigation -->
                    <nav class="lg:col-span-1">
                        <ul class="space-y-4">
                            <li>
                                <a href="#confidentialite"
                                    class="block px-4 py-2 text-lg font-semibold text-brand-primary bg-brand-primary/10 rounded-lg hover:bg-brand-primary/20 transition-colors">
                                    Politique de Confidentialité
                                </a>
                            </li>
                            <li>
                                <a href="#paiements"
                                    class="block px-4 py-2 text-lg font-semibold text-neutral-title hover:text-brand-primary hover:bg-brand-primary/10 rounded-lg transition-colors">
                                    Politique de Gestion des Paiements
                                </a>
                            </li>
                            <li>
                                <a href="#conditions"
                                    class="block px-4 py-2 text-lg font-semibold text-neutral-title hover:text-brand-primary hover:bg-brand-primary/10 rounded-lg transition-colors">
                                    Conditions Générales d'Utilisation
                                </a>
                            </li>
                        </ul>
                    </nav>

                    <!-- Main Content Area -->
                    <div class="lg:col-span-2 space-y-12">
                        <!-- Confidentiality Policy -->
                        <article id="confidentialite"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h2 class="mb-6 text-3xl font-bold text-neutral-title">Politique de Confidentialité</h2>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Chez AgriLink.cm, nous nous engageons à protéger la vie privée de nos utilisateurs.
                                Cette politique explique comment nous collectons, utilisons, divulguons et protégeons
                                vos informations personnelles.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">1. Collecte des Informations</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Nous collectons des informations que vous nous fournissez directement, telles que votre
                                nom, adresse e-mail, numéro de téléphone, adresse de livraison, et informations de
                                paiement lors de l'inscription, de la passation de commandes ou de l'utilisation de nos
                                services.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">2. Utilisation des Informations</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Vos informations sont utilisées pour traiter vos commandes, améliorer nos services,
                                personnaliser votre expérience, communiquer avec vous et assurer la sécurité de notre
                                plateforme. Nous ne vendons ni ne louons vos informations personnelles à des tiers.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">3. Partage des Informations</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Nous pouvons partager vos informations avec des partenaires de confiance (par exemple,
                                les agriculteurs pour la livraison, les prestataires de services de paiement) uniquement
                                dans le cadre de l'exécution de nos services et sous des accords de confidentialité
                                stricts.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">4. Sécurité des Données</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles robustes
                                pour protéger vos données contre l'accès non autorisé, la modification, la divulgation
                                ou la destruction.
                            </p>
                        </article>

                        <!-- Payment Management Policy -->
                        <article id="paiements"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h2 class="mb-6 text-3xl font-bold text-neutral-title">Politique de Gestion des Paiements
                            </h2>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                AgriLink.cm assure la sécurité et la transparence de toutes les transactions financières
                                effectuées sur notre plateforme.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">1. Modes de Paiement</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Nous acceptons plusieurs modes de paiement sécurisés, y compris Mobile Money (Orange
                                Money, MTN Mobile Money) et les paiements en espèces à la livraison ou à la
                                récupération. D'autres options comme les cartes bancaires (via Stripe) pourront être
                                ajoutées ultérieurement.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">2. Sécurité des Transactions</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Toutes les transactions électroniques sont cryptées et traitées par des prestataires de
                                services de paiement certifiés. AgriLink.cm ne stocke pas directement vos informations
                                de carte bancaire.
                            </p>
                            <h3 class="mb-3 text-xl font-bold text-neutral-title">3. Litiges et Remboursements</h3>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                En cas de litige ou de problème avec une commande, notre service client est disponible
                                pour vous assister. Les politiques de remboursement sont définies au cas par cas, en
                                fonction de la nature du problème et des conditions de vente spécifiques du produit.
                            </p>
                        </article>

                        <!-- General Terms of Use (Placeholder) -->
                        <article id="conditions"
                            class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h2 class="mb-6 text-3xl font-bold text-neutral-title">Conditions Générales d'Utilisation
                            </h2>
                            <p class="mb-4 text-neutral-body leading-relaxed">
                                Cette section détaillera les termes et conditions régissant l'utilisation de la
                                plateforme AgriLink.cm par les agriculteurs et les acheteurs. Elle couvrira les droits
                                et obligations de chaque partie, les règles de conduite, les responsabilités et les
                                limitations de responsabilité.
                            </p>
                            <p class="text-neutral-body leading-relaxed">
                                (Contenu détaillé à venir, veuillez consulter cette section régulièrement pour les mises
                                à jour.)
                            </p>
                        </article>
                    </div>
                </div>
            </section>
        </main>
        <FooterLayout />
</template>

<script setup lang="ts">
import AuthLayout from "@/Layouts/AuthLayout.vue";
import FooterLayout from "@/Layouts/FooterLayout.vue";
</script>

<style scoped>
.hero-gradient {
    background: linear-gradient(135deg, #1A3D3B 0%, #2D6A4F 100%);
}
</style>
