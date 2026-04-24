<template>
    <FlashMessage />
    <div class="min-h-screen bg-neutral-bg flex">
        <!-- SIDEBAR -->
        <FarmerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- HEADER -->
            <FarmerNavbar :name="user.name" :profile_photo="user.profile_photo" />

            <!-- PRODUCTS CONTENT -->
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-neutral-title">Mes Produits</h1>
                    <Link :href="farmerProductsCreate()"
                        class="bg-brand-primary text-white px-6 py-3 rounded-xl font-bold hover:bg-brand-hover transition-all shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i> Nouveau Produit
                    </Link>
                </div>

                <!-- Product List/Table -->
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <h2 class="text-lg font-bold text-neutral-title mb-6">Liste des produits</h2>
                    <div v-if="products.data.length > 0" class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-neutral-bg">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-neutral-muted uppercase tracking-wider">
                                        Titre</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-neutral-muted uppercase tracking-wider">
                                        Catégorie</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-neutral-muted uppercase tracking-wider">
                                        Quantité</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-neutral-muted uppercase tracking-wider">
                                        Prix</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-neutral-muted uppercase tracking-wider">
                                        Statut</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="product in products.data" :key="product.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                    :src="product.primary_image_url || `https://via.placeholder.com/150?text=${product.title.charAt(0)}`"
                                                    alt="" />
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-neutral-title">{{ product.title }}
                                                </div>
                                                <div class="text-sm text-neutral-muted">{{
                                                    product.description.substring(0, 50) }}...</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-neutral-title">{{ product.category.name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-neutral-title">{{ product.quantity }} {{ product.unit
                                            }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-title">{{ product.price
                                        }} FCFA</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span :class="[
                                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                            product.status === 'active' ? 'bg-green-100 text-green-800' :
                                                product.status === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                                    'bg-red-100 text-red-800'
                                        ]">
                                            {{ product.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('products.edit', product.id)"
                                            class="text-brand-primary hover:text-brand-hover mr-3">Éditer</Link>
                                        <button @click="deleteProduct(product.id)"
                                            class="text-red-600 hover:text-red-900">Supprimer</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center py-8 text-neutral-muted">
                        Aucun produit enregistré pour le moment.
                        <Link :href="route('products.create')" class="block mt-4 text-brand-primary hover:underline">
                            Ajouter votre premier produit</Link>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        <div class="flex items-center justify-between mt-6">
                            <div class="flex justify-center gap-4 mt-6">
                                <Link v-if="products.links.prev" :href="products.links.prev"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-gray-200 text-sm font-medium text-neutral-muted hover:bg-gray-100 hover:text-neutral-title transition">
                                    <i class="fas fa-arrow-left text-xs"></i>
                                    Précédent
                                </Link>

                                <Link v-if="products.links.next" :href="products.links.next"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-brand-primary text-white text-sm font-medium hover:bg-brand-primary/90 transition">
                                    Suivant
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import FarmerNavbar from '@/Components/Farmer/Navbar/FarmerNavbar.vue';
import FarmerSidebar from '@/Components/Farmer/Sidebar/FarmerSidebar.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { farmerProductsCreate } from '@/routes';


interface Category {
    id: number;
    name: string;
}

interface Product {
    id: number;
    title: string;
    description: string;
    quantity: number;
    unit: string;
    price: number;
    status: string; // Assuming these statuses
    primary_image_url?: string; // Assuming a primary image URL for display
    category: Category;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface ProductsData {
    data: Product[];
    links: PaginationLink[];
    // Add other pagination properties if needed, e.g., current_page, last_page, etc.
}

const page = usePage();
const user = page.props.auth.user.data;

const props = defineProps<{
    products: ProductsData;
}>();

console.log(props.products.links.length)
const deleteProduct = (productId: number) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
        // Implement actual deletion logic here, e.g., using Inertia.delete
        console.log(`Deleting product with ID: ${productId}`);
        // Example: Inertia.delete(route('products.destroy', productId));
    }
};

// Helper to get Inertia route, assuming it's globally available or imported
const route = (name: string, params?: any) => {
    // This is a placeholder. In a real Inertia app, you'd use the actual route helper.
    console.log(`Route: ${name}`, params);

    if (name === 'products.create') {
        return '/farmer/products/create';
    }

    if (name === 'products.edit' && params) {
        return `/farmer/products/${params}/edit`
    }

    return '#';
};
</script>

<style scoped>
/* Tailwind CSS handles most styling, but custom styles can go here */
</style>
