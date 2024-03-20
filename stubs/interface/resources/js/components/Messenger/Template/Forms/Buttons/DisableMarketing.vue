<template>
    <div class="flex gap-2 w-full">
        <div class="form-control w-1/3">
            <label for="name">Tipo</label>
            <select v-model="field.type" class="select select-bordered w-ful">
                <option value="QUICK_REPLY">Desactivar marketing</option>
            </select>
        </div>
        <div class="form-control w-1/3">
            <label for="name">Texto del botón</label>
            <input id="header-text" type="text" class="input input-bordered w-full" />
        </div>
        <div class="form-control w-1/3">
            <label for="name">Texto de pie de página</label>
            <input id="header-text" type="text" class="input input-bordered w-full" />
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
