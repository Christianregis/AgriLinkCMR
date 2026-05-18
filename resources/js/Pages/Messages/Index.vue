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
            <div class="flex-1 overflow-hidden p-4 md:p-8">

                <div class="h-full bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex">

                    <!-- CONVERSATIONS SIDEBAR -->
                    <aside class="w-full md:w-90 border-r border-gray-100 flex flex-col bg-white"
                        :class="selectedConversation ? 'hidden md:flex' : 'flex'">

                        <!-- HEADER -->
                        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl font-bold text-neutral-title">
                                    Messages
                                </h2>

                                <p class="text-sm text-neutral-muted mt-1">
                                    Discutez avec vos agriculteurs
                                </p>
                            </div>

                            <div
                                class="w-10 h-10 rounded-xl bg-brand-light/20 text-brand-primary flex items-center justify-center">
                                <i class="fas fa-comments"></i>
                            </div>
                        </div>

                        <!-- SEARCH -->
                        <div class="p-4 border-b border-gray-100">
                            <div class="relative">
                                <i
                                    class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>

                                <input type="text" placeholder="Rechercher une conversation..."
                                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary transition-all" />
                            </div>
                        </div>

                        <!-- CONVERSATIONS -->
                        <!-- ✅ UPDATE SIDEBAR CONVERSATIONS -->

                        <div class="flex-1 overflow-y-auto">

                            <button v-for="conversation in conversations" :key="conversation.id"
                                @click="selectConversation(conversation)"
                                class="w-full px-5 py-4 border-b border-gray-50 transition-all hover:bg-[#F8FAF9] text-left relative"
                                :class="selectedConversation?.id === conversation.id
                                    ? 'bg-brand-bg'
                                    : ''">

                                <!-- ARCHIVED BADGE -->
                                <div v-if="conversation.is_archived"
                                    class="absolute top-4 right-4 text-[10px] font-bold bg-gray-100 text-gray-500 px-2 py-1 rounded-full">
                                    Archivé
                                </div>

                                <div class="flex items-start gap-4">

                                    <!-- AVATAR -->
                                    <div class="relative shrink-0">

                                        <img :src="'/storage/'+conversation.farmer.profile_photo"
                                            class="w-14 h-14 rounded-2xl object-cover border border-gray-100" />

                                        <span
                                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>

                                    </div>

                                    <!-- CONTENT -->
                                    <div class="flex-1 min-w-0">

                                        <!-- TOP -->
                                        <div class="flex items-center justify-between gap-3">

                                            <h3 class="font-semibold text-neutral-title truncate">
                                                {{ conversation.farmer.name }}
                                            </h3>

                                            <span class="text-[11px] text-neutral-muted whitespace-nowrap">
                                                {{
                                                    conversation.last_message_at
                                                        ? conversation.last_message_at
                                                        : ''
                                                }}
                                            </span>

                                        </div>

                                        <!-- PRODUCT -->
                                        <div v-if="conversation.product" class="flex items-center gap-2 mt-2">

                                            <div class="w-8 h-8 rounded-lg overflow-hidden bg-gray-100">
                                                <img v-if="conversation.product.image" :src="conversation.product.image"
                                                    class="w-full h-full object-cover" />
                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-[12px] font-semibold text-brand-primary truncate">
                                                    {{ conversation.product.name }}
                                                </p>

                                                <p v-if="conversation.product.price"
                                                    class="text-[11px] text-accent-cta font-bold">
                                                    {{ conversation.product.price }} FCFA
                                                </p>

                                            </div>

                                        </div>

                                        <!-- LAST MESSAGE -->
                                        <div class="flex items-center justify-between gap-3 mt-3">

                                            <p class="text-sm text-neutral-muted truncate">
                                                {{ conversation.last_message }}
                                            </p>

                                            <!-- UNREAD -->
                                            <div v-if="conversation.unread_count && conversation.unread_count > 0"
                                                class="min-w-5.5 h-5.5 rounded-full bg-brand-primary text-white text-[11px] font-bold flex items-center justify-center px-1">
                                                {{ conversation.unread_count }}
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </button>

                        </div>
                    </aside>

                    <!-- CHAT AREA -->
                    <section class="flex-1 flex flex-col bg-[#FCFDFC]"
                        :class="selectedConversation ? 'flex' : 'hidden md:flex'">

                        <!-- EMPTY STATE -->
                        <div v-if="!selectedConversation" class="flex-1 flex flex-col items-center justify-center px-8">

                            <div
                                class="w-24 h-24 rounded-full bg-brand-light/10 text-brand-primary flex items-center justify-center text-4xl mb-6">
                                <i class="fas fa-paper-plane"></i>
                            </div>

                            <h2 class="text-2xl font-bold text-neutral-title mb-3">
                                Vos conversations
                            </h2>

                            <p class="text-neutral-muted text-center max-w-md leading-relaxed">
                                Sélectionnez une conversation pour commencer à
                                discuter avec un agriculteur.
                            </p>

                        </div>

                        <!-- CHAT -->
                        <template v-else>

                            <!-- CHAT HEADER -->

                            <div class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between">

                                <div class="flex items-center gap-4">

                                    <!-- MOBILE BACK -->
                                    <button @click="selectedConversation = null"
                                        class="md:hidden w-10 h-10 rounded-xl border border-gray-200 flex items-center justify-center">
                                        <i class="fas fa-arrow-left"></i>
                                    </button>

                                    <!-- FARMER -->
                                    <img :src="'/storage/'+selectedConversation.farmer.profile_photo"
                                        class="w-12 h-12 rounded-2xl object-cover" />

                                    <div>

                                        <div class="flex items-center gap-3">

                                            <h3 class="font-bold text-neutral-title">
                                                {{ selectedConversation.farmer.name }}
                                            </h3>

                                            <span v-if="selectedConversation.is_archived"
                                                class="text-[10px] font-bold bg-gray-100 text-gray-500 px-2 py-1 rounded-full">
                                                Archivé
                                            </span>

                                        </div>

                                        <!-- PRODUCT -->
                                        <div v-if="selectedConversation.product" class="flex items-center gap-2 mt-1">

                                            <i class="fas fa-leaf text-green-600 text-xs"></i>

                                            <p class="text-sm text-neutral-muted">
                                                {{ selectedConversation.product.name }}
                                            </p>

                                            <span v-if="selectedConversation.product.price"
                                                class="text-accent-cta font-semibold text-sm">
                                                • {{ selectedConversation.product.price }} FCFA
                                            </span>

                                        </div>

                                    </div>

                                </div>

                                <!-- ACTIONS -->
                                <div class="flex items-center gap-2">

                                    <button
                                        class="w-11 h-11 rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all flex items-center justify-center">
                                        <i class="fas fa-phone text-neutral-muted"></i>
                                    </button>

                                    <button
                                        class="w-11 h-11 rounded-2xl border border-gray-200 hover:bg-gray-50 transition-all flex items-center justify-center">
                                        <i class="fas fa-ellipsis-v text-neutral-muted"></i>
                                    </button>

                                </div>

                            </div>

                            <!-- MESSAGES -->
                            <div ref="messagesContainer" class="flex-1 overflow-y-auto px-4 md:px-6 py-6 space-y-4">

                                <div v-for="message in selectedConversation.messages" :key="message.id" class="flex"
                                    :class="message.sender_id === user.data.id
                                        ? 'justify-end'
                                        : 'justify-start'">

                                    <div class="max-w-[85%] md:max-w-[70%]">

                                        <!-- MESSAGE -->
                                        <div class="rounded-3xl px-5 py-4 shadow-sm" :class="message.sender_id === user.data.id
                                            ? 'bg-brand-primary text-white rounded-br-md'
                                            : 'bg-white border border-gray-100 text-neutral-text rounded-bl-md'">

                                            <!-- BODY -->
                                            <p class="text-[15px] leading-relaxed whitespace-pre-line">
                                                {{ message.body }}
                                            </p>

                                            <!-- ATTACHMENT -->
                                            <a v-if="message.attachment_path" :href="message.attachment_path"
                                                target="_blank"
                                                class="mt-4 flex items-center gap-3 bg-black/5 rounded-2xl px-4 py-3 text-sm font-medium">
                                                <i class="fas fa-paperclip"></i>
                                                Pièce jointe
                                            </a>

                                        </div>

                                        <!-- META -->
                                        <div class="flex items-center gap-2 mt-2 px-2" :class="message.sender_id === user.data.id
                                            ? 'justify-end'
                                            : 'justify-start'">

                                            <span class="text-[11px] text-neutral-muted">
                                                {{ message.created_at }}
                                            </span>

                                            <i v-if="message.read_at && message.sender_id === user.data.id"
                                                class="fas fa-check-double text-[11px] text-blue-500"></i>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- INPUT -->
                            <div class="bg-white border-t border-gray-100 p-4 md:p-5">

                                <form @submit.prevent="submit" class="flex items-end gap-3">

                                    <!-- FILE -->
                                    <label
                                        class="w-12 h-12 rounded-2xl border border-gray-200 hover:bg-gray-50 flex items-center justify-center cursor-pointer transition-all">
                                        <i class="fas fa-paperclip text-neutral-muted"></i>

                                        <input type="file" class="hidden" @change="handleFile" />
                                    </label>

                                    <!-- TEXTAREA -->
                                    <div class="flex-1 relative">

                                        <textarea v-model="form.body" rows="1" placeholder="Écrivez votre message..."
                                            class="w-full resize-none rounded-3xl border border-gray-200 bg-gray-50 px-5 py-4 pr-14 text-[15px] focus:outline-none focus:ring-2 focus:ring-brand-primary/20 focus:border-brand-primary transition-all"></textarea>

                                        <button type="submit" :disabled="form.processing"
                                            class="absolute right-3 bottom-3 w-10 h-10 rounded-2xl bg-brand-primary hover:bg-brand-hover text-white flex items-center justify-center transition-all shadow-sm disabled:opacity-50">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </template>

                    </section>

                </div>

            </div>

        </main>
    </main>
