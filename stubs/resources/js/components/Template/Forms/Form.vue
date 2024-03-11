<template>
    <div class="form-control">
            <label for="category">Categoría</label>
            <select v-model="model.category" id="category" class="select select-bordered w-ful">
                <option disabled selected>Categoría de la plantilla</option>
                <option value="AUTHENTICATION">Autenticación</option>
                <option value="MARKETING">Marketing</option>
                <option value="UTILITY">Utilidad</option>
            </select>
        </div>
        <div class="form-control">
            <label for="name">Nombre</label>
            <input v-model="model.name" id="name" type="text" placeholder="Nombre de la plantilla"
                class="input input-bordered w-ful" />
        </div>
        <div class="form-control">
            <label for="name">Idioma</label>
            <select v-model="model.language" id="language" class="select select-bordered w-ful">
                <option disabled selected>Categoría de la plantilla</option>
                <option value="es">Español</option>
                <option value="es_AR">Español (Argentina)</option>
                <option value="es_ES">Español (España)</option>
                <option value="es_MX">Español (México)</option>
            </select>
        </div>
        <div class="form-control">
            <label for="body">Cuerpo del mensaje</label>
            <textarea v-model="model.body"  id="body" class="textarea textarea-bordered w-ful resize-none" placeholder=""></textarea>
        </div>
</template>
<script setup>
const model = defineModel('model')

</script>
