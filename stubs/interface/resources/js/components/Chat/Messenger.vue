<template>
    <div class="flex min-h-full h-full" style="height: 800px;">
        <div class="w-1/3 bg-base-200 overflow-auto h-full">
            <div class="p-2 flex">
                <input @change="loadConversations" v-model="search" type="text" placeholder="Buscar Chat"
                    class="input w-full" />
                <SendNew />
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
                    <ChatBubble :key="message.id" :message="message" />
                </div>
            </div>
            <div class="w-full flex mt-3">
                <SendMediaMessage @sendMessage="sendMediaMessage" />
                <div class="w-5/6 mr-1">
                    <input v-model="message" type="text" placeholder="Escribe un mensaje" @keyup.enter="sendMessage"
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
import { ref } from 'vue'
import SendNew from './SendNew.vue';
import SendMediaMessage from './SendMediaMessage.vue';
import ChatBubble from './ChatBubble.vue';

const message = ref('')
const search = ref('')
const conversations = ref('')
const current_conversation = ref({ id: 0 })
const messages = ref({})

loadConversations();

async function loadConversations() {
    await fetch('/api/v1/chat?client_phone=' + search.value)
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
    await fetch('/api/v1/message?chat_id=' + current_conversation.value.id)
        .then(response => response.json())
        .then(data => messages.value = data.data);
}

function sendMessage() {
    fetch('/api/v1/message/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            waba_phone_id: current_conversation.value.waba_phone_id,
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

function sendMediaMessage(file, type) {
    const formdata = new FormData();
    formdata.append("waba_phone_id", current_conversation.value.waba_phone_id);
    formdata.append("to", current_conversation.value.client_phone,);
    formdata.append("message[type]", type);
    formdata.append(`message[${type}]`, file);
    console.log(formdata);
    fetch('/api/v1/message/send', {
        method: 'POST',
        body: formdata,
    }).then(response => response.json())
        .then(data => {
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
