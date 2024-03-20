<template>
    <div class="flex gap-2 w-full">
        <div class="form-control w-1/3">
            <label for="name">Tipo de acción</label>
            <select v-model="field.type" class="select select-bordered w-full">
                <option value="URL">Ir al sitio web</option>
            </select>
        </div>
        <div class="form-control w-1/3">
            <label for="name">Texto del botón</label>
            <input v-model="field.text" id="header-text" type="text" class="input input-bordered w-full" />
        </div>
        <div class="form-control w-1/3">
            <label for="name">Tipo de url</label>
            <select v-model="field.isDynamic" class="select select-bordered w-full">
                <option selected :value="false">Estática</option>
                <option :value="true">Dinámica</option>
            </select>
        </div>
        <div class="form-control w-1/3">
            <label for="name">Url del sitio web</label>
            <input v-model="field.url" id="header-text" type="text" class="input input-bordered w-full" />
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    field: {
        type: Object,
        required: true
    }
})
</script>
