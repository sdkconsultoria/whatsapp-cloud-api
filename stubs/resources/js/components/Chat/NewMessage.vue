<template>
    <button class="btn btn-primary" onclick="my_modal_1.showModal()">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
    </button>
    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Enviar Nuevo Mensaje</h3>
            <div role="alert" class="alert shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    class="stroke-current shrink-0 w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>Recuerda que para iniciar una conversacion se debe hacer por medio de una plantilla</span>
            </div>
            <div class="mt-5">
                <select class="select select-bordered w-full max-w-xs">
                    <option disabled selected>Plantilla</option>
                    <option v-for="template in templates ">{{ template.name }}</option>
                </select>
            </div>
            <div class="modal-action">
                <button class="btn btn-primary">Enviar</button>
                <form method="dialog">
                    <button class="btn">Cancelar</button>
                </form>
            </div>
        </div>
    </dialog>
</template>
<script setup>
import { ref, computed } from 'vue'

getTemplates();
console.log('getTemplates');
const templates = ref('')

function getTemplates() {
    fetch('/template?status=approved')
        .then(response => response.json())
        .then(data => {
            templates.value = data.data;
        });
}
</script>
