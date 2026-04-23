<template>
  <div class="min-h-screen bg-neutral-bg flex">
    <BuyerSidebar />

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- NAVBAR -->
        <BuyerNavbar :name="user.name"/>

      <!-- PROFILE CONTENT -->
      <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto space-y-8">

          <!-- User Summary Card -->
          <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-8">
            <div class="relative group">
              <img :src="props.user.profile_photo_url || `https://ui-avatars.com/api/?name=${props.user.name}&background=2D6A4F&color=fff`" class="w-32 h-32 rounded-3xl border-4 border-[#F0FDF4] shadow-md object-cover">
              <button class="absolute -bottom-2 -right-2 w-10 h-10 bg-[#2D6A4F] text-white rounded-xl shadow-lg flex items-center justify-center hover:bg-[#40916C] transition-all">
                <i class="fas fa-camera text-sm"></i>
              </button>
            </div>
            <div class="text-center md:text-left flex-1">
              <div class="flex flex-col md:flex-row items-center gap-3 mb-2">
                <h2 class="text-3xl font-bold text-[#111827]">{{ props.user.name }}</h2>
                <span class="px-3 py-1 bg-[#FEF3C7] text-[#C77A1A] text-[10px] font-bold rounded-full uppercase tracking-wider">
                  {{ getBuyerTypeLabel(props.user.buyer_type) }}
                </span>
              </div>
              <p class="text-[#4B5563] flex items-center justify-center md:justify-start gap-2">
                <i class="fas fa-building text-[#2D6A4F]" v-if="props.user.company_name"></i> {{ props.user.company_name || 'Acheteur Particulier' }}
              </p>
              <div class="mt-6 flex flex-wrap justify-center md:justify-start gap-4">
                <button class="bg-[#2D6A4F] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#40916C] transition-all shadow-md">
                  Modifier le profil
                </button>
                <button class="border-2 border-gray-100 text-[#4B5563] px-6 py-2.5 rounded-xl font-bold hover:bg-gray-50 transition-all">
                  Changer le mot de passe
                </button>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Contact Info -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
              <h3 class="text-lg font-bold text-[#111827] mb-6 flex items-center gap-2">
                <i class="fas fa-id-card text-[#2D6A4F]"></i> Informations de contact
              </h3>
              <div class="space-y-6">
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 bg-[#F3F4F6] rounded-2xl flex items-center justify-center text-[#4B5563]"><i class="fas fa-envelope"></i></div>
                  <div>
                    <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">Email Principal</p>
                    <p class="text-sm font-semibold text-[#111827]">{{ props.user.email }}</p>
                  </div>
                </div>
                <div class="flex items-center gap-4">
                  <div class="w-12 h-12 bg-[#F3F4F6] rounded-2xl flex items-center justify-center text-[#4B5563]"><i class="fas fa-phone"></i></div>
                  <div>
                    <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">Numéro de Téléphone</p>
                    <p class="text-sm font-semibold text-[#111827]">{{ props.user.phone }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Delivery Info -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
              <h3 class="text-lg font-bold text-[#111827] mb-6 flex items-center gap-2">
                <i class="fas fa-truck text-[#2D6A4F]"></i> Adresse de livraison
              </h3>
              <div class="bg-[#F3F4F6] p-6 rounded-2xl border border-gray-100 min-h-[120px] flex flex-col justify-center">
                <div v-if="props.user.delivery_address">
                  <p class="text-sm text-[#1F2937] leading-relaxed font-medium">{{ props.user.delivery_address }}</p>
                  <p class="text-[10px] text-[#2D6A4F] font-bold uppercase mt-2 italic">Adresse par défaut</p>
                </div>
                <div v-else class="text-center">
                  <p class="text-xs text-[#4B5563] italic mb-4">Aucune adresse enregistrée</p>
                  <button class="text-[#2D6A4F] text-xs font-bold hover:underline">+ Ajouter une adresse</button>
                </div>
              </div>
            </div>

            <!-- Preferences -->
            <div class="md:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
              <h3 class="text-lg font-bold text-[#111827] mb-6">Catégories Préférées</h3>
              <div class="flex flex-wrap gap-3">
                <span v-for="cat in props.user.favorite_categories" :key="cat" class="px-5 py-2.5 bg-[#FEF3C7] text-[#C77A1A] rounded-2xl text-xs font-bold border border-[#FDE68A]">
                  # {{ cat }}
                </span>
                <button class="px-5 py-2.5 border-2 border-dashed border-gray-100 text-[#4B5563] rounded-2xl text-xs font-bold hover:border-[#2D6A4F] hover:text-[#2D6A4F] transition-all">
                  + Gérer mes préférences
                </button>
              </div>
            </div>
          </div>

          <!-- Security Alert Box -->
          <div class="bg-[#1A3D2B] p-8 rounded-3xl shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-6">
              <div class="w-16 h-16 bg-[#2D6A4F] rounded-2xl flex items-center justify-center text-white text-2xl shadow-inner">
                <i class="fas fa-shield-halved"></i>
              </div>
              <div>
                <h4 class="text-white font-bold text-lg">Sécurité du compte</h4>
                <p class="text-[#D8F3DC] text-xs">Vos informations de paiement et de contact sont protégées.</p>
              </div>
            </div>
            <button class="bg-white text-[#1A3D2B] px-6 py-3 rounded-xl font-bold text-sm hover:bg-[#F0FDF4] transition-all">
              Vérifier mon compte
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
<script setup lang="ts">
import BuyerNavbar from '@/Components/Buyer/Navbar/BuyerNavbar.vue';
import BuyerSidebar from '@/Components/Buyer/Sidebar/BuyerSidebar.vue';


interface BuyerProfile {
  id: number;
  name: string;
  email: string;
  phone: string;
  buyer_type: 'individual' | 'restaurant' | 'wholesaler' | 'institution';
  company_name?: string;
  delivery_address?: string;
  favorite_categories: string[];
  profile_photo_url?: string;
}

const props = defineProps<{
  user: BuyerProfile;
}>();

const getBuyerTypeLabel = (type: string) => {
  const labels: Record<string, string> = {
    individual: 'Particulier',
    restaurant: 'Restaurateur',
    wholesaler: 'Grossiste',
    institution: 'Institution',
  };

  return labels[type] || type;
};
</script>

<style scoped>
/* Les styles sont gérés par Tailwind CSS */
</style>
