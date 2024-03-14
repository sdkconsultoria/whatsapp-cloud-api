<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li :href="url">
                <a>
                    <FolderIcon class="h-4 w-4" /> Plantillas
                </a>
            </li>
            <li>
                <span class="inline-flex gap-2 items-center">
                    <FolderIcon class="h-4 w-4" /> Crear plantilla
                </span>
            </li>
        </ul>
    </div>


</template>
<script setup>
import { ref } from 'vue';
import { FolderIcon, MagnifyingGlassIcon, ArrowPathIcon, PencilSquareIcon, TrashIcon, EyeIcon } from '@heroicons/vue/24/outline';

const response = ref('');
const search = ref('');
const url = '/api/v1/template';

loadData();
function loadData(link = null) {
    fetch(link ?? `${url}?name=${search.value}`)
        .then(response => response.json())
        .then(json => response.value = json);
}
</script>
