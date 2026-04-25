<template>
    <tr v-for="product in props.data" :key="product.id">
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
                product.status === 'avaliable' ? 'bg-green-100 text-green-800' :
                    product.status === 'out_of_stock' ? 'bg-yellow-100 text-yellow-800' :
                        'bg-red-100 text-red-800'
            ]">
                {{ product.status }}
            </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <Link href="#" class="text-brand-primary hover:text-brand-hover mr-3">
            Éditer</Link>
            <button class="text-red-600 hover:text-red-900">Supprimer</button>
        </td>
    </tr>
</template>

<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
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
interface ProductsData {
    data: Product[];
}
const props = defineProps<ProductsData>()
</script>
