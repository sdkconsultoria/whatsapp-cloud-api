<template>
    <div class="flex min-h-full h-full" style="height: 800px;">
        <div class="w-1/3 bg-base-200 overflow-auto h-full">
            <div class="p-2">
                <input type="text" placeholder="Buscar Chat" class="input w-full" />
            </div>
            <ul class="menu w-full p-0 overflow-auto">
                <li v-for="conversation in conversations" @click="setConversation(conversation)">
                    <a :class="{ active: conversation.id == current_conversation.id }">
                        {{ conversation.client_phone }}
                        <span v-if="conversation.unread_messages" class="indicator-item badge badge-secondary">{{conversation.unread_messages}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="w-2/3 pl-1">
            <div class="chat chat-start"></div>
            <div class="chat chat-end"></div>
            <div class="w-full overflow-auto h-full">
                <div :class="{ chat: true, 'chat-start': message.direction == 'toApp', 'chat-end': message.direction != 'toApp' }"
                    v-for="message in messages">
                    <div class="chat-header">
                        <time class="text-xs opacity-50">{{ convertTimestamp(message.timestamp) }}</time>
                    </div>
                    <div :class="{ 'chat-bubble': true, 'chat-bubble-primary': message.direction != 'toApp' }">
                        {{ message.text }}
                    </div>
                </div>
            </div>
            <div class="w-full flex mt-3">
                <div class="w-5/6 mr-1">
                    <input v-model="model" type="text" placeholder="Escribe un mensaje"
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
const model = ref('')

const conversations = ref('')
const current_conversation = ref({ id: 0 })
const messages = ref({})
const convertTimestamp = computed(() => {
    return (timestamp) => {
        const date = new Date(parseInt(timestamp * 1000));
        return date.toLocaleString();
    }
});
loadConversations();

async function loadConversations() {
    await fetch('/get-conversations')
        .then(response => response.json())
        .then(data => conversations.value = data);
    current_conversation.value = conversations.value[0];
    loadMessagesFromConversation();
}

function setConversation(conversation) {
    current_conversation.value = conversation;
    loadMessagesFromConversation();
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
                    "body": model.value
                }

            }
        })
    }).then(response => response.json())
        .then(data => {
            loadMessagesFromConversation();
        });
}

setTimeout(() => {
    window.Echo.channel(`new_whatsapp_message`)
        .listen('.Sdkconsultoria\\WhatsappCloudApi\\Events\\NewWhatsappMessageHook', (e) => {
            if (e.chat.chat_id == current_conversation.value.id) {
                loadMessagesFromConversation();
            }
        });
}, 1000);

</script>
