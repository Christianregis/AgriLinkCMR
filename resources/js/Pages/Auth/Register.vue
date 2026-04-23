<template>
    <main class="min-h-screen px-4 py-12 antialiased bg-neutral-bg">
        <FlashMessage />
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
                <h1 class="text-3xl font-bold text-neutral-title">Créer votre compte</h1>
                <p class="mt-2 text-neutral-muted">
                    Rejoignez la communauté agricole du Cameroun
                </p>
            </div>

            <div class="overflow-hidden bg-white border border-gray-100 shadow-xl rounded-2xl">
                <!-- Progression Indicator -->
                <div class="flex justify-center p-6 border-b border-gray-100">
                    <div class="flex items-center">
                        <div :class="[
                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-white',
                            currentStep >= 1 ? 'bg-brand-primary' : 'bg-gray-300'
                        ]">
                            1
                        </div>
                        <div :class="[
                            'w-20 h-1 bg-gray-300 mx-2',
                            currentStep > 1 ? 'bg-brand-primary' : 'bg-gray-300'
                        ]"></div>
                    </div>

                    <div class="flex items-center">
                        <div :class="[
                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-white',
                            currentStep >= 2 ? 'bg-brand-primary' : 'bg-gray-300'
                        ]">
                            2
                        </div>
                        <div :class="[
                            'w-20 h-1 bg-gray-300 mx-2',
                            currentStep > 2 ? 'bg-brand-primary' : 'bg-gray-300'
                        ]"></div>
                    </div>

                    <div class="flex items-center">
                        <div :class="[
                            'w-10 h-10 rounded-full flex items-center justify-center font-bold text-white',
                            currentStep >= 3 ? 'bg-brand-primary' : 'bg-gray-300'
                        ]">
                            3
                        </div>
                    </div>
                </div>
                <div v-if="form.errors.name || form.errors.email || form.errors.password">
                    <div class="flex items-center p-4 text-red-700 bg-red-100 border border-red-300 rounded-lg">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10A8 8 0 11..."></path>
                        </svg>
                        <span>{{ form.errors.name || form.errors.email || form.errors.password }}</span>
                    </div>
                </div>
                <form @submit.prevent="handleSubmit" class="p-8 pt-2 space-y-6">
                    <!-- Step 1: Personal Information -->
                    <div v-if="currentStep === 1" class="space-y-6">
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Nom complet</label>
                                <input required v-model="form.name" type="text" placeholder="Jean Dupont"
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                <p v-if="form.errors.name" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.name }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Téléphone</label>
                                <input required v-model="form.phone" type="tel" placeholder="+237 6xx xxx xxx"
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                <p v-if="form.errors.phone" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.phone }}
                                </p>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-semibold text-neutral-title">Adresse Email</label>
                            <input required v-model="form.email" type="email" placeholder="votre@email.com"
                                class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                            <p v-if="form.errors.email" class="mt-1 text-sm text-red-500">
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Mot de passe</label>
                                <input v-model="form.password" required type="password" placeholder="••••••••"
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                <p v-if="form.errors.password" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.password }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Confirmation</label>
                                <input required v-model="form.password_confirmation" type="password"
                                    placeholder="••••••••"
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                <p v-if="errorConfirmationPassword" class="mt-1 text-sm text-red-500">
                                    {{ errorConfirmationPassword }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Account Type Specific Information -->
                    <div v-if="currentStep === 2" class="space-y-6">
                        <!-- TYPE SELECTOR -->
                        <div class="flex p-2 border border-gray-200 bg-neutral-bg rounded-xl">
                            <button @click="changeType('buyer')" type="button" :class="[
                                'flex items-center justify-center flex-1 gap-2 py-3 font-bold transition-all rounded-lg',
                                userType === 'buyer'
                                    ? 'bg-white text-brand-primary shadow-sm'
                                    : 'text-neutral-muted hover:text-brand-primary',
                            ]">
                                <i class="fas fa-shopping-basket"></i> Je suis Acheteur
                            </button>
                            <button @click="changeType('farmer')" type="button" :class="[
                                'flex items-center justify-center flex-1 gap-2 py-3 font-bold transition-all rounded-lg',
                                userType === 'farmer'
                                    ? 'bg-white text-brand-primary shadow-sm'
                                    : 'text-neutral-muted hover:text-brand-primary',
                            ]">
                                <i class="fas fa-tractor"></i> Je suis Agriculteur
                            </button>
                        </div>

                        <!-- DYNAMIC BUYER FIELDS -->
                        <div v-if="userType === 'buyer'" class="space-y-6">
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Type
                                    d'acheteur</label>
                                <select v-model="form.buyer_type"
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary">
                                    <option value="person">Particulier</option>
                                    <option value="company">Entreprise</option>
                                    <option value="institution">Institution</option>
                                    <option value="other">Autre</option>
                                </select>
                                <p v-if="form.errors.buyer_type" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.buyer_type }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Nom de l'entreprise
                                    (optionnel)</label>
                                <input v-model="form.company_name" type="text" placeholder="Ma Boutique Sarl"
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                <p v-if="form.errors.company_name" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.company_name }}
                                </p>
                            </div>
                        </div>

                        <!-- DYNAMIC FARMER FIELDS -->
                        <div v-else class="space-y-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Région
                                        d'exploitation</label>
                                    <select v-model="form.region_id"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary">
                                        <option value="">--Selectionnez une region--</option>
                                        <option v-for="region in regions" :value="region.id" :key="region.id">
                                            {{ region.name }}
                                        </option>
                                    </select>
                                    <p v-if="form.errors.region_id" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.region_id }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Village /
                                        Localité</label>
                                    <input v-model="form.village" type="text" placeholder="ex: Penja"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                    <p v-if="form.errors.village" class="mt-1 text-sm text-red-500">
                                        {{ form.errors.village }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Types de cultures /
                                    produits</label>
                                <input v-model="form.cultures" type="text" placeholder="Ananas, Manioc, Maïs..."
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                <p v-if="form.errors.cultures" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.cultures }}
                                </p>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-semibold text-neutral-title">Biographie /
                                    Présentation</label>
                                <textarea v-model="form.bio" rows="3"
                                    placeholder="Ex: Ma ferme propose des produits frais et de qualites pour vos usages au quotidient..."
                                    class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"></textarea>
                                <p v-if="form.errors.bio" class="mt-1 text-sm text-red-500">
                                    {{ form.errors.bio }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Profile Photo and Terms -->
                    <div v-if="currentStep === 3" class="space-y-6">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-neutral-title">Photo de profil</label>
                            <div
                                class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed cursor-pointer rounded-xl hover:border-brand-primary bg-neutral-bg">
                                <div class="space-y-1 text-center">
                                    <i class="mb-2 text-3xl text-gray-400 fas fa-cloud-arrow-up"></i>
                                    <div class="flex text-sm text-gray-600">
                                        <input type="file" accept="image/*" @change="handleFileChange"
                                            class="font-semibold text-brand-primary" />
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG jusqu'à 2MB</p>
                                </div>
                            </div>
                            <p v-if="form.errors.profile_photo" class="mt-1 text-sm text-red-500">
                                {{ form.errors.profile_photo }}
                            </p>
                        </div>

                        <div class="flex items-start">
                            <input required v-model="form.terms" type="checkbox" id="terms"
                                class="w-5 h-5 mt-1 border-gray-300 rounded text-brand-primary focus:ring-brand-primary" />
                            <label for="terms" class="ml-3 text-sm text-neutral-muted" aria-required>
                                J'accepte les
                                <a href="#" class="font-bold text-brand-primary hover:underline">conditions
                                    d'utilisation</a>
                                et la politique de confidentialité.
                            </label>
                            <p v-if="errorTermsNotConfirmed" class="mt-1 text-sm text-red-500">
                                {{ errorTermsNotConfirmed }}
                            </p>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between pt-4">
                        <button v-if="currentStep > 1" @click="prevStep" type="button"
                            class="py-3 px-6 font-bold text-brand-primary border border-brand-primary rounded-xl hover:bg-brand-primary hover:text-white transition-all">
                            Précédent
                        </button>
                        <button v-if="currentStep < 3" @click="nextStep" type="button"
                            class="ml-auto py-3 px-6 font-bold text-white bg-brand-primary rounded-xl hover:bg-brand-hover transition-all">
                            Suivant
                        </button>
                        <button v-if="currentStep === 3" type="submit"
                            class="ml-auto w-full py-4 font-bold text-white transition-all shadow-md bg-brand-primary rounded-xl hover:bg-brand-hover hover:shadow-lg">
                            Créer mon compte
                        </button>
                    </div>
                </form>
            </div>

            <p class="mt-8 text-center text-neutral-body">
                Déjà inscrit ?
                <Link :href="connexion()" class="font-bold text-brand-primary hover:underline">
                    Se connecter
                </Link>
            </p>
        </div>
    </main>
</template>

<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { connexion, home, register } from '@/routes';
import FlashMessage from "../../Components/FlashMessage.vue"; // Assuming this path is correct

// Type definitions
type UserType = 'buyer' | 'farmer';

interface RegionData {
    id: string;
    name: string;
    code: string;
    country: string;
}

interface RegionProps {
    regions: {
        data: RegionData[];
    };
}

interface FormData {
    account_type: UserType;
    name: string;
    phone: string;
    email: string;
    password: string;
    password_confirmation: string;
    buyer_type: string;
    company_name: string;
    region_id: string;
    village: string;
    cultures: string;
    bio: string;
    profile_photo: File | null;
    terms: boolean;
}

// Reactive state
const currentStep = ref<number>(1);
const userType = ref<UserType>('buyer');

// Props for regions (assuming it's passed from Inertia)
const props = defineProps<RegionProps>();
const regions = props.regions.data;

// Form data using Inertia's useForm
const form = useForm<FormData>({
    account_type: userType.value,
    name: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
    buyer_type: 'person',
    company_name: '',
    region_id: '',
    village: '',
    cultures: '',
    bio: '',
    profile_photo: null,
    terms: false,
});

// Error messages for custom validation
const errorConfirmationPassword = ref<string | null>(null);
const errorTermsNotConfirmed = ref<string | null>(null);

// Methods
const changeType = (type: UserType) => {
    userType.value = type;
    form.account_type = type;
};

const handleFileChange = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.profile_photo = target.files[0];
    }
};

