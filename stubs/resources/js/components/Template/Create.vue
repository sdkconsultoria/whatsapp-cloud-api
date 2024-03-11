<template>
    <Breadcrumb :breadcrumbs="breadcrumbs" />
    <form @submit.prevent="submit" class="flex flex-col gap-2 max-w-xs">
        <FormModel v-model:model="model"></FormModel>
        <button class="btn btn-primary w-ful">Crear Plantilla</button>
    </form>
</template>
<script setup>
import { ref } from 'vue';
import Breadcrumb from '../Ui/Breadcrumb.vue';
import FormModel from './Forms/Form.vue';

const model = ref({});
const breadcrumbs = [
    { link: '/template', label: 'Plantillas de whatsapp' },
    { label: 'Crear Plantilla' }
];

async function submit() {
    const response = await fetch('/api/v1/template', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(model.value)
    });

    if (response.ok) {
        alert('Plantilla creada con éxito');
    }
}
</script>
