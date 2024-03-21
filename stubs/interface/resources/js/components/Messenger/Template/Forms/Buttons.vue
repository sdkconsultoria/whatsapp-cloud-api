<template>
    <div class="form-control">
        <label for="name">Botones</label>
        <details id="select-button" class="dropdown">
            <summary tabindex="0" role="button" class="btn m-1">
                <PlusIcon class="h-4 w-4" /> Agregar un botón
            </summary>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <span class="menu-title">Botones de respuesta rápida</span>
                <!-- <li @click="addButton('anime')"><a>Desactivar marketing</a></li> -->
                <li @click="addButton('QUICK_REPLY')"><a>Personalizado</a></li>
                <span class="menu-title">Botones de Llamada a la acción</span>
                <li @click="addButton('URL')"><a>Ir al sitio web</a></li>
                <li @click="addButton('PHONE_NUMBER')"><a>Llamar al número de teléfono</a></li>
                <!-- <li @click="addButton('anime')"><a>Copiar óodigo de oferta</a></li> -->
            </ul>
        </details>
    </div>

    <div v-if="quickReplyButtons">
        Respuesta Rápida
        <div v-for="(button, index) in quickReplyButtons">
            <QuickReply :field="button" :key="index" />
        </div>
        <div>
            Llamada a la acción
        </div>
        <div v-for="(button, index) in callToActionButtons">
            <PhoneNumber v-if="button.type === 'PHONE_NUMBER'" :field="button" :key="index" />
            <Url v-if="button.type === 'URL'" :field="button" :key="index" />
        </div>
    </div>
</template>

<script setup>
import { defineModel, computed } from 'vue'
import { PlusIcon } from '@heroicons/vue/24/outline';
import QuickReply from './Buttons/QuickReply.vue';
import PhoneNumber from './Buttons/PhoneNumber.vue';
import Url from './Buttons/Url.vue';

const model = defineModel('model')

function addButton(type) {
    if (model.value.buttons === undefined) {
        model.value.buttons = []
    }

    model.value.buttons.push({
        type: type,
        text: '',
    })

    document.getElementById('select-button').removeAttribute('open');
}

const quickReplyButtons = computed(() => {
    return model.value.buttons?.filter(button => button.type === 'QUICK_REPLY')
})

const callToActionButtons = computed(() => {
    return model.value.buttons?.filter(button => button.type === 'URL' || button.type === 'PHONE_NUMBER')
})

</script>
