<template>
    <div class="form-control">
        <label for="name">Pie de página</label>
        <input v-model="model.components.footer.text" id="name" type="text" placeholder="Pie de página"
            class="input input-bordered w-ful" />
    </div>
</template>

<script setup>
import { defineModel } from 'vue'
const model = defineModel('model')
</script>
