<template>
  <div class="min-h-screen bg-neutral-bg flex">
    <FarmerSidebar />

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <FarmerNavbar :name="user.name" />

      <!-- PROFILE EDIT CONTENT -->
      <div class="flex-1 overflow-y-auto p-8">
        <div class="max-w-5xl mx-auto space-y-8">
          <h1 class="text-3xl font-bold text-neutral-title mb-6">Modifier mon profil Agriculteur</h1>

          <form @submit.prevent="handleSubmit" class="space-y-8">
            <!-- Banner & Profile Photo Section -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
              <div class="h-32 bg-linear-to-r from-brand-dark to-brand-primary relative">
                <label for="banner-upload"
                  class="absolute top-4 right-4 bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-xl text-xs font-bold backdrop-blur-md transition-all cursor-pointer"
                >
                  <i class="fas fa-camera mr-2"></i> Modifier la bannière
                  <input
                    id="banner-upload"
                    type="file"
                    accept="image/*"
                    @change="handleBannerChange"
                    class="hidden"
                  />
                </label>
                <img v-if="form.banner_photo_preview" :src="form.banner_photo_preview" alt="Banner Preview" class="absolute inset-0 w-full h-full object-cover" />
              </div>
              <div class="px-8 pb-8 flex flex-col md:flex-row items-end -mt-12 gap-6">
                <div class="relative group">
                  <img
                    :src="form.profile_photo_preview || user.profile_photo_url || `https://ui-avatars.com/api/?name=${user.name}&background=2D6A4F&color=fff`"
                    class="w-32 h-32 rounded-3xl border-4 border-white shadow-xl object-cover bg-white"
                    alt="Profile Photo"
                  />
                  <label for="profile-photo-upload"
                    class="absolute inset-0 bg-black/40 rounded-3xl opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-all cursor-pointer"
                  >
                    <i class="fas fa-pencil-alt"></i>
                    <input
                      id="profile-photo-upload"
                      type="file"
                      accept="image/*"
                      @change="handleProfilePhotoChange"
                      class="hidden"
                    />
                  </label>
                </div>
                <div class="flex gap-4 pb-2">
                  <div class="text-center px-6 border-r border-gray-100">
                    <p class="text-2xl font-bold text-neutral-title">{{ user.average_rating }}</p>
                    <p class="text-[10px] font-bold text-neutral-muted uppercase tracking-widest">Note Moyenne</p>
                  </div>
                  <div class="text-center px-6">
                    <p class="text-2xl font-bold text-neutral-title">{{ user.total_sales }}</p>
                    <p class="text-[10px] font-bold text-neutral-muted uppercase tracking-widest">Total vendus</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
              <!-- Left Column: Detailed Info -->
              <div class="lg:col-span-2 space-y-8">
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
                        placeholder="Nom de la ferme ou de l'agriculteur"
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

                <!-- Bio -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                  <h3 class="text-lg font-bold text-neutral-title mb-6 flex items-center gap-2">
                    <i class="fas fa-seedling text-brand-primary"></i> À propos de ma ferme
                  </h3>
                  <textarea
                    v-model="form.bio"
                    rows="5"
                    placeholder="Décrivez votre ferme, vos valeurs, vos méthodes de culture..."
                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                  ></textarea>
                  <p v-if="form.errors.bio" class="mt-1 text-sm text-red-500">{{ form.errors.bio }}</p>
                </div>

                <!-- Cultures -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                  <h3 class="text-lg font-bold text-neutral-title mb-6 flex items-center gap-2">
                    <i class="fas fa-carrot text-brand-primary"></i> Spécialités & Cultures
                  </h3>
                  <div class="flex flex-wrap gap-3">
                    <span v-for="culture in form.culture_types" :key="culture"
                      class="px-4 py-2 bg-green-100 text-brand-primary rounded-xl text-sm font-semibold border border-green-200"
                    >
                      <i class="fas fa-check-circle mr-2 opacity-50"></i> {{ culture }}
                    </span>
                    <input
                      type="text"
                      v-model="newCulture"
                      @keyup.enter="addCulture"
                      placeholder="+ Ajouter une culture"
                      class="px-4 py-2 border-2 border-dashed border-gray-200 text-neutral-muted rounded-xl text-sm font-medium hover:border-brand-primary hover:text-brand-primary transition-all focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                    />
                  </div>
                  <p v-if="form.errors.culture_types" class="mt-1 text-sm text-red-500">{{ form.errors.culture_types }}</p>
                </div>
              </div>

              <!-- Right Column: Location & Security -->
              <div class="space-y-8">
                <!-- Location Info -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                  <h3 class="text-lg font-bold text-neutral-title mb-6 flex items-center gap-2">
                    <i class="fas fa-map-marker-alt text-brand-primary"></i> Localisation
                  </h3>
                  <div class="space-y-6">
                    <div>
                      <label class="block mb-2 text-sm font-semibold text-neutral-title">Région d'exploitation</label>
                      <select
                        v-model="form.region_id"
                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                      >
                        <option value="">--Selectionnez une region--</option>
                        <option v-for="region in regions" :value="region.id" :key="region.id">
                          {{ region.name }}
                        </option>
                      </select>
                      <p v-if="form.errors.region_id" class="mt-1 text-sm text-red-500">{{ form.errors.region_id }}</p>
                    </div>
                    <div>
                      <label class="block mb-2 text-sm font-semibold text-neutral-title">Village / Localité</label>
                      <input
                        v-model="form.village"
                        type="text"
                        placeholder="ex: Penja"
                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"
                      />
                      <p v-if="form.errors.village" class="mt-1 text-sm text-red-500">{{ form.errors.village }}</p>
                    </div>
                  </div>
                </div>

                <!-- Security Alert Box -->
                <div class="bg-brand-dark p-8 rounded-3xl shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
                  <div class="flex items-center gap-6">
                    <div
                      class="w-16 h-16 bg-brand-primary rounded-2xl flex items-center justify-center text-white text-2xl shadow-inner"
                    >
                      <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                      <h4 class="text-white font-bold text-lg">Sécurité du compte</h4>
                      <p class="text-green-200 text-xs">Vos informations sont protégées.</p>
                    </div>
                  </div>
                  <button
                    type="button"
                    class="bg-white text-brand-dark px-6 py-3 rounded-xl font-bold text-sm hover:bg-green-100 transition-all"
                  >
                    Vérifier mon compte
                  </button>
                </div>
              </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end pt-4">
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
import { ref } from 'vue';
import FarmerNavbar from '@/Components/Farmer/Navbar/FarmerNavbar.vue';
import FarmerSidebar from '@/Components/Farmer/Sidebar/FarmerSidebar.vue';

