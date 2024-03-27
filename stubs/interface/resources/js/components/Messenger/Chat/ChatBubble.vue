<template>
    <div class="chat-header">
        <span v-if="message.sended_by">Enviado por: {{ message.sended_by }}</span> <time class="text-xs opacity-50">{{
            convertTimestamp(message.timestamp) }}</time>
    </div>
    <div :class="{ 'chat-bubble': true, 'chat-bubble-primary': message.direction != 'toApp' }">
        <div class="indicator w-11/12">
            <span v-if="message.reaction" class="indicator-item indicator-start badge badge-secondary indicator-bottom"
                style="bottom: -10px;">{{ message.reaction }}</span>
            <span v-if="message.type == 'text'">{{ message.content }}</span>
            <span v-if="message.type == 'image'">
                {{ message.content.caption }}
                <img :src="message.content.url" alt="" class="w-1/6" />
            </span>
            <span v-if="message.type == 'sticker'">
                <img :src="message.content.url" alt="" class="w-1/6" />
            </span>
            <span v-if="message.type == 'video'">
                {{ message.content.caption }}
                <video :src="message.content.url" alt="" class="w-2/6" controls />
            </span>
            <span v-if="message.type == 'audio'">
                <audio :src="message.content.url" alt="" controls />
            </span>
            <span v-if="message.type == 'document'">
                <button class="btn btn-primary"> <a :href="message.content.url" download> Descargar
                        Archivo </a> </button>
            </span>
            <span v-if="message.type == 'contacts'">
                <ul v-for="contact in message.content">
                    <li>Nombre: {{ contact.name.first_name }}</li>
                    <li>Telefonos:
                        <span v-for="phone in contact.phones">{{ phone.phone }}</span>
                    </li>
                </ul>
            </span>

            <span v-if="message.type == 'template'">
                <Template :content="message.content" />
            </span>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import Template from './Template.vue';

const props = defineProps({
    message: Object
})

const convertTimestamp = computed(() => {
    return (timestamp) => {
        const date = new Date(parseInt(timestamp * 1000));
        return date.toLocaleString('es-MX');
    }
});

</script>
