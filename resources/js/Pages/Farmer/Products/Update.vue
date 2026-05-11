<template>
    <FlashMessage />
    <div class="min-h-screen bg-neutral-bg flex">
        <!-- SIDEBAR -->
        <FarmerSidebar ref="farmerSidebarRef"/>

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- HEADER -->
            <FarmerNavbar :name="user.name" :profile_photo="user.profile_photo" @toggle-sidebar="handleToogleSidebar"/>

            <!-- PRODUCT EDIT CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-10 text-center">
                        <h1 class="text-3xl font-bold text-neutral-title">Modifier le produit: {{ product.data.title }}
                        </h1>
                        <p class="mt-2 text-neutral-muted">
                            Mettez à jour les informations de votre produit.
                        </p>
                    </div>

                    <div class="overflow-hidden bg-white border border-gray-100 shadow-xl rounded-2xl p-8">
                        <form @submit.prevent="handleSubmit" class="space-y-6">
                            <!-- Product Details Section -->
                            <div class="space-y-6">
                                <h2 class="text-xl font-bold text-neutral-title mb-4 flex items-center gap-2">
                                    <i class="fas fa-box text-brand-primary"></i> Détails du produit
                                </h2>
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
                                            <option v-for="cat in categories.data" :key="cat.id" :value="cat.id">
                                                {{ cat.name }}
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
                                            <option v-for="reg in regions.data" :key="reg.id" :value="reg.id">
                                                {{ reg.name }}
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

                            <!-- Dates Section -->
                            <div class="space-y-6 pt-6 border-t border-gray-100">
                                <h2 class="text-xl font-bold text-neutral-title mb-4 flex items-center gap-2">
                                    <i class="fas fa-calendar-alt text-brand-primary"></i> Dates
                                </h2>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Date de
                                        récolte</label>
                                    <input v-model="form.harvest_date" type="datetime-local"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                    <p v-if="form.errors.harvest_date" class="mt-1 text-sm text-red-500">{{
                                        form.errors.harvest_date }}</p>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Date d'expiration
                                        (optionnel)</label>
                                    <input v-model="form.expires_at" type="datetime-local"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary" />
                                    <p v-if="form.errors.expires_at" class="mt-1 text-sm text-red-500">{{
                                        form.errors.expires_at }}</p>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Statut du
                                        produit</label>
                                    <select v-model="form.status"
                                        class="w-full px-4 py-3 transition-all border bg-neutral-bg border-neutral-border rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary">
                                        <option value="available">Disponible</option>
                                        <option value="out_of_stock">En rupture de stock</option>
                                        <option value="coming_soon">Bientôt disponible</option>
                                    </select>
                                    <p v-if="form.errors.status" class="mt-1 text-sm text-red-500">{{ form.errors.status
                                    }}</p>
                                </div>
                            </div>

                            <!-- Images Section -->
                            <div class="space-y-6 pt-6 border-t border-gray-100">
                                <h2 class="text-xl font-bold text-neutral-title mb-4 flex items-center gap-2">
                                    <i class="fas fa-image text-brand-primary"></i> Images du produit
                                </h2>
                                <!-- Existing Images -->
                                <div v-if="existingImages.length"
                                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mb-4">
                                    <div v-for="(image, index) in existingImages" :key="image.id"
                                        class="relative group">
                                        <img :src="image.path"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-200" />
                                        <button @click="removeExistingImage(image.id, index)" type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- New Image Upload -->
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-neutral-title">Ajouter de
                                        nouvelles images</label>
                                    <div
                                        class="flex justify-center px-6 pt-5 pb-6 mt-1 transition-colors border-2 border-gray-300 border-dashed cursor-pointer rounded-xl hover:border-brand-primary bg-neutral-bg">
                                        <div class="space-y-1 text-center">
                                            <i class="mb-2 text-3xl text-gray-400 fas fa-cloud-arrow-up"></i>
                                            <div class="flex text-sm text-gray-600">
                                                <input type="file" accept="image/*" multiple
                                                    @change="handleNewImageUpload"
                                                    class="font-semibold text-brand-primary" />
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG jusqu'à 5MB par image (Max 6
                                                images au total)</p>
                                        </div>
                                    </div>
                                    <p v-if="form.errors.new_images" class="mt-1 text-sm text-red-500">{{
                                        form.errors.new_images }}</p>
                                </div>
                                <div v-if="newImagePreviews.length"
                                    class="mt-4 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <div v-for="(image, index) in newImagePreviews" :key="index" class="relative group">
                                        <img :src="image"
                                            class="w-full h-32 object-cover rounded-lg border border-gray-200" />
                                        <button @click="removeNewImage(index)" type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-end pt-4">
                                <button type="submit"
                                    class="py-3 px-8 font-bold text-white bg-brand-primary rounded-xl hover:bg-brand-hover transition-all shadow-md">
                                    Enregistrer les modifications
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
import { farmerProductsUpdate } from '@/routes';

