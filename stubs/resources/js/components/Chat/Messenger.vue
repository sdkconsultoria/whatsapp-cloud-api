<template>
    <div class="flex min-h-full h-full" style="height: 800px;">
        <div class="w-1/3 bg-base-200 overflow-auto h-full">
            <div class="p-2 flex">
                <input @change="loadConversations" v-model="search" type="text" placeholder="Buscar Chat"
                    class="input w-full" />
                    <NewMessage />
            </div>
            <ul class="menu w-full p-0 overflow-auto">
                <li v-for="conversation in conversations" @click="setConversation(conversation)">
                    <a :class="{ active: conversation.id == current_conversation.id }">
                        {{ conversation.client_phone }}
                        <span v-if="conversation.unread_messages" class="indicator-item badge badge-secondary">{{
                            conversation.unread_messages }}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="w-2/3">
            <div class="bg-base-200 p-4">{{ current_conversation.client_phone }}</div>
            <div class="chat chat-start"></div>
            <div class="chat chat-end"></div>
            <div class="w-full overflow-auto h-full">
                <div :class="{ chat: true, 'chat-start': message.direction == 'toApp', 'chat-end': message.direction != 'toApp' }"
                    v-for="message in messages">
                    <div class="chat-header">
                        <span v-if="message.sended_by">Enviado por: {{ message.sended_by }}</span> <time class="text-xs opacity-50">{{ convertTimestamp(message.timestamp) }}</time>
                    </div>
                    <div :class="{ 'chat-bubble': true, 'chat-bubble-primary': message.direction != 'toApp' }">
                        <span v-if="message.type == 'text'">{{ message.text }}</span>
                        <span v-if="message.type == 'image'">
                            {{ message.content.caption }}
                            <img :src="message.content.url" alt="" class="w-1/6" />
                        </span>

                    </div>
                </div>
            </div>
            <div class="w-full flex mt-3">
                <div class="flex justify-center items-center">
                    <PaperClipIcon class="h-8 w-8" />
                </div>
                <div class="w-5/6 mr-1">
                    <input v-model="message" type="text" placeholder="Escribe un mensaje"
                        class="input border-1 border-gray-200 w-full" />
                </div>
                <div class="w-1/6">
                    <button class="btn btn-primary w-full" @click="sendMessage">Enviar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import NewMessage from './NewMessage.vue';
import { PaperClipIcon} from '@heroicons/vue/24/solid'

const message = ref('')
const search = ref('')

const conversations = ref('')
const current_conversation = ref({ id: 0 })
const messages = ref({})
const convertTimestamp = computed(() => {
    return (timestamp) => {
        const date = new Date(parseInt(timestamp * 1000));
        return date.toLocaleString('es-MX');
    }
});
loadConversations();

async function loadConversations() {
    await fetch('/get-conversations?client_phone=' + search.value)
        .then(response => response.json())
        .then(data => conversations.value = data.data);

    if (current_conversation.value.id == 0) {
        current_conversation.value = conversations.value[0];
        loadMessagesFromConversation();
    }
}

function setConversation(conversation) {
    current_conversation.value = conversation;
    loadMessagesFromConversation();
    loadConversations();
}

async function loadMessagesFromConversation() {
    await fetch('/message?chat_id=' + current_conversation.value.id)
        .then(response => response.json())
        .then(data => messages.value = data.data);
}

function sendMessage() {
    fetch('/message/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            phone_id: current_conversation.value.waba_phone,
            to: current_conversation.value.client_phone,
            message: {
                "type": "text",
                "text": {
                    "preview_url": false,
                    "body": message.value
                }

            }
        })
    }).then(response => response.json())
        .then(data => {
            message.value = '';
            loadMessagesFromConversation();
        });
}

setTimeout(() => {
    window.Echo.channel(`new_whatsapp_message`)
        .listen('.Sdkconsultoria\\WhatsappCloudApi\\Events\\NewWhatsappMessageHook', (e) => {
            loadConversations();
            if (e.chat.chat_id == current_conversation.value.id) {
                loadMessagesFromConversation();
            }
        });
}, 1000);

</script>
