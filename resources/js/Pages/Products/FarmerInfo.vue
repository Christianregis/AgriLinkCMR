<template>
    <FlashMessage />

    <div class="min-h-screen bg-neutral-bg flex">

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- HEADER -->
            <AuthLayout />
            <!-- PROFILE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-5xl mx-auto space-y-8">

                    <!-- Banner & Quick Info -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="h-32 bg-linear-to-r from-brand-dark to-[#2D6A4F] relative">
                        </div>
                        <div class="px-8 pb-8 flex flex-col md:flex-row items-end -mt-12 gap-6">
                            <div class="relative group">
                                <img :src="farmer.data.profile_photo_url || `https://ui-avatars.com/api/?name=${farmer.data.name}&background=2D6A4F&color=fff`"
                                    class="w-32 h-32 rounded-3xl border-4 border-white shadow-xl object-cover bg-white">
                            </div>
                            <div class="flex gap-4 pb-2">
                                <div class="text-center px-6 border-r border-gray-100">
                                    <p class="text-2xl font-bold text-[#111827]">{{ farmer.data.average_rating }}</p>
                                    <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-widest">Note
                                        Moyenne</p>
                                </div>
                                <!-- <div class="text-center px-6">
                                    <p class="text-2xl font-bold text-[#111827]">{{ farmer.data.total_sales }}</p>
                                    <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-widest">Total
                                        vendus</p>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column: Detailed Info -->
                        <div class="lg:col-span-2 space-y-8">
                            <!-- Bio -->
                            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-[#111827]">À propos de la ferme</h3>
                                </div>
                                <p class="text-[#1F2937] leading-relaxed italic text-sm">"{{ farmer.data.bio }}"</p>
                            </div>

                            <!-- Cultures -->
                            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-[#111827] mb-6">Spécialités & Cultures</h3>
                                <div class="flex flex-wrap gap-3">
                                    <span v-for="culture in farmer.data.culture_types" :key="culture"
                                        class="px-4 py-2 bg-[#F0FDF4] text-[#2D6A4F] rounded-xl text-sm font-semibold border border-[#D8F3DC]">
                                        <i class="fas fa-check-circle mr-2 opacity-50"></i> {{ culture }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Contact & Security -->
                        <div class="space-y-8">
                            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-[#111827] mb-6">Coordonnées</h3>
                                <div class="space-y-4 mb-7">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 bg-[#F3F4F6] rounded-xl flex items-center justify-center text-[#4B5563]">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">
                                                Nom Agriculteur</p>
                                            <p class="text-sm font-semibold text-[#111827]">{{ farmer.data.name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 bg-[#F3F4F6] rounded-xl flex items-center justify-center text-[#4B5563]">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">
                                                Email</p>
                                            <p class="text-sm font-semibold text-[#111827]">{{ farmer.data.email }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-10 h-10 bg-[#F3F4F6] rounded-xl flex items-center justify-center text-[#4B5563]">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">
                                                Téléphone</p>
                                            <p class="text-sm font-semibold text-[#111827]">{{ farmer.data.phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-brand-bg p-8 rounded-3xl border border-brand-light">
                                <h3 class="text-md font-bold text-brand-dark mb-2">Compte Certifié</h3>
                                <p class="text-xs text-brand-primary leading-relaxed mb-4">Son profil est visible par
                                    tous les acheteurs de la plateforme AgriLink Cameroun.</p>
                                <div class="flex items-center gap-2 text-brand-primary font-bold text-xs">
                                    <i class="fas fa-shield-alt"></i> Données sécurisées
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script setup lang="ts">
import FlashMessage from '@/Components/FlashMessage.vue';
import AuthLayout from '@/Layouts/AuthLayout.vue';

interface FarmerProfile {
    farmer: {
        data: {
            id: number;
            name: string;
            email: string;
            phone: string;
            region: string;
            village: string;
            culture_types: string[];
            bio: string;
            profile_photo_url?: string;

            average_rating: number;
            total_sales: number;
        }
    }
}

 defineProps<FarmerProfile>()

</script>

<style scoped>
/* Les styles sont gérés par Tailwind CSS */
</style>
