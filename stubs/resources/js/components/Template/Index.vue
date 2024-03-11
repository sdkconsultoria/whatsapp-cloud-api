<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li>
                <span class="inline-flex gap-2 items-center">
                    <FolderIcon class="h-4 w-4" /> Platillas de whatsapp
                </span>
            </li>
        </ul>
    </div>

    <div class="flex mt-4 mb-4">
        <label class="input input-bordered flex items-center gap-2 w-64">
            <input v-model="search" type="text" class="grow w-full" placeholder="Buscar plantilla" @change="loadData()" />
            <MagnifyingGlassIcon class="h-4 w-4" />
        </label>

        <div class="flex items-center gap-2 ml-auto">
            <button class="btn btn-warning">Búsqueda avazada</button>
            <a href="template/create" class="btn btn-primary">Crear Nueva plantilla</a>
        </div>
    </div>
    <!-- <div>
        <div class="flex flex-row">
            <button class="items-center rounded-l-lg shadow-md p-1 bg-warning mb-2 flex flex-row">
                <ArrowPathIcon class="h-4 w-4" /> Limpiar
            </button>
            <button class="items-center rounded-r-lg shadow-md p-1 bg-info mb-2 flex flex-row">
                <MagnifyingGlassIcon class="h-4 w-4" /> Buscar
            </button>
        </div>
    </div> -->
    <div class="overflow-x-auto">
        <table class="table table-fixed">
            <thead>
                <tr>
                    <th class="w-8"></th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Idioma</th>
                    <th>Estatus</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in response.data">
                    <td>{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.category }}</td>
                    <td>{{ item.language }}</td>
                    <td>{{ item.status }}</td>
                    <td class="flex gap-1">
                        <a :href="'/templates/'+item.id"><button><EyeIcon class="h-4 w-4"/></button></a>
                        <a :href="'/templates/'+item.id"><button><PencilSquareIcon class="h-4 w-4"/></button></a>
                        <a :href="'/templates/'+item.id"><button><TrashIcon class="h-4 w-4"/></button></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex flex-row-reverse mt-2">
        <div class="join">
            <button class="join-item btn" :disabled="response.links?.prev == null" @click="loadData(response.links?.prev)">«</button>
            <button class="join-item btn">Página {{ response.meta?.current_page }}</button>
            <button class="join-item btn" :disabled="response.links?.next == null" @click="loadData(response.links?.next)">»</button>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import { FolderIcon, MagnifyingGlassIcon, ArrowPathIcon, PencilSquareIcon, TrashIcon, EyeIcon} from '@heroicons/vue/24/outline';

const response = ref('');
const search = ref('');
const url = '/api/v1/template';

loadData();
function loadData(link = null) {
    fetch(link??`${url}?name=${search.value}`)
        .then(response => response.json())
        .then(json => response.value = json);
}
</script>
