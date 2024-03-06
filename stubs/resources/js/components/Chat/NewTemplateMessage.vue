<template>
    <h3 class="font-bold text-lg">Enviar Mensaje a un destinatario</h3>
    <div role="alert" class="alert shadow-lg mt-5 mb-5">
        <InformationCircleIcon class="h-6 w-6" />
        <span>Recuerda que para iniciar una conversación se debe hacer por medio de una plantilla</span>
    </div>
    <div>
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

        <div class="flex">
            <div class="mr-2">
                <label>Lada:</label>
                <select v-model="countryCode" class="select select-bordered w-full mb-4">
                    <option disabled selected>---</option>
                    <option value="521">+521</option>
                </select>
            </div>
            <div class="w-full">
                <label>Cliente:</label>
                <label class="input input-bordered flex items-center gap-2">
                    <PhoneIcon class="h-6 w-6" />
                    <input v-model="phone" type="text" class="grow" placeholder="Teléfono" />
                </label>
            </div>
        </div>
    </div>
    <div class="modal-action">
        <div class="flex flex-row-reverse">
            <form method="dialog">
                <button class="btn mr-2">Cancelar</button>
                <button class="btn btn-primary" @click="sentMessageTemplate">Enviar</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { InformationCircleIcon } from '@heroicons/vue/24/outline'
import { PhoneIcon } from '@heroicons/vue/24/solid'
import Swal from 'sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css';

getTemplates();
getWabaPhones();

const countryCode = ref('521')
const templates = ref('')
const template = ref('')
const wabaNumbers = ref('')
const wabaNumber = ref('')
const phone = ref('')

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

function sentMessageTemplate() {
    fetch('/api/v1/message/template/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            template: template.value,
            to: countryCode.value + phone.value,
            waba_phone: wabaNumber.value
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                Swal.fire({
                    title: 'Error!',
                    text: 'No se pudo enviar el mensaje',
                    icon: 'error',
                    confirmButtonText: 'Continuar'
                })
            }
            // Swal.fire({
            //     title: "Good job!",
            //     text: "You clicked the button!",
            //     icon: "success"
            // });
        })
        .catch((error) => {

        });
}
</script>
