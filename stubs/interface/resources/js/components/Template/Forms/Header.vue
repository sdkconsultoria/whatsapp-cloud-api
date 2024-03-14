<template>
    <div class="form-control">
        <label for="header">Cabecera</label>
        <select v-model="model.components.header.type" id="header" class="select select-bordered w-ful">
            <option disabled selected>Tipo de Cabecera</option>
            <option value="text">Texto</option>
            <option value="image">Imagen</option>
            <option value="video">Video</option>
            <option value="dodument">Documento</option>
            <option value="ubication">Ubicación</option>
        </select>
    </div>

    <div v-if="model.components.header.type === 'text'" class="form-control">
        <label for="header-text">Texto</label>
        <input v-model="model.components.header.text" id="header-text" type="text" placeholder="Texto de la cabecera"
            class="input input-bordered w-full" />
    </div>

    <div v-if="model.components.header.type === 'image'" class="form-control">
        <label for="header-text">Imagen</label>
        <input type="file" class="file-input file-input-bordered w-full" />
    </div>

    <div v-if="model.components.header.type === 'video'" class="form-control">
        <label for="header-text">Video</label>
        <input type="file" class="file-input file-input-bordered w-full" />
    </div>

    <div v-if="model.components.header.type === 'dodument'" class="form-control">
        <label for="header-text">Documento</label>
        <input type="file" class="file-input file-input-bordered w-full" />
    </div>
</template>

<script setup>
import { defineModel } from 'vue'
const model = defineModel('model')
</script>
