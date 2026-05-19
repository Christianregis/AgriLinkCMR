<template>
    <div v-for="message in props.selectedConversation?.messages" :key="message.id" class="flex" :class="message.sender_id === user.data.id
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
                <a v-if="message.attachment_path" :href="message.attachment_path" target="_blank"
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
                    {{ formatDate(message.created_at) }}
                </span>

                <i v-if="message.read_at && message.sender_id === user.data.id"
                    class="fas fa-check-double text-[11px] text-blue-500"></i>

            </div>

        </div>

    </div>
</template>
<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import type { Conversation } from '@/types/Conversation';
import { formatDate } from '@/utils/formatDate';

const page = usePage();
const user = page.props.auth.user;

interface Props {
    selectedConversation: Conversation | null
}

const props = defineProps<Props>()
</script>
