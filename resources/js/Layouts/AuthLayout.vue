<template>
  <!-- NAVBAR -->
  <nav class="sticky top-0 z-50 border-b border-gray-100 glass-nav">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        <!-- Logo -->
        <div class="flex items-center space-x-2">
          <div class="p-2 rounded-lg bg-brand-primary">
            <i class="text-xl text-white fas fa-leaf"></i>
          </div>
          <span class="text-2xl font-bold tracking-tight text-brand-dark"
            >AgriLink<span class="text-brand-primary">.cm</span></span
          >
        </div>

        <!-- Desktop Menu -->
        <div class="items-center hidden space-x-8 md:flex">
          <Link :href="home()" class="font-semibold text-brand-primary">Accueil</Link>
          <a
            href="#"
            class="transition-colors text-neutral-muted hover:text-brand-primary"
            >Catalogue</a
          >
          <a
            href="#"
            class="transition-colors text-neutral-muted hover:text-brand-primary"
            >Agriculteurs</a
          >
          <a
            href="#"
            class="transition-colors text-neutral-muted hover:text-brand-primary"
            >À propos</a
          >
        </div>

        <!-- Auth Buttons -->
        <div class="items-center hidden space-x-4 md:flex">
          <Link
            :href="connexion()"
            class="px-4 py-2 font-medium text-neutral-body hover:text-brand-primary"
            >Connexion</Link
          >
          <Link
            :href="inscription()"
            class="bg-brand-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-brand-hover transition-all shadow-sm hover:shadow-md"
            >Rejoindre</Link
          >
        </div>

        <!-- Mobile menu button -->
        <div class="flex items-center md:hidden">
          <button class="p-2 text-neutral-body hover:text-brand-primary">
            <i class="text-2xl fas fa-bars"></i>
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>
<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { connexion } from "@/routes";
import { inscription } from "@/routes";
import { home } from "@/routes";
</script>
