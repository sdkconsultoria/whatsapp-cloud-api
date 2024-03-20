<template>
    <div class="flex gap-2 w-full">
        <div class="form-control w-1/3">
            <label for="name">Tipo de acción</label>
            <select v-model="field.type" class="select select-bordered w-full">
                <option value="PHONE_NUMBER">LLamar al número</option>
            </select>
        </div>
        <div class="form-control w-1/3">
            <label for="name">Texto del botón</label>
            <input v-model="field.text" id="header-text" type="text" class="input input-bordered w-full" />
        </div>
        <div class="form-control w-1/3">
            <label for="name">Número de teléfono</label>
            <input v-model="field.phone_number" id="header-text" type="text" class="input input-bordered w-full" />
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