const validateStep1 = (): boolean => {
    errorConfirmationPassword.value = null;

    if (form.password !== form.password_confirmation) {
        errorConfirmationPassword.value = 'Les mots de passe ne correspondent pas !';

        return false;
    }
    // Basic check for required fields in step 1'

    if (!form.name || !form.phone || !form.email || !form.password || !form.password_confirmation) {

        return false;
    }

    return true;
};

const validateStep2 = (): boolean => {
    if (userType.value === 'buyer') {
        if (!form.buyer_type) {
            return false;
        }

        return true;
    }

    // farmer
    if (!form.region_id || !form.village || !form.cultures || !form.bio) {
        return false;
    }

    return true;
};
const validateStep3 = (): boolean => {
    errorTermsNotConfirmed.value = null;

    if (!form.terms) {
        errorTermsNotConfirmed.value = 'Vous devez valider les termes d\'utilisation !';

        return false;
    }

    return true;
};

const nextStep = () => {
    if (currentStep.value === 1) {
        if (validateStep1()) {
            currentStep.value++;
        }
    } else if (currentStep.value === 2) {
        if (validateStep2()) {
            currentStep.value++;
        }
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const handleSubmit = () => {
    if (currentStep.value === 3) {
        if (validateStep3()) {
            form.post(register().url, {
                onSuccess: () => {
                    form.reset();
                    currentStep.value = 1; // Reset to first step after successful submission
                },
                forceFormData: true,
            });
        }
    }
};
</script>
