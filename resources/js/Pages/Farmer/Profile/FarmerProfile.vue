<template>
        <FlashMessage />

    <div class="min-h-screen bg-[#F3F4F6] flex">
        <!-- SIDEBAR -->
        <FarmerSidebar />

        <!-- MAIN CONTENT -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- HEADER -->
            <FarmerNavbar :name="user.name" :profile_photo="user.profile_photo_url"/>

            <!-- PROFILE CONTENT -->
            <div class="flex-1 overflow-y-auto p-8">
                <div class="max-w-5xl mx-auto space-y-8">

                    <!-- Banner & Quick Info -->
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="h-32 bg-gradient-to-r from-[#1A3D2B] to-[#2D6A4F] relative">
                        </div>
                        <div class="px-8 pb-8 flex flex-col md:flex-row items-end -mt-12 gap-6">
                            <div class="relative group">
                                <img :src="user.profile_photo_url || `https://ui-avatars.com/api/?name=${user.name}&background=2D6A4F&color=fff`"
                                    class="w-32 h-32 rounded-3xl border-4 border-white shadow-xl object-cover bg-white">
                                <button
                                    class="absolute inset-0 bg-black/40 rounded-3xl opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition-all">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            </div>
                            <div class="flex gap-4 pb-2">
                                <div class="text-center px-6 border-r border-gray-100">
                                    <p class="text-2xl font-bold text-[#111827]">{{ user.average_rating }}</p>
                                    <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-widest">Note
                                        Moyenne</p>
                                </div>
                                <div class="text-center px-6">
                                    <p class="text-2xl font-bold text-[#111827]">{{ user.total_sales }}</p>
                                    <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-widest">Total
                                        vendus</p>
                                </div>
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
                                    <Link :href="farmerProfileEdit()" class="text-[#2D6A4F] hover:bg-[#F0FDF4] p-2 rounded-lg transition-all"><i
                                            class="fas fa-edit"></i></Link>
                                </div>
                                <p class="text-[#1F2937] leading-relaxed italic text-sm">"{{ user.bio }}"</p>
                            </div>

                            <!-- Cultures -->
                            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                                <h3 class="text-lg font-bold text-[#111827] mb-6">Spécialités & Cultures</h3>
                                <div class="flex flex-wrap gap-3">
                                    <span v-for="culture in user.culture_types" :key="culture"
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
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-[#4B5563] uppercase tracking-wider">
                                                Email</p>
                                            <p class="text-sm font-semibold text-[#111827]">{{ user.email }}</p>
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
                                            <p class="text-sm font-semibold text-[#111827]">{{ user.phone }}</p>
                                        </div>
                                    </div>
                                </div>
                                <Link :href="farmerProfileEdit()"
                                    class="w-full mt-8 bg-[#2D6A4F] px-3 text-white py-3.5 rounded-xl font-bold hover:bg-[#40916C] transition-all shadow-md">
                                    Mettre à jour les infos
                                </Link>
                            </div>

                            <div class="bg-brand-bg p-8 rounded-3xl border border-brand-light">
                                <h3 class="text-md font-bold text-brand-dark mb-2">Compte Certifié</h3>
                                <p class="text-xs text-brand-primary leading-relaxed mb-4">Votre profil est visible par
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
import { Link } from '@inertiajs/vue3';
import FarmerNavbar from '@/Components/Farmer/Navbar/FarmerNavbar.vue';
import FarmerSidebar from '@/Components/Farmer/Sidebar/FarmerSidebar.vue';
import FlashMessage from '@/Components/FlashMessage.vue';
import { farmerProfileEdit } from '@/routes';

interface FarmerProfile {
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

const props = defineProps<{
    user: {
        data: FarmerProfile
    };
}>();

const user = props.user.data;
</script>

<style scoped>
/* Les styles sont gérés par Tailwind CSS */
</style>
