<template>
    <div class="form-control">
        <label for="waba">Waba</label>
        <select v-model="model.waba_id" id="waba" class="select select-bordered w-ful">
            <option disabled selected>Selecciona una Waba</option>
            <option v-for="waba in wabas" :value="waba.id">{{waba.name}}</option>
        </select>
    </div>
    <div class="form-control">
        <label for="category">Categoría</label>
        <select v-model="model.category" id="category" class="select select-bordered w-ful">
            <option disabled selected>Categoría de la plantilla</option>
            <option value="MARKETING">Marketing</option>
            <option value="UTILITY">Utilidad</option>
            <option value="AUTHENTICATION">Autenticación</option>
        </select>
    </div>
    <div class="form-control">
        <label for="name">Nombre</label>
        <input v-model="model.name" id="name" type="text" placeholder="Nombre de la plantilla"
            class="input input-bordered w-ful" />
    </div>
    <div class="form-control">
        <label for="language">Idioma</label>
        <select v-model="model.language" id="language" class="select select-bordered w-ful">
            <option disabled selected>Categoría de la plantilla</option>
            <option value="es">Español</option>
            <option value="es_AR">Español (Argentina)</option>
            <option value="es_ES">Español (España)</option>
            <option value="es_MX">Español (México)</option>
        </select>
    </div>

    <Header v-model:model="model" />

    <div class="form-control">
        <label for="body">Cuerpo del mensaje</label>
        <textarea v-model="model.components.body.text" id="body" class="textarea textarea-bordered w-ful resize-none"
            placeholder=""></textarea>
    </div>

    <Footer v-model:model="model" />

    <Buttons v-model:model="model.components.buttons" />
</template>
<script setup>
import Header from './Header.vue'
import Footer from './Footer.vue'
import Buttons from './Buttons.vue'

const model = defineModel('model')
const wabas = defineModel()

getWaba();
function getWaba() {
    fetch('/api/v1/waba')
        .then(response => response.json())
        .then(data => {
            wabas.value = data.data;
        })
        .catch(error => {
            console.error('Error:', error)
        })
}
</script>
