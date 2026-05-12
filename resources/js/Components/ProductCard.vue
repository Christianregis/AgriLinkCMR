<template>
    <Link :href="productInfo(product.id)"
        :class="[
            'group block bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300',
            { 'flex flex-row w-full': displayMode === 'list' }
        ]">

        <!-- IMAGE -->
        <div :class="[
            'relative overflow-hidden shrink-0',
            displayMode === 'list' ? ' w-52 h-full min-h-48' : 'h-48 w-full'
        ]">
            <img
                :src="product.primary_image_url"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                alt="Product Image"
            >
            <div class="absolute inset-0 bg-black/15 group-hover:bg-black/0 transition-all duration-500"></div>
            <!-- Region badge -->
            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-lg text-[10px] font-bold text-brand-dark shadow-sm uppercase tracking-wider">
                <i class="fas fa-location-dot text-brand-primary mr-1"></i> {{ product.region.name }}
            </div>
        </div>

        <!-- CONTENT -->
        <div :class="[
            'p-5 flex flex-col',
            displayMode === 'list' ? 'flex-1 justify-between' : ''
        ]">
            <!-- Top block -->
            <div>
                <h3
                    class="font-bold text-neutral-title mb-1"
                    :class="displayMode === 'grid' ? 'truncate' : 'text-base leading-snug'"
                >
                    {{ product.title }}
                </h3>

                <!-- Stars -->
                <div class="flex items-center text-xs text-neutral-muted mb-3">
                    <div class="flex text-accent-star mr-2">
                        <i v-for="i in 5" :key="i"
                            :class="[i <= product.average_rating ? 'fas' : 'far', 'fa-star']"></i>
                    </div>
                    <span>({{ product.reviews_count }})</span>
                </div>

                <!-- Description — list mode only -->
                <p v-if="displayMode === 'list'"
                    class="text-sm text-neutral-muted line-clamp-2 leading-relaxed">
                    {{ product.description.substring(0, 100) }}{{ product.description.length > 100 ? '...' : '' }}
                </p>
            </div>

            <!-- Bottom block: price + CTA -->
            <div class="flex items-center justify-between mt-4">
                <div>
                    <p class="text-xl font-bold text-brand-primary leading-none">
                        {{ product.price.toLocaleString() }}
                        <span class="text-sm font-normal text-neutral-muted">FCFA / {{ product.unit }}</span>
                    </p>
                </div>

                <button
                    @click.prevent.stop="addToCart()"
                    class="flex items-center gap-2 bg-brand-primary text-white px-3 py-2 rounded-xl text-sm font-bold hover:bg-brand-hover transition-all duration-200 shadow-sm hover:shadow"
                >
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

interface Region {
    name: string,
}

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
