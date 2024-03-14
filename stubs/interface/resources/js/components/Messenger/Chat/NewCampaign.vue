<template>
    <h3 class="font-bold text-lg">Enviar Plantilla a multiples destinatario</h3>
    <div role="alert" class="alert shadow-lg mt-5 mb-5">
        <InformationCircleIcon class="h-6 w-6" />
        <span>Para enviar una plantilla a multiples destinatarios se debe hacer por medio de una campaña</span>
    </div>
    <div>
        <label>Campaña:</label>
        <input v-model="campaign" type="text" placeholder="Nombre de la campaña"
            class="input input-bordered w-full mb-4" />

        <label>Teléfono:</label>
        <select v-model="wabaNumber" class="select select-bordered w-full mb-4">
            <option disabled selected>---</option>
            <option :value="wabaNumber.id" v-for="wabaNumber in wabaNumbers ">{{ wabaNumber.display_phone_number }}
            </option>
        </select>

        <label>Plantilla:</label>
        <select v-model="template" class="select select-bordered w-full mb-4">
            <option disabled selected>---</option>
            <option :value="template.id" v-for="template in templates ">{{ template.name }}</option>
        </select>

        <label>Números telefonicos:</label>
        <input accept=".csv" ref="file" @change="uploadFile" type="file"
            class="file-input file-input-bordered w-full" />
        <small class="text-xs">El archivo debe ser .csv</small>
    </div>
    <div class="modal-action">
        <div class="flex flex-row-reverse">
            <form method="dialog">
                <button class="btn mr-2">Cancelar</button>
                <button class="btn btn-primary" @click="sentCampaign">Enviar</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { InformationCircleIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue'

getTemplates();
getWabaPhones();

const file = ref()
const campaign = ref()
const templates = ref('')
const template = ref('')
const wabaNumbers = ref('')
const wabaNumber = ref('')

function getWabaPhones() {
    fetch('/api/v1/waba-phone')
        .then(response => response.json())
        .then(data => {
            wabaNumbers.value = data.data;
        });
}

function getTemplates() {
    fetch('/api/v1/template?status=approved')
        .then(response => response.json())
        .then(data => {
            templates.value = data.data;
        });
}

function uploadFile(event) {
    file.value = event.target.files[0];
}

function sentCampaign() {
    const formdata = new FormData();
    formdata.append("name", campaign.value);
    formdata.append("template_id", template.value);
    formdata.append("waba_phone_id", wabaNumber.value);
    formdata.append("file", file.value);

    fetch('/api/v1/campaign', {
        method: 'POST',
        body: formdata,
    })
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                Swal.fire({
                    title: 'Error!',
                    text: 'No se pudo enviar la campaña',
                    icon: 'error',
                    confirmButtonText: 'Continuar'
                })
            }
        })
}
</script>
