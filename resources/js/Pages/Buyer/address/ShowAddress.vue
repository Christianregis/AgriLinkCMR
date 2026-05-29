<template>
    <FlashMessage />

    <main class="bg-neutral-bg flex min-h-screen antialiased">
        <!-- SIDEBAR -->
        <BuyerSidebar ref="buyerSidebarRef" />

        <!-- MAIN -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- NAVBAR -->
            <BuyerNavbar :name="user.data.name" :profile_photo="user.data.profile_photo"
                @openbuyer-sidebar="openSidebar" />

            <!-- CONTENT -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-6">

                <!-- PAGE HEADER -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-neutral-title">Adresses de livraison</h1>
                        <p class="text-sm text-neutral-muted mt-1">Gérez vos points de réception</p>
                    </div>

                    <button @click="openModal()"
                        class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-hover text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-sm">
                        <i class="fas fa-plus text-xs"></i>
                        Nouvelle adresse
                    </button>
                </div>

                <!-- EMPTY STATE -->
                <div v-if="addresses.data.length === 0"
                    class="bg-white rounded-3xl border border-gray-100 shadow-sm flex flex-col items-center justify-center py-20 px-8">
                    <div
                        class="w-20 h-20 rounded-2xl bg-brand-light/10 text-brand-primary flex items-center justify-center text-3xl mb-5">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-title mb-2">Aucune adresse enregistrée</h3>
                    <p class="text-sm text-neutral-muted text-center max-w-sm leading-relaxed mb-6">
                        Ajoutez une adresse de livraison pour faciliter vos prochaines commandes.
                    </p>
                    <button @click="openModal()"
                        class="inline-flex items-center gap-2 bg-brand-primary hover:bg-brand-hover text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all">
                        <i class="fas fa-plus text-xs"></i>
                        Ajouter une adresse
                    </button>
                </div>

                <!-- ADDRESSES GRID -->
                <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                    <div v-for="address in addresses.data" :key="address.id"
                        class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col gap-4 relative group transition-all hover:shadow-md hover:border-brand-primary/20">

                        <!-- ICON + LABEL -->
                        <div class="flex items-start gap-4">
                            <div
                                class="w-11 h-11 rounded-xl bg-brand-light/10 text-brand-primary flex items-center justify-center shrink-0">
                                <i
                                    :class="address.type === 'home' ? 'fas fa-home' : address.type === 'office' ? 'fas fa-briefcase' : 'fas fa-map-marker-alt'"></i>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-neutral-title truncate">{{ address.label }}</h3>
                                <p class="text-sm text-neutral-muted mt-0.5">{{ address.recipient_name }}</p>
                            </div>
                        </div>

                        <!-- ADDRESS DETAILS -->
                        <div class="space-y-1.5 text-sm text-neutral-muted leading-relaxed">
                            <p class="flex items-start gap-2">
                                <i class="fas fa-location-dot text-xs text-brand-primary mt-0.5 w-3.5 shrink-0"></i>
                                <span>{{ address.street }}</span>
                            </p>
                            <p class="flex items-start gap-2">
                                <i class="fas fa-city text-xs text-brand-primary mt-0.5 w-3.5 shrink-0"></i>
                                <span>{{ address.city }}{{ address.region ? ', ' + address.region : '' }}</span>
                            </p>
                            <p v-if="address.phone" class="flex items-start gap-2">
                                <i class="fas fa-phone text-xs text-brand-primary mt-0.5 w-3.5 shrink-0"></i>
                                <span>{{ address.phone }}</span>
                            </p>
                        </div>

                        <!-- ACTIONS -->
                        <div class="flex items-center gap-2 pt-2 border-t border-gray-50">
                            <button @click="openModal(address)"
                                class="flex-1 text-xs font-semibold text-neutral-muted hover:text-brand-primary py-2 rounded-lg hover:bg-brand-light/10 transition-all">
                                <i class="fas fa-pen text-[10px] mr-1"></i> Modifier
                            </button>
                            <button @click="confirmDelete(address.id)"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-300 hover:text-red-400 hover:bg-red-50 transition-all">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </main>
    </main>

    <!-- ─── MODAL ──────────────────────────────────────────────────────────── -->
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <!-- OVERLAY -->
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="closeModal" />

                <!-- PANEL -->
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">

                    <!-- HEADER -->
                    <div class="flex items-center justify-between px-7 pt-7 pb-5 border-b border-gray-100">
                        <div>
                            <h2 class="text-lg font-bold text-neutral-title">
                                {{ editingAddress ? 'Modifier l\'adresse' : 'Nouvelle adresse' }}
                            </h2>
                            <p class="text-xs text-neutral-muted mt-0.5">
                                {{ editingAddress ? 'Mettez à jour vos informations' : 'Renseignez votre point de livraison' }}
                            </p>
                        </div>
                        <button @click="closeModal"
                            class="w-9 h-9 rounded-xl border border-gray-200 flex items-center justify-center text-neutral-muted hover:bg-gray-50 transition-all">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <!-- FORM -->
                    <form @submit.prevent="submitForm" class="px-7 py-6 space-y-5">

                        <!-- TYPE SELECTOR -->
                        <div>
                            <label class="block text-xs font-semibold text-neutral-muted uppercase tracking-wider mb-2">
                                Type d'adresse
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <button v-for="type in addressTypes" :key="type.value" type="button"
                                    @click="form.type = type.value"
                                    class="flex flex-col items-center gap-2 py-3 px-2 rounded-xl border-2 transition-all text-sm font-semibold"
                                    :class="form.type === type.value
                                        ? 'border-brand-primary bg-brand-light/10 text-brand-primary'
                                        : 'border-gray-100 text-neutral-muted hover:border-gray-200'">
                                    <i :class="[type.icon, 'text-base']"></i>
                                    {{ type.label }}
                                </button>
                            </div>
                        </div>

                        <!-- LABEL + RECIPIENT -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2 md:col-span-1">
                                <label class="form-label">Libellé <span class="text-red-400">*</span></label>
                                <input v-model="form.label" type="text" placeholder="Ex : Maison principale"
                                    class="form-input" required />
                                <p v-if="form.errors.label" class="form-error">{{ form.errors.label }}</p>
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="form-label">Nom du destinataire <span
                                        class="text-red-400">*</span></label>
                                <input v-model="form.recipient_name" type="text" :placeholder="user.data.name"
                                    class="form-input" required />
                                <p v-if="form.errors.recipient_name" class="form-error">{{ form.errors.recipient_name }}
                                </p>
                            </div>
                        </div>

                        <!-- STREET -->
                        <div>
                            <label class="form-label">Rue / Quartier <span class="text-red-400">*</span></label>
                            <input v-model="form.street" type="text" placeholder="Ex : Rue des Palmiers, Quartier Akwa"
                                class="form-input" required />
                            <p v-if="form.errors.street" class="form-error">{{ form.errors.street }}</p>
                        </div>

                        <!-- CITY + REGION -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Ville <span class="text-red-400">*</span></label>
                                <input v-model="form.city" type="text" placeholder="Ex : Douala" class="form-input"
                                    required />
                                <p v-if="form.errors.city" class="form-error">{{ form.errors.city }}</p>
                            </div>
                            <div>
                                <label class="form-label">Région</label>
                                <input v-model="form.region" type="text" placeholder="Ex : Littoral"
                                    class="form-input" />
                            </div>
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label class="form-label">Téléphone de contact</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-neutral-muted text-sm font-medium"></span>
                                <input v-model="form.phone" type="tel" placeholder="+237 6XX XXX XXX"
                                    class="form-input pl-16" />
                            </div>
                            <p v-if="form.errors.phone" class="form-error">{{ form.errors.phone }}</p>
                        </div>

                        <!-- INSTRUCTIONS -->
                        <div>
                            <label class="form-label">Instructions de livraison <span
                                    class="text-neutral-muted font-normal">(optionnel)</span></label>
                            <textarea v-model="form.instructions" rows="2"
                                placeholder="Ex : Appeler à l'arrivée, portail bleu, 2ème étage..."
                                class="form-input resize-none"></textarea>
                        </div>

                        <!-- SUBMIT -->
                        <div class="flex gap-3 pt-2">
                            <button type="button" @click="closeModal"
                                class="flex-1 py-3 rounded-xl border border-gray-200 text-sm font-semibold text-neutral-muted hover:bg-gray-50 transition-all">
                                Annuler
                            </button>
                            <button type="submit" :disabled="form.processing"
                                class="flex-1 py-3 rounded-xl bg-brand-primary hover:bg-brand-hover text-white text-sm font-bold transition-all shadow-sm disabled:opacity-50 flex items-center justify-center gap-2">
                                <i v-if="form.processing" class="fas fa-circle-notch fa-spin text-xs"></i>
                                {{ editingAddress ? 'Enregistrer' : 'Ajouter l\'adresse' }}
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </Transition>
    </Teleport>

    <!-- DELETE CONFIRM MODAL -->
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="deleteTargetId !== null" class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="deleteTargetId = null" />
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-7 text-center">
                    <div
                        class="w-14 h-14 rounded-2xl bg-red-50 text-red-400 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h3 class="font-bold text-neutral-title text-lg mb-2">Supprimer l'adresse ?</h3>
                    <p class="text-sm text-neutral-muted mb-6">Cette action est irréversible.</p>
                    <div class="flex gap-3">
                        <button @click="deleteTargetId = null"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-neutral-muted hover:bg-gray-50 transition-all">
                            Annuler
                        </button>
                        <button @click="deleteAddress"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-bold transition-all">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script lang="ts" setup>