// Type definitions
interface RegionData {
  id: string;
  name: string;
  code: string;
  country: string;
}

interface FarmerProfile {
  id: number;
  name: string;
  email: string;
  phone: string;
  region_id: string;
  village: string;
  culture_types: string[];
  bio: string;
  profile_photo_url?: string;
  banner_photo_url?: string; // Assuming a banner photo URL might exist
  average_rating: number;
  total_sales: number;
}

interface FarmerEditProfileProps {
  user: {
    data: FarmerProfile;
  };
  regions: {
    data: RegionData[];
  };
}

interface EditFarmerFormData {
  _method: 'put'; // For Inertia PUT request
  name: string;
  phone: string;
  email: string;
  region_id: string;
  village: string;
  culture_types: string[];
  bio: string;
  profile_photo: File | null;
  profile_photo_preview: string | null; // For displaying local image preview
  banner_photo: File | null;
  banner_photo_preview: string | null; // For displaying local image preview
}

// Props
const props = defineProps<FarmerEditProfileProps>();
const user = props.user.data;
const regions = props.regions.data;

// Reactive state for new culture input
const newCulture = ref<string>('');

// Form data using Inertia's useForm
const form = useForm<EditFarmerFormData>({
  _method: 'put',
  name: user.name,
  phone: user.phone,
  email: user.email,
  region_id: user.region_id,
  village: user.village,
  culture_types: user.culture_types || [],
  bio: user.bio,
  profile_photo: null,
  profile_photo_preview: user.profile_photo_url || null,
  banner_photo: null,
  banner_photo_preview: user.banner_photo_url || null,
});

// Methods
const handleProfilePhotoChange = (e: Event) => {
  const target = e.target as HTMLInputElement;

  if (target.files && target.files[0]) {
    const file = target.files[0];
    form.profile_photo = file;
    form.profile_photo_preview = URL.createObjectURL(file); // Create a URL for local preview
  }
};

const handleBannerChange = (e: Event) => {
  const target = e.target as HTMLInputElement;

  if (target.files && target.files[0]) {
    const file = target.files[0];
    form.banner_photo = file;
    form.banner_photo_preview = URL.createObjectURL(file); // Create a URL for local preview
  }
};

const addCulture = () => {
  if (newCulture.value.trim() !== '' && !form.culture_types.includes(newCulture.value.trim())) {
    form.culture_types.push(newCulture.value.trim());
    newCulture.value = '';
  }
};

const handleSubmit = () => {
  // You would replace '/farmer/profile/${user.id}' with your actual Inertia route helper
  form.post(`/farmer/profile/${user.id}`, {
    onSuccess: () => {
      console.log('Farmer profile updated successfully!');
      // Optionally, refresh the page or show a success message
    },
    onError: (errors) => {
      console.error('Error updating farmer profile:', errors);
      // Handle errors, e.g., display them next to fields
    },
    forceFormData: true, // Important for file uploads
  });
};
</script>

<style scoped>
</style>
