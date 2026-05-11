<template>
    <Link :href="productInfo(product.id)">
        <div
            :class="['relative overflow-hidden', { 'h-48 w-full md:w-1/3 md:h-auto': displayMode === 'list', 'h-48 w-full': displayMode === 'grid' }]">
            <img :src="product.primary_image_url"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                alt="Product Image">
            <div
                class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-[10px] font-bold text-brand-dark shadow-sm uppercase tracking-wider">
                <i class="fas fa-location-dot text-brand-primary mr-1"></i> {{ product.region.name
                }}
            </div>
        </div>
        <div :class="['p-5', { 'flex-1 flex flex-col justify-between': displayMode === 'list' }]">
            <div>
                <h3 class="font-bold text-neutral-title mb-1" :class="{ 'truncate': displayMode === 'grid' }">{{
                    product.title }}</h3>
                <div class="flex items-center text-xs text-neutral-muted mb-4">
                    <div class="flex text-accent-star mr-2">
                        <i v-for="i in 5" :key="i"
                            :class="[i <= product.average_rating ? 'fas' : 'far', 'fa-star']"></i>
                    </div>
                    <span>({{ product.reviews_count }})</span>
                </div>
                <p v-if="displayMode === 'list'" class="text-sm text-neutral-muted mb-3 line-clamp-3">{{
                    product.description
                    }}
                </p>
            </div>
            <div
                :class="['flex items-center', { 'justify-between': displayMode === 'grid', 'justify-between mt-auto': displayMode === 'list' }]">
                <p class="text-xl font-bold text-brand-primary">{{ product.price }} <span class="text-sm">FCFA / {{
                    product.unit }}</span></p>
                <button @click.prevent.stop="addToCart()"
                    class="bg-brand-primary text-white px-2 py-1 rounded-lg text-sm font-bold hover:bg-brand-hover transition-all">
                    <i class="fas fa-shopping-cart text-white text-xs"></i>
                </button>
            </div>
        </div>
    </Link>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue';
import { useCartStore } from '@/Pages/store/cartStore';
import { productInfo } from '@/routes';

const cartStore = useCartStore();

interface Product {
    id: number,
    primary_image_url?: string,
    title: string,
    average_rating: number
    unit: string,
    price: number,
    min_order_qty: number,
    description: string,
    reviews_count: number,
    quantity: number,
    region: Region,
}
interface Region {
    name: string,
}

interface Props {
    product: Product,
    displayMode: 'grid' | 'list'
}
const props = defineProps<Props>();
const localQuantity = ref<number>(props.product.min_order_qty > 0 ? props.product.min_order_qty : 1);

const emit = defineEmits<{
    (
        e: 'add-to-cart',
        product: {
            id: number
            title: string
            price: number
            unit: string
            primary_image_url: string
            stock: number
        }
    ): void
}>()

const addToCart = () => {
    const productToAdd = {
        id: props.product.id,
        title: props.product.title,
        price: props.product.price,
        unit: props.product.unit,
        primary_image_url:
            props.product.primary_image_url ||
            `https://via.placeholder.com/80x80?text=${props.product.title}`,
        stock: props.product.quantity,
    }

    cartStore.addItem(productToAdd, localQuantity.value)

    emit('add-to-cart', productToAdd)
}

</script>
