<template>
    <button class="btn btn-primary" onclick="my_modal_1.showModal()">
        <PlusCircleIcon class="h-6 w-6"  />
    </button>
    <dialog id="my_modal_1" class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Enviar Nuevo Mensaje</h3>
            <div role="alert" class="alert shadow-lg mt-5 mb-5">
                <InformationCircleIcon class="h-6 w-6"  />
                <span>Recuerda que para iniciar una conversación se debe hacer por medio de una plantilla</span>
            </div>
            <div class="">
                <select class="select select-bordered w-full mb-2">
                    <option disabled selected>---</option>
                    <option v-for="template in templates ">{{ template.name }}</option>
                </select>

                <label class="input input-bordered flex items-center gap-2">
                    <PhoneIcon class="h-6 w-6"  />
                    <input type="text" class="grow" placeholder="Teléfono" />
                </label>
            </div>
            <div class="modal-action">
                <div class="flex flex-row-reverse">
                    <button class="btn btn-primary">Enviar</button>
                    <form method="dialog">
                        <button class="btn mr-2">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>
</template>
<script setup>
import { ref, computed } from 'vue'
import { InformationCircleIcon, PlusCircleIcon} from '@heroicons/vue/24/outline'
import { PhoneIcon} from '@heroicons/vue/24/solid'

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
