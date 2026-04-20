<template>
  <main
    class="flex flex-col items-center justify-center min-h-screen p-4 antialiased bg-neutral-bg"
  >
    <FlashMessage />
    <!-- Logo -->
    <Link :href="home()" class="flex items-center mb-8 space-x-2">
      <div class="p-2 rounded-lg bg-brand-primary">
        <i class="text-xl text-white fas fa-leaf"></i>
      </div>
      <span class="text-2xl font-bold tracking-tight text-brand-dark"
        >AgriLink<span class="text-brand-primary">.cm</span></span
      >
    </Link>

    <!-- LOGIN CARD -->
    <div
      class="w-full max-w-md overflow-hidden bg-white border border-gray-100 shadow-xl rounded-2xl"
    >
      <div class="p-8">
        <h1 class="mb-2 text-2xl font-bold text-neutral-title">Bon retour !</h1>
        <p class="mb-8 text-neutral-muted">Accédez à votre espace AgriLink</p>

        <form @submit.prevent="handleLogin()" class="space-y-6">
          <div>
            <label class="block mb-2 text-sm font-semibold text-neutral-title"
              >Adresse Email</label
            >
            <div class="relative">
              <span
                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"
              >
                <i class="far fa-envelope"></i>
              </span>
              <input
                required
                type="email"
                v-model="form.email"
                placeholder="votre@email.com"
                class="w-full py-3 pl-10 pr-4 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary text-neutral-body"
              />
              <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">
                {{ form.errors.email }}
              </p>
            </div>
          </div>

          <div>
            <div class="flex justify-between mb-2">
              <label class="text-sm font-semibold text-neutral-title">Mot de passe</label>
              <Link
                :href="showForgotpPassword()"
                class="text-sm font-medium text-brand-primary hover:underline"
                >Oublié ?</Link
              >
            </div>
            <div class="relative">
              <span
                class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"
              >
                <i class="fas fa-lock"></i>
              </span>
              <input
                type="password"
                v-model="form.password"
                placeholder="••••••••"
                class="w-full py-3 pl-10 pr-10 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary text-neutral-body"
              />
              <p v-if="form.errors.password" class="mt-1 text-sm text-red-500">
                {{ form.errors.password }}
              </p>
              <button
                type="button"
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-brand-primary"
              >
                <i class="far fa-eye"></i>
              </button>
            </div>
          </div>

          <div class="flex items-center">
            <input
              type="checkbox"
              id="remember"
              class="w-5 h-5 border-gray-300 rounded cursor-pointer text-brand-primary focus:ring-brand-primary"
            />
            <label for="remember" class="ml-3 text-sm cursor-pointer text-neutral-muted"
              >Se souvenir de moi</label
            >
          </div>

          <button
            type="submit"
            class="w-full bg-brand-primary text-white py-3.5 rounded-xl font-bold hover:bg-brand-hover transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2"
          >
            Connexion <i class="text-sm fas fa-arrow-right"></i>
          </button>
        </form>
      </div>

      <div class="p-6 text-center border-t border-gray-100 bg-brand-bg/50">
        <p class="text-sm text-neutral-body">
          Nouveau sur AgriLink ?
          <Link :href="inscription()" class="font-bold text-brand-primary hover:underline"
            >Créer un compte</Link
          >
        </p>
      </div>
    </div>

    <p class="mt-8 mb-3 text-xs text-neutral-muted">
      &copy; 2026 AgriLink Cameroun. Sécurisé par SSL.
    </p>
  </main>
</template>
<script setup lang="ts">
import { Link, useForm } from "@inertiajs/vue3";
import { inscription } from "@/routes";
import { home } from "@/routes";
import { showForgotpPassword } from "@/routes";
import FlashMessage from "../../Components/FlashMessage.vue";

interface Form {
  email: string;
  password: string;
}

const form = useForm<Form>({
  email: "",
  password: "",
});

const handleLogin = () => {
  form.post("/login", {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>