import { useForm, router, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import BuyerNavbar from "@/Components/Buyer/Navbar/BuyerNavbar.vue";
import BuyerSidebar from "@/Components/Buyer/Sidebar/BuyerSidebar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";
import { buyerAddressDestroy, buyerAddressStore, buyerAddressUpdate } from "@/routes";
// Importez vos routes Inertia ici
// import { addressStore, addressUpdate, addressDestroy, addressSetDefault } from "@/routes";

// ─── Types ────────────────────────────────────────────────────────────────────

type AddressType = "home" | "office" | "other";

interface Address {
    id: number;
    label: string;
    type: AddressType;
    recipient_name: string;
    street: string;
    city: string;
    region?: string;
    phone?: string;
    instructions?: string;
}

interface Props {
    addresses: {
        data: Address[];
    };
}

// ─── Props ────────────────────────────────────────────────────────────────────
const page = usePage();
const user = page.props.auth.user;
defineProps<Props>();

// ─── Sidebar ──────────────────────────────────────────────────────────────────

const buyerSidebarRef = ref<InstanceType<typeof BuyerSidebar> | null>(null);
const openSidebar = () => buyerSidebarRef.value?.toggleSidebar();

// ─── Types d'adresse ──────────────────────────────────────────────────────────

const addressTypes: { value: AddressType; label: string; icon: string }[] = [
    { value: "home", label: "Domicile", icon: "fas fa-home" },
    { value: "office", label: "Bureau", icon: "fas fa-briefcase" },
    { value: "other", label: "Autre", icon: "fas fa-map-marker-alt" },
];

// ─── Modal ────────────────────────────────────────────────────────────────────

const showModal = ref(false);
const editingAddress = ref<Address | null>(null);

const form = useForm({
    type: "home" as AddressType,
    label: "",
    recipient_name: "",
    street: "",
    city: "",
    region: "",
    phone: "",
    instructions: "",
});

const openModal = (address?: Address) => {
    if (address) {
        editingAddress.value = address;
        form.type = address.type;
        form.label = address.label;
        form.recipient_name = address.recipient_name;
        form.street = address.street;
        form.city = address.city;
        form.region = address.region ?? "";
        form.phone = address.phone ?? "";
        form.instructions = address.instructions ?? "";
    } else {
        editingAddress.value = null;
        form.reset();
        form.recipient_name = user.data.name;
    }

    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingAddress.value = null;
    form.reset();
};

const submitForm = () => {
    if (editingAddress.value) {
        // Modifier — remplacez par votre route Inertia
        form.put(buyerAddressUpdate.url(editingAddress.value.id), {
            preserveScroll: true,
            onSuccess: closeModal,
        });
    } else {
        // Créer — remplacez par votre route Inertia
        form.post(buyerAddressStore.url(), {
            preserveScroll: true,
            onSuccess: closeModal,
        });
    }
};


// ─── Suppression ──────────────────────────────────────────────────────────────

const deleteTargetId = ref<number | null>(null);

const confirmDelete = (id: number) => {
    deleteTargetId.value = id;
};

const deleteAddress = () => {
    if (deleteTargetId.value === null) {
        return;
    }

    router.delete(buyerAddressDestroy.url(deleteTargetId.value), {
        preserveScroll: true,

        onSuccess: () => {
            deleteTargetId.value = null;
        },
    });
};
</script>

<style scoped>
.form-label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--color-neutral-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.375rem;
}

.form-input {
    width: 100%;
    background-color: rgb(249 250 251);
    border: 1px solid rgb(229 231 235);
    border-radius: 0.75rem;
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: var(--color-neutral-text);
    transition: all 0.2s ease;
}

.form-input::placeholder {
    color: rgb(209 213 219);
}

.form-input:focus {
    outline: none;
    border-color: var(--color-brand-primary);
    box-shadow: 0 0 0 2px rgb(16 185 129 / 0.2);
}

.form-error {
    font-size: 0.75rem;
    color: rgb(239 68 68);
    margin-top: 0.25rem;
}

/* MODAL TRANSITION */
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.2s ease;
}

.modal-enter-active .relative,
.modal-leave-active .relative {
    transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
}

.modal-enter-from,
.modal-leave-to {
    opacity: 0;
}

.modal-enter-from .relative {
    transform: translateY(16px) scale(0.97);
    opacity: 0;
}

.modal-leave-to .relative {
    transform: translateY(8px) scale(0.98);
    opacity: 0;
}
</style>
