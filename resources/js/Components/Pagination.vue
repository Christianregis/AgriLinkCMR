<template>
    <div class="flex items-center justify-between mt-6">
        <div class="flex justify-center gap-4 mt-6">
            <!-- <Link v-if="products.links.prev" :href="products.links.prev"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full border border-gray-200 text-sm font-medium text-neutral-muted hover:bg-gray-100 hover:text-neutral-title transition">
                                    <i class="fas fa-arrow-left text-xs"></i>
                                    Précédent
                                </Link>

                                <Link v-if="products.links.next" :href="products.links.next"
                                    class="inline-flex items-center gap-2 px-5 py-2 rounded-full bg-brand-primary text-white text-sm font-medium hover:bg-brand-primary/90 transition">
                                    Suivant
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </Link> -->
            <Link v-for="(link, key) in meta.links" :key="link.label" :href="link.url ?? '#'"
                :class="[link.active == true ? 'inline-flex items-center gap-2 px-5 py-2 rounded-md bg-brand-primary text-white text-sm font-medium hover:bg-brand-primary/90 transition' : 'inline-flex items-center gap-2 px-5 py-2 rounded-b-md border border-gray-200 text-sm font-medium text-neutral-muted hover:bg-gray-100 hover:text-neutral-title transition']">
            <p>{{ key == 0 ? 'Precedent' : key == meta.links.length - 1 ? 'Suivant' :
                key
                }}</p>
            </Link>
        </div>
    </div>
</template>
<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
interface Link {
    url?: string,
    label?: string,
    active: boolean,
}
interface PaginationLink {
    meta: {
        links: Link[]
    }
}

defineProps<PaginationLink>()
</script>
