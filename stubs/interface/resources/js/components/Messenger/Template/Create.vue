<template>
    <Breadcrumb :breadcrumbs="breadcrumbs" />
    <div class="flex">
        <form @submit.prevent="submit" class="flex flex-col gap-2 w-2/3">
            <FormModel v-model:model="model"></FormModel>
            <button class="btn btn-primary w-ful">Crear Plantilla</button>
        </form>
        <div class="w-1/3">
            <TemplatePreview :model="model" />
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Breadcrumb from '../Ui/Breadcrumb.vue';
import FormModel from './Forms/Form.vue';
import TemplatePreview from './Preview/Index.vue';

const model = ref({
    components: {
        header: { },
        body: { text: null },
        footer: {},
        buttons: [],
    },
});

const breadcrumbs = [
    { link: '/template', label: 'Plantillas de whatsapp' },
    { label: 'Crear Plantilla' }
];

async function submit() {
    const response = await fetch('/api/v1/template', {
        method: 'POST',
        body: convertJsonToFormData(model.value)
    });

    if (response.ok) {
        alert('Plantilla creada con éxito');
    }
}

function convertJsonToFormData(json) {
    const formData = new FormData();
    appendObjectToFormData(formData, json);
    return formData;
}

function appendObjectToFormData(formData, object, prefix = null) {
    for (const key in object) {
        let newPrefix = prefix ? `${prefix}[${key}]` : key;
        if (object[key] instanceof File) {
            formData.append(newPrefix, object[key]);
        } else if (object[key] instanceof Object) {
            appendObjectToFormData(formData, object[key], newPrefix);
        } else {
            formData.append(newPrefix, object[key]);
        }
    }
}
</script>
