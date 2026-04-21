<script setup lang="ts">

interface FarmerProfile {
  id: number;
  name: string;
  email: string;
  phone: string;
  region: string;
  village: string;
  culture_types: string[];
  bio: string;
  profile_photo?: string;
  average_rating: number;
  total_sales: number;
}

const props = defineProps<{
  user: FarmerProfile;
}>();
</script>

<template>
  <div class="min-h-screen bg-[#F3F4F6] flex">
    <!-- SIDEBAR (Identique au Dashboard) -->
    <aside class="hidden lg:flex flex-col w-72 bg-white border-r border-gray-100 sticky top-0 h-screen z-40">
      <div class="p-8 border-b border-gray-50">
        <div class="flex items-center space-x-2">
          <div class="bg-[#2D6A4F] p-2 rounded-lg"><i class="fas fa-leaf text-white text-xl"></i></div>
          <span class="text-2xl font-bold text-[#1A3D2B] tracking-tight">AgriLink<span class="text-[#2D6A4F]">.cm</span></span>
        </div>
      </div>
      <nav class="flex-1 p-6 space-y-2">
        <div class="text-[10px] font-bold uppercase tracking-widest text-[#4B5563] mb-4 px-4">Menu Agriculteur</div>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-[#1F2937] hover:bg-[#F0FDF4] hover:text-[#2D6A4F] transition-all group">
          <i class="fas fa-chart-line w-5 text-center text-[#4B5563] group-hover:text-[#2D6A4F]"></i> <span class="font-medium">Vue d'ensemble</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-[#1F2937] hover:bg-[#F0FDF4] hover:text-[#2D6A4F] transition-all group">
          <i class="fas fa-box w-5 text-center text-[#4B5563] group-hover:text-[#2D6A4F]"></i> <span class="font-medium">Mes Produits</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl bg-[#2D6A4F] text-white font-semibold shadow-lg shadow-[#2D6A4F]/20">
          <i class="fas fa-user-circle w-5 text-center"></i> <span>Mon Profil</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl text-[#1F2937] hover:bg-[#F0FDF4] hover:text-[#2D6A4F] transition-all group">
          <i class="fas fa-cog w-5 text-center text-[#4B5563] group-hover:text-[#2D6A4F]"></i> <span class="font-medium">Paramètres</span>
        </a>
      </nav>
      <div class="p-6 border-t border-gray-50">
        <button class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 transition-all font-semibold">
          <i class="fas fa-sign-out-alt w-5 text-center"></i> <span>Déconnexion</span>
        </button>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- HEADER -->
      <header class="h-20 bg-white/80 backdrop-blur-md border-b border-gray-100 flex items-center justify-between px-8 sticky top-0 z-30">
        <div class="flex items-center">
          <button class="lg:hidden text-[#1F2937] mr-4"><i class="fas fa-bars text-xl"></i></button>
          <h1 class="text-xl font-bold text-[#111827]">Mon Profil Agriculteur</h1>
        </div>
        <div class="flex items-center space-x-6">
          <div class="flex items-center space-x-3 pl-6 border-l border-gray-100">
            <div class="text-right hidden sm:block">
              <p class="text-sm font-bold text-[#111827]">{{ props.user.name }}</p>
              <p class="text-[10px] font-bold text-[#2D6A4F] uppercase tracking-wider">Producteur</p>
            </div>
            <img :src="props.user.profile_photo || `https://ui-avatars.com/api/?name=${props.user.name}&background=2D6A4F&color=fff`" class="w-11 h-11 rounded-xl shadow-sm border border-gray-100">
          </div>
        </div>
      </header>

      <!-- PROFILE CONTENT -->
      <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-5xl mx-auto space-y-8">

          <!-- Banner & Quick Info -->
          <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="h-32 bg-gradient-to-r from-[#1A3D2B] to-[#2D6A4F] relative">
              <button class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-xl text-xs font-bold backdrop-blur-md transition-all">
                <i class="fas fa-camera mr-2"></i> Modifier la bannière
              </button>
            </div>
            <div class="px-8 pb-8 flex flex-col md:flex-row items-end -mt-12 gap-6">
              <div class="relative group">
                <img :src="props.user.profile_photo || `https://ui-avatars.com/api/?name=${props.user.name}&background=2D6A4F&color=fff`" class="w-32 h-32 rounded-3xl border-4 border-white shadow-xl object-cover bg-white">
                <button class="absolute inset-0 bg-black/40 rounded-3xl opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-all">
                  <i class="fas fa-pencil-alt"></i>
                </button>
              </div>
              <div class="flex gap-4 pb-2">
                <div class="text-center px-6 border-r border-gray-100">
                  <p class="text-2xl font-bold text-[#111827]">{{ props.user.average_rating }}</p>
                  <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-widest">Note Moyenne</p>
                </div>
                <div class="text-center px-6">
                  <p class="text-2xl font-bold text-[#111827]">{{ props.user.total_sales }}</p>
                  <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-widest">Total vendus</p>
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Detailed Info -->
            <div class="lg:col-span-2 space-y-8">
              <!-- Bio -->
              <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                  <h3 class="text-lg font-bold text-[#111827]">À propos de la ferme</h3>
                  <button class="text-[#2D6A4F] hover:bg-[#F0FDF4] p-2 rounded-lg transition-all"><i class="fas fa-edit"></i></button>
                </div>
                <p class="text-[#1F2937] leading-relaxed italic text-sm">"{{ props.user.bio }}"</p>
              </div>

              <!-- Cultures -->
              <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-[#111827] mb-6">Spécialités & Cultures</h3>
                <div class="flex flex-wrap gap-3">
                  <span v-for="culture in props.user.culture_types" :key="culture" class="px-4 py-2 bg-[#F0FDF4] text-[#2D6A4F] rounded-xl text-sm font-semibold border border-[#D8F3DC]">
                    <i class="fas fa-check-circle mr-2 opacity-50"></i> {{ culture }}
                  </span>
                  <button class="px-4 py-2 border-2 border-dashed border-gray-200 text-[#4B5563] rounded-xl text-sm font-medium hover:border-[#2D6A4F] hover:text-[#2D6A4F] transition-all">
                    + Ajouter une culture
                  </button>
                </div>
              </div>
            </div>

            <!-- Right Column: Contact & Security -->
            <div class="space-y-8">
              <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-[#111827] mb-6">Coordonnées</h3>
                <div class="space-y-4">
                  <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-[#F3F4F6] rounded-xl flex items-center justify-center text-[#4B5563]"><i class="fas fa-envelope"></i></div>
                    <div>
                      <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">Email</p>
                      <p class="text-sm font-semibold text-[#111827]">{{ props.user.email }}</p>
                    </div>
                  </div>
                  <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-[#F3F4F6] rounded-xl flex items-center justify-center text-[#4B5563]"><i class="fas fa-phone"></i></div>
                    <div>
                      <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">Téléphone</p>
                      <p class="text-sm font-semibold text-[#111827]">{{ props.user.phone }}</p>
                    </div>
                  </div>
                </div>
                <button class="w-full mt-8 bg-[#2D6A4F] text-white py-3.5 rounded-xl font-bold hover:bg-[#40916C] transition-all shadow-md">
                  Mettre à jour les infos
                </button>
              </div>

              <div class="bg-brand-bg p-8 rounded-3xl border border-brand-light">
                <h3 class="text-md font-bold text-brand-dark mb-2">Compte Certifié</h3>
                <p class="text-xs text-brand-primary leading-relaxed mb-4">Votre profil est visible par tous les acheteurs de la plateforme AgriLink Cameroun.</p>
                <div class="flex items-center gap-2 text-brand-primary font-bold text-xs">
                  <i class="fas fa-shield-alt"></i> Données sécurisées
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
/* Les styles sont gérés par Tailwind CSS */
</style>
