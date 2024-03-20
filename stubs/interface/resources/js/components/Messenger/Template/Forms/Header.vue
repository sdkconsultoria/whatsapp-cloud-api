<template>
    <div class="form-control">
        <label for="header">Cabecera</label>
        <select v-model="model.components.header.type" id="header" class="select select-bordered w-ful">
            <option disabled selected>Tipo de Cabecera</option>
            <option value="TEXT">Texto</option>
            <option value="IMAGE">Imagen</option>
            <option value="VIDEO">Video</option>
            <option value="DOCUMENT">Documento</option>
            <option value="LOCATION">Ubicación</option>
        </select>
    </div>

    <div v-if="model.components.header.type === 'TEXT'" class="form-control">
        <label for="header-text">Texto</label>
        <input v-model="model.components.header.text" id="header-text" type="text" placeholder="Texto de la cabecera"
            class="input input-bordered w-full" />
    </div>

    <div v-if="model.components.header.type === 'IMAGE'" class="form-control">
        <label for="header-text">Imagen</label>
        <input @change="setFile" type="file" class="file-input file-input-bordered w-full" />
    </div>

    <div v-if="model.components.header.type === 'VIDEO'" class="form-control">
        <label for="header-text">Video</label>
        <input @change="setFile" type="file" class="file-input file-input-bordered w-full" />
    </div>

    <div v-if="model.components.header.type === 'DOCUMENT'" class="form-control">
        <label for="header-text">Documento</label>
        <input @change="setFile" type="file" class="file-input file-input-bordered w-full" />
    </div>
</template>

<script setup>
import { defineModel } from 'vue'
const model = defineModel('model')

function setFile(event) {
    model.value.components.header.file = event.target.files[0]
}
</script>