interface Category {
    id: number;
    name: string;
}

interface Region {
    id: number;
    name: string;
}

interface ProductImage {
    id: number;
    path: string; // URL of the image
    // is_primary: boolean;
    // order: number;
}

interface Product {
    data: {
        id: string;
        title: string;
        description: string;
        quantity: number;
        unit: string;
        price: number;
        min_order_qty: number;
        price_negotiable: boolean;
        harvest_date: string; // YYYY-MM-DD 00:00 format
        expires_at: string | null; // YYYY-MM-DD 00:00 format
        status: 'available' | 'out_of_stock' | 'coming_soon';
        user_id: number;
        category_id: number;
        region_id: number;
        product_images: ProductImage[];
    }
}

interface EditProductFormData {
    _method: string,

    title: string;
    description: string;
    quantity: number;
    unit: string;
    price: number;
    min_order_qty: number;
    price_negotiable: boolean;
    harvest_date: string;
    expires_at: string | null;
    status: 'available' | 'out_of_stock' | 'coming_soon';
    category_id: number | null;
    region_id: number | null;
    new_images: File[]; // New images to upload
    deleted_image_ids: number[]; // IDs of images to delete
}

interface ProductEditProps {
    product: Product;
    categories: {
        data: Category[]
    };
    regions: {
        data: Region[]
    };
}

const page = usePage();
const user = page.props.auth.user.data;

const props = defineProps<ProductEditProps>();

// Initialize form with existing product data
const form = useForm<EditProductFormData>({
    _method: 'put',
    title: props.product.data.title,
    description: props.product.data.description,
    quantity: props.product.data.quantity,
    unit: props.product.data.unit,
    price: props.product.data.price,
    min_order_qty: props.product.data.min_order_qty,
    price_negotiable: props.product.data.price_negotiable,
    harvest_date: props.product.data.harvest_date,
    expires_at: props.product.data.expires_at,
    status: props.product.data.status,
    category_id: props.product.data.category_id,
    region_id: props.product.data.region_id,
    new_images: [],
    deleted_image_ids: [],
});

const existingImages = ref<ProductImage[]>([...props.product.data.product_images]);
const newImagePreviews = ref<string[]>([]);

const handleNewImageUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;

    if (target.files) {
        for (let i = 0; i < target.files.length; i++) {
            const file = target.files[i];
            // Limit total images to 6 (existing + new)

            if (existingImages.value.length + form.new_images.length < 6) {
                form.new_images.push(file);
                newImagePreviews.value.push(URL.createObjectURL(file));
            } else {
                alert('Vous ne pouvez pas ajouter plus de 6 images au total.');
                break;
            }
        }
    }
};

const removeNewImage = (index: number) => {
    URL.revokeObjectURL(newImagePreviews.value[index]); // Clean up URL object
    form.new_images.splice(index, 1);
    newImagePreviews.value.splice(index, 1);
};

const removeExistingImage = (imageId: number, index: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        form.deleted_image_ids.push(imageId);
        existingImages.value.splice(index, 1);
    }
};

const handleSubmit = () => {
    // Ensure at least one image remains if any were present initially
    if (existingImages.value.length + form.new_images.length === 0) {
        alert('Veuillez ajouter au moins une image pour votre produit.');

        return;
    }

    // Assuming a route for updating product exists, e.g., 'products.update'
    form.post(farmerProductsUpdate.url(props.product.data.id), {
        onSuccess: () => {
            console.log('Product updated successfully!');
        },
        onError: (errors: any) => {
            console.error('Error updating product:', errors);
        },
        forceFormData: true, // Important for file uploads
    });
};

const farmerSidebarRef = ref<InstanceType<typeof FarmerSidebar> | null>(null)
const handleToogleSidebar = () => {
    farmerSidebarRef.value?.toggleSidebar();
}

</script>

<style scoped>
/* Tailwind CSS handles most styling, but custom styles can go here */
</style>
