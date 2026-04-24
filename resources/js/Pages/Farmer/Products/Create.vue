<template>
    <FlashMessage />
    <div class="min-h-screen bg-neutral-bg flex">
        <!-- SIDEBAR -->
        <FarmerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- HEADER -->
            <FarmerNavbar :name="user.name" :profile_photo="user.profile_photo" />
            <div v-if="errorsData" class="bg-red-50 border border-red-200 p-4 rounded-xl">
                <ul class="text-red-600 text-sm space-y-1">
                    <li v-for="(error, key) in errorsData" :key="key">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <!-- PRODUCT ADDITION CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-10 text-center">
                        <h1 class="text-3xl font-bold text-neutral-title">Ajouter un nouveau produit</h1>
                        <p class="mt-2 text-neutral-muted">
                            Remplissez les informations pour mettre votre produit en vente.
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

                        <form @submit.prevent="handleSubmit" class="p-8 pt-2 space-y-6">
                            <!-- Step 1: General Information -->
                            <div v-if="currentStep === 1" class="space-y-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Titre du
                                        produit</label>
                                    <input v-model="form.title" type="text" placeholder="Ex: Tomates fraîches bio"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                    <p v-if="form.errors.title" class="mt-1 text-sm text-red-500">{{ form.errors.title
                                        }}</p>
                                </div>
                                <div>
                                    <label
                                        class="block mb-2 text-sm font-semibold text-neutral-title">Description</label>
                                    <textarea v-model="form.description" rows="4"
                                        placeholder="Décrivez votre produit en détail..."
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary"></textarea>
                                    <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">{{
                                        form.errors.description }}</p>
                                </div>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label
                                            class="block mb-2 text-sm font-semibold text-neutral-title">Catégorie</label>
                                        <select v-model="form.category_id"
                                            class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary">
                                            <option value="">-- Sélectionner une catégorie --</option>
                                            <option v-for="category in categories.data" :key="category.id"
                                                :value="category.id">
                                                {{ category.name }}
                                            </option>
                                        </select>
                                        <p v-if="form.errors.category_id" class="mt-1 text-sm text-red-500">{{
                                            form.errors.category_id }}</p>
                                    </div>
                                    <div>
                                        <label
                                            class="block mb-2 text-sm font-semibold text-neutral-title">Région</label>
                                        <select v-model="form.region_id"
                                            class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary">
                                            <option value="">-- Sélectionner une région --</option>
                                            <option v-for="region in regions.data" :key="region.id" :value="region.id">
                                                {{ region.name }}
                                            </option>
                                        </select>
                                        <p v-if="form.errors.region_id" class="mt-1 text-sm text-red-500">{{
                                            form.errors.region_id }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                    <div>
                                        <label
                                            class="block mb-2 text-sm font-semibold text-neutral-title">Quantité</label>
                                        <input v-model="form.quantity" type="number" min="0" placeholder="100"
                                            class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                        <p v-if="form.errors.quantity" class="mt-1 text-sm text-red-500">{{
                                            form.errors.quantity }}</p>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-semibold text-neutral-title">Unité</label>
                                        <input v-model="form.unit" type="text" placeholder="Ex: Kg, Sacs, Litres"
                                            class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                        <p v-if="form.errors.unit" class="mt-1 text-sm text-red-500">{{ form.errors.unit
                                            }}</p>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-semibold text-neutral-title">Prix par
                                            unité</label>
                                        <input v-model="form.price" type="number" step="0.01" min="0" placeholder="500"
                                            class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                        <p v-if="form.errors.price" class="mt-1 text-sm text-red-500">{{
                                            form.errors.price }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div class="flex items-center mt-4">
                                        <input v-model="form.price_negotiable" type="checkbox" id="price_negotiable"
                                            class="w-5 h-5 border-gray-300 rounded text-brand-primary focus:ring-brand-primary" />
                                        <label for="price_negotiable" class="ml-3 text-sm text-neutral-title">Prix
                                            négociable</label>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-semibold text-neutral-title">Quantité
                                            minimale de commande</label>
                                        <input v-model="form.min_order_qty" type="number" min="1" placeholder="1"
                                            class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                        <p v-if="form.errors.min_order_qty" class="mt-1 text-sm text-red-500">{{
                                            form.errors.min_order_qty }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Dates -->
                            <div v-if="currentStep === 2" class="space-y-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Date de
                                        récolte</label>
                                    <input v-model="form.harvest_date" type="date"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                    <p v-if="form.errors.harvest_date" class="mt-1 text-sm text-red-500">{{
                                        form.errors.harvest_date }}</p>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Date d'expiration
                                        (optionnel)</label>
                                    <input v-model="form.expires_at" type="date"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                    <p v-if="form.errors.expires_at" class="mt-1 text-sm text-red-500">{{
                                        form.errors.expires_at }}</p>
                                </div>
                            </div>

                            <!-- Step 3: Product Images -->
                            <div v-if="currentStep === 3" class="space-y-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Images du
                                        produit</label>
                                    <div
                                        class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed cursor-pointer rounded-xl hover:border-brand-primary bg-neutral-bg">
                                        <div class="space-y-1 text-center">
                                            <i class="mb-2 text-3xl text-gray-400 fas fa-cloud-arrow-up"></i>
                                            <div class="flex text-sm text-gray-600">
                                                <input type="file" accept="image/*" multiple @change="handleImageUpload"
                                                    class="font-semibold text-brand-primary" />
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG jusqu'à 5MB par image</p>
                                        </div>
                                    </div>
                                    <p v-if="form.errors.images" class="mt-1 text-sm text-red-500">{{ form.errors.images
                                        }}</p>
                                </div>
                                <div v-if="imagePreviews.length" class="mt-4 grid grid-cols-3 gap-4">
                                    <div v-for="(image, index) in imagePreviews" :key="index" class="relative">
                                        <img :src="image" class="w-full h-24 object-cover rounded-lg" />
                                        <button @click="removeImage(index)" type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
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
                                    Ajouter le produit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import FarmerNavbar from '@/Components/Farmer/Navbar/FarmerNavbar.vue';
import FarmerSidebar from '@/Components/Farmer/Sidebar/FarmerSidebar.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { farmerProductsStore } from '@/routes';


interface Category {
    id: number;
    name: string;
}

interface Region {
    id: number;
    name: string;
}

interface ProductFormData {
    title: string;
    description: string;
    quantity: number;
    unit: string;
    price: number;
    min_order_qty: number;
    price_negotiable: boolean;
    harvest_date: string;
    expires_at: string | null;
    status: string;
    user_id: number; // Will be set by backend or from auth user
    category_id: number | null;
    region_id: number | null;
    images: File[];
}

interface ProductCreateProps {
    categories: {
        data: Category[]
    };
    regions: {
        data: Region[];
    }
}

// Props
const props = defineProps<ProductCreateProps>();
const page = usePage();
const user = page.props.auth.user.data;
const categories = props.categories;
const regions = props.regions;

// Reactive state for multi-step form
const currentStep = ref<number>(1);
const imagePreviews = ref<string[]>([]);

// Form data using Inertia's useForm
const form = useForm<ProductFormData>({
    title: "",
    description: "",
    quantity: 0,
    unit: '',
    price: 0,
    min_order_qty: 1,
    price_negotiable: false,
    harvest_date: new Date().toISOString().slice(0, 10), // Default to today
    expires_at: null,
    status: 'avaliable', // Default status
    user_id: user.id,
    category_id: null,
    region_id: null,
    images: [],
});

// Methods for image handling
const handleImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files) {
        for (let i = 0; i < target.files.length; i++) {
            const file = target.files[i];
            form.images.push(file);
            imagePreviews.value.push(URL.createObjectURL(file));
        }
    }
};

const removeImage = (index: number) => {
    form.images.splice(index, 1);
    imagePreviews.value.splice(index, 1);
};

// Validation for each step (basic client-side validation)
const validateStep1 = (): boolean => {
    if (!form.title || !form.description || !form.category_id || !form.region_id || form.quantity <= 0 || !form.unit || form.price <= 0 || form.min_order_qty <= 0) {
        // In a real app, you'd set specific error messages for each field
        alert('Veuillez remplir tous les champs obligatoires de la première étape.');

        return false;
    }

    return true;
};

const validateStep2 = (): boolean => {
    if (!form.harvest_date) {
        alert('Veuillez spécifier la date de récolte.');

        return false;
    }

    return true;
};

const nextStep = () => {
    if (currentStep.value === 1 && validateStep1()) {
        currentStep.value++;
    } else if (currentStep.value === 2 && validateStep2()) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const errorsData = ref()
const handleSubmit = () => {
    if (currentStep.value === 3) {
        // Final validation for step 3 if needed (e.g., minimum number of images)
        if (form.images.length === 0) {
            alert('Veuillez ajouter au moins une image pour votre produit.');

            return;
        }

        // Submit the form using Inertia
        form.post(farmerProductsStore.url(), {
            onSuccess:()=>{
                form.reset();
                currentStep.value = 1;
            },
            onError: (errors) => {
                errorsData.value = errors;
                console.log(errorsData)
            },
            forceFormData: true, // Important for file uploads
        });
    }
};
</script>

<style scoped>
/* Tailwind CSS handles most styling, but custom styles can go here */
</style>
