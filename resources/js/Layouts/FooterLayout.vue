<template>
  <!-- FOOTER -->
  <footer class="pt-20 pb-10 text-white bg-brand-dark">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 gap-12 mb-16 md:grid-cols-4">
        <div class="col-span-1 md:col-span-1">
          <div class="flex items-center mb-6 space-x-2">
            <div class="p-2 rounded-lg bg-brand-primary">
              <i class="text-xl text-white fas fa-leaf"></i>
            </div>
            <span class="text-2xl font-bold tracking-tight"
              >AgriLink<span class="text-brand-primary">.cm</span></span
            >
          </div>
          <p class="mb-6 leading-relaxed text-brand-light/70">
            La première plateforme qui valorise le travail des agriculteurs camerounais en
            les connectant directement aux consommateurs.
          </p>
          <div class="flex space-x-4">
            <a
              href="#"
              class="flex items-center justify-center w-10 h-10 transition-colors rounded-full bg-brand-primary/20 hover:bg-brand-primary"
            >
              <i class="fab fa-facebook-f"></i>
            </a>
            <a
              href="#"
              class="flex items-center justify-center w-10 h-10 transition-colors rounded-full bg-brand-primary/20 hover:bg-brand-primary"
            >
              <i class="fab fa-whatsapp"></i>
            </a>
            <a
              href="#"
              class="flex items-center justify-center w-10 h-10 transition-colors rounded-full bg-brand-primary/20 hover:bg-brand-primary"
            >
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>

        <div>
          <h4 class="mb-6 text-lg font-bold">Navigation</h4>
          <ul class="space-y-4 text-brand-light/70">
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Catalogue complet</a
              >
            </li>
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Comment ça marche</a
              >
            </li>
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Devenir vendeur</a
              >
            </li>
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Aide & FAQ</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h4 class="mb-6 text-lg font-bold">Légal</h4>
          <ul class="space-y-4 text-brand-light/70">
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Conditions Générales</a
              >
            </li>
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Politique de Confidentialité</a
              >
            </li>
            <li>
              <a href="#" class="transition-colors hover:text-brand-primary"
                >Mentions Légales</a
              >
            </li>
          </ul>
        </div>

        <div>
          <h4 class="mb-6 text-lg font-bold">Newsletter</h4>
          <p class="mb-4 text-brand-light/70">
            Recevez nos meilleures offres et actualités agricoles.
          </p>
          <form class="flex flex-col gap-3">
            <input
              type="email"
              placeholder="votre@email.com"
              class="bg-brand-primary/10 border border-brand-primary/30 rounded-lg px-4 py-2.5 focus:outline-none focus:border-brand-primary text-white"
            />
            <button
              class="bg-brand-primary hover:bg-brand-hover text-white font-bold py-2.5 rounded-lg transition-all"
            >
              S'abonner
            </button>
          </form>
        </div>
      </div>

      <div
        class="pt-8 text-sm text-center border-t border-brand-primary/20 text-brand-light/50"
      ></div>
    </div>
  </footer>
</template>