</template>

<script lang="ts" setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import BuyerNavbar from "@/Components/Buyer/Navbar/BuyerNavbar.vue";
import BuyerSidebar from "@/Components/Buyer/Sidebar/BuyerSidebar.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

interface Message {
    id: number;
    conversation_id: number;
    sender_id: number;
    body: string;
    attachment_path?: string;
    read_at?: string;
    created_at: string;
}

interface Farmer {
    id: number;
    name: string;
    profile_photo: string;
}


interface Product {
    id: number;
    name: string;
    image?: string;
    price?: number;
}

interface Conversation {
    id: number;
    farmer_id: number;
    buyer_id: number;
    product_id?: number | null;
    last_message_at?: string | null;
    is_archived: boolean;
    created_at: string;
    updated_at: string;

    farmer: Farmer;
    product?: Product | null;

    messages: Message[];

    last_message?: string;
    unread_count?: number;
}

interface Props {
    conversations: Conversation[];
}

defineProps<Props>();


const buyerSidebarRef = ref<InstanceType<typeof BuyerSidebar> | null>(null);

const openSidebar = () => {
    buyerSidebarRef.value?.toggleSidebar();
};

// const selectedConversation = ref<Conversation | null>(
//     props.conversations[0] ?? null
// );

const selectedConversation = ref<Conversation | null>(
    null
);


const form = useForm({
    body: "",
    attachment: null as File | null,
});

const handleFile = (e: Event) => {
    const target = e.target as HTMLInputElement;

    if (target.files?.length) {
        form.attachment = target.files[0];
    }
};

const submit = () => {
    if (!selectedConversation.value) {
        return;
    }

    form.post(
        `/buyer/messages/${selectedConversation.value.id}`,
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
            },
        }
    );
};

const selectConversation = (conversation: Conversation) => {
    selectedConversation.value = conversation;
};

const page = usePage();
const user = page.props.auth.user;
</script>

<style scoped>
body {
    font-family: "Inter", sans-serif;
}

textarea::-webkit-scrollbar {
    width: 4px;
}

textarea::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 999px;
}
</style>
