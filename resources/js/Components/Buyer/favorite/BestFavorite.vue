<template>
    <div class="space-y-8">
        <!-- Favorite Farmers -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-md font-bold text-neutral-title mb-6 flex items-center gap-2">
                <i class="fas fa-heart text-red-500"></i> Agriculteurs Favoris
            </h3>
            <div class="space-y-5">
                <div v-for="favoriteFarmer in bestsFarmerFavorite.data" :key="favoriteFarmer.product.farmer_profile.id"
                    class="flex items-center justify-between group cursor-pointer">
                    <div class="flex items-center gap-3">
                        <img :src="favoriteFarmer.product.farmer_profile.profile_photo"
                            class="w-11 h-11 rounded-xl shadow-sm" />
                        <div>
                            <Link :href="showFarmerInfo(favoriteFarmer.product.id)"
                                class="text-sm font-bold text-neutral-title group-hover:text-brand-primary transition-colors">
                                {{ favoriteFarmer.product.farmer_profile.name }}
                            </Link>
                            <p class="text-[10px] text-neutral-muted">
                                {{ favoriteFarmer.product.farmer_profile.village }} • {{
                                    favoriteFarmer.product.farmer_profile.reviews_count }} <i
                                    class="fas fa-star text-accent-star"></i>
                            </p>
                        </div>
                    </div>
                    <i
                        class="fas fa-chevron-right text-gray-300 group-hover:text-brand-primary transition-all text-xs"></i>
                </div>
            </div>
            <button @click="router.visit(buyerFavoriteShow.url())"
                class="w-full mt-6 py-3 border-2 border-brand-bg text-brand-primary font-bold rounded-xl text-xs hover:bg-brand-primary hover:text-white transition-all">
                Voir tous mes produits favoris
            </button>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { Link, router } from '@inertiajs/vue3'
import { buyerFavoriteShow, showFarmerInfo } from '@/routes'
// interface Props {
//     bestsFarmerFavorite: {
//         product: {
//             farmer_profile: {
//                 id: number,
//                 reviews_count: number,
//                 name: string,
//                 profile_photo: string,
//                 average_rating: number,
//             }
//         }
//     }[]
// }

interface Props {
    bestsFarmerFavorite: {
        data: {
            product: {
                id:string,
                farmer_profile: {
                    id: number,
                    reviews_count: number,
                    name: string,
                    village: string,
                    profile_photo: string,
                    average_rating: number,
                }
            }
        }[]
    }
}

defineProps<Props>()
</script>
