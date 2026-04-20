<template>
  <main class="min-h-screen px-4 py-12 antialiased bg-neutral-bg">
    <div class="max-w-2xl mx-auto">
      <div class="mb-10 text-center">
        <Link :href="home()" class="inline-flex items-center mb-6 space-x-2">
          <div class="p-2 rounded-lg bg-brand-primary">
            <i class="text-xl text-white fas fa-leaf"></i>
          </div>
          <span class="text-2xl font-bold tracking-tight text-brand-dark">
            AgriLink<span class="text-brand-primary">.cm</span>
          </span>
        </Link>
        <h1 class="text-3xl font-bold text-neutral-title">Mot de passe oublié ?</h1>
        <p class="mt-2 text-neutral-muted">
          Entrez votre adresse e-mail pour réinitialiser votre mot de passe.
        </p>
      </div>

      <div class="overflow-hidden bg-white border border-gray-100 shadow-xl rounded-2xl">
        <form @submit.prevent="handleSubmit" class="p-8 space-y-6">
          <div>
            <label class="block mb-2 text-sm font-semibold text-neutral-title">Adresse Email</label>
            <input
              v-model="form.email"
              type="email"
              placeholder="votre@email.com"
              required
              class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
            />
          </div>

          <button
            type="submit"
            class="w-full py-4 font-bold text-white transition-all shadow-md bg-brand-primary rounded-xl hover:bg-brand-hover hover:shadow-lg"
          >
            Réinitialiser le mot de passe
          </button>
        </form>
      </div>

      <p class="mt-8 text-center text-neutral-body">
        <Link :href="connexion()" class="font-bold text-brand-primary hover:underline">
          Retour à la connexion
        </Link>
      </p>
    </div>
  </main>
</template>

<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { connexion } from '@/routes';
import { home } from '@/routes';

const form = useForm({
  email: ''
});

const handleSubmit = () => {
  console.log('Password reset requested for:', form.email);
  // Logic for password reset submission would go here
};
</script>
