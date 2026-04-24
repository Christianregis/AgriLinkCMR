<template>
  <div class="min-h-screen bg-neutral-bg flex">
    <!-- Assuming BuyerSidebar and BuyerNavbar are imported and correctly configured -->
    <BuyerSidebar />

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <BuyerNavbar :name="user.name" :profile_photo="user.profile_photo_url" />

      <!-- PROFILE EDIT CONTENT -->
      <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-4xl mx-auto space-y-8">
          <h1 class="text-3xl font-bold text-neutral-title mb-6">Modifier mon profil</h1>

          <form @submit.prevent="handleSubmit" class="space-y-8">
            <!-- User Summary Card - Editable Profile Photo -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row items-center gap-8">
              <div class="relative group">
                <img
                  :src="form.profile_photo_preview || user.profile_photo_url || `https://ui-avatars.com/api/?name=${user.name}&background=2D6A4F&color=fff`"
                  class="w-32 h-32 rounded-3xl border-4 border-green-100 shadow-md object-cover"
                  alt="Profile Photo"
                />
                <label for="profile-photo-upload"
                  class="absolute -bottom-2 -right-2 w-10 h-10 bg-brand-primary text-white rounded-xl shadow-lg flex items-center justify-center hover:bg-brand-hover transition-all cursor-pointer"
                >
                  <i class="fas fa-camera text-sm"></i>
                  <input
                    id="profile-photo-upload"
                    type="file"
                    accept="image/*"
                    @change="handleFileChange"
                    class="hidden"
                  />
                </label>
              </div>
              <div class="text-center md:text-left flex-1">
                <div class="flex flex-col md:flex-row items-center gap-3 mb-2">
                  <h2 class="text-3xl font-bold text-neutral-title">{{ user.name }}</h2>
                </div>
                <p class="text-neutral-muted flex items-center justify-center md:justify-start gap-2">
                  <i class="fas fa-building text-brand-primary" v-if="user.company_name"></i>
                  {{ user.company_name || 'Acheteur Particulier' }}
                </p>
              </div>
            </div>

            <!-- Personal Information -->
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
              <h3 class="text-lg font-bold text-neutral-title mb-6 flex items-center gap-2">
                <i class="fas fa-user text-brand-primary"></i> Informations personnelles
              </h3>
              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                  <label class="block mb-2 text-sm font-semibold text-neutral-title">Nom complet</label>
                  <input
                    v-model="form.name"
                    type="text"
                    placeholder="Jean Dupont"
                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                  />
                  <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">{{ form.errors.name }}</p>
                </div>
                <div>
                  <label class="block mb-2 text-sm font-semibold text-neutral-title">Téléphone</label>
                  <input
                    v-model="form.phone"
                    type="tel"
                    placeholder="+237 6xx xxx xxx"
                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                  />
                  <p v-if="form.errors.phone" class="mt-1 text-sm text-red-500">{{ form.errors.phone }}</p>
                </div>
              </div>
              <div>
                <label class="block mb-2 text-sm font-semibold text-neutral-title">Adresse Email</label>
                <input
                  v-model="form.email"
                  type="email"
                  placeholder="votre@email.com"
                  class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                />
                <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">{{ form.errors.email }}</p>
              </div>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 space-y-6">
              <h3 class="text-lg font-bold text-neutral-title mb-6 flex items-center gap-2">
                <i class="fas fa-shopping-basket text-brand-primary"></i> Informations Acheteur
              </h3>
              <div>
                <label class="block mb-2 text-sm font-semibold text-neutral-title">Type d'acheteur</label>
                <select
                  v-model="form.buyer_type"
                  class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                >
                  <option value="person">Particulier</option>
                  <option value="company">Entreprise</option>
                  <option value="institution">Institution</option>
                  <option value="other">Autre</option>
                </select>
                <p v-if="form.errors.buyer_type" class="mt-1 text-sm text-red-500">{{ form.errors.buyer_type }}</p>
              </div>
              <div>
                <label class="block mb-2 text-sm font-semibold text-neutral-title">Nom de l'entreprise (optionnel)</label>
                <input
                  v-model="form.company_name"
                  type="text"
                  placeholder="Ma Boutique Sarl"
                  class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                />
                <p v-if="form.errors.company_name" class="mt-1 text-sm text-red-500">{{ form.errors.company_name }}</p>
              </div>
              <div>
                <label class="block mb-2 text-sm font-semibold text-neutral-title">Adresse de livraison</label>
                <textarea
                  v-model="form.delivery_address"
                  rows="3"
                  placeholder="Votre adresse de livraison par défaut..."
                  class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                ></textarea>
                <p v-if="form.errors.delivery_address" class="mt-1 text-sm text-red-500">{{ form.errors.delivery_address }}</p>
              </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end">
              <button
                type="submit"
                class="py-3 px-8 font-bold text-white bg-brand-primary rounded-xl hover:bg-brand-hover transition-all shadow-md"
              >
                Enregistrer les modifications
              </button>
            </div>
          </form>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import BuyerNavbar from '@/Components/Buyer/Navbar/BuyerNavbar.vue';
import BuyerSidebar from '@/Components/Buyer/Sidebar/BuyerSidebar.vue';
import { buyerProfileUpdate } from '@/routes';

// Type definitions
interface RegionData {
  id: string;
  name: string;
  code: string;
  country: string;
}

interface UserProfile {
  id: number;
  name: string;
  email: string;
  phone: string;
  buyer_type?: 'person' | 'company' | 'institution' | 'other';
  company_name?: string;
  delivery_address?: string;
  profile_photo_url?: string;
  region_id?: string;
  village?: string;
  cultures?: string;
  bio?: string;
}

interface EditProfileProps {
  user: {
    data: UserProfile;
  };
  regions?: { // Regions might only be available for farmer profiles
    data: RegionData[];
  };
}

interface EditFormData {
  _method: 'put'; // For Inertia PUT request
  name: string;
  phone: string;
  email: string;
  buyer_type?: 'person' | 'company' | 'institution' | 'other';
  company_name?: string;
  delivery_address?: string;
  profile_photo: File | null;
  profile_photo_preview: string | null; // For displaying local image preview
}

// Props
const props = defineProps<EditProfileProps>();
const user = props.user.data;

// Form data using Inertia's useForm
const form = useForm<EditFormData>({
  _method: 'put',
  name: user.name,
  phone: user.phone,
  email: user.email,
  buyer_type: user.buyer_type,
  company_name: user.company_name,
  delivery_address: user.delivery_address,
  profile_photo: null,
  profile_photo_preview: user.profile_photo_url || null,
});


const handleFileChange = (e: Event) => {
  const target = e.target as HTMLInputElement;

  if (target.files && target.files[0]) {
    const file = target.files[0];
    form.profile_photo = file;
    form.profile_photo_preview = URL.createObjectURL(file); // Create a URL for local preview
  }
};

const handleSubmit = () => {

  form.post(buyerProfileUpdate.url(), {
    onSuccess: () => {
      console.log('Profile updated successfully!');
      // Optionally, refresh the page or show a success message
    },
    onError: (errors) => {
      console.error('Error updating profile:', errors);
      // Handle errors, e.g., display them next to fields
    },
    forceFormData: true, // Important for file uploads
  });
};
</script>

<style scoped>
</style>
