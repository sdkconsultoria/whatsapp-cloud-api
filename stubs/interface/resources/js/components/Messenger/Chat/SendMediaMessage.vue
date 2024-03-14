<template>
    <input type="file" id="media-to-send" @change="uploadFile" hidden/>

    <details id="dropdown" class="dropdown dropdown-top " style="width: 70px;" >
        <summary class="mr-1 btn">
            <div class="flex justify-center items-center">
                <PaperClipIcon class="h-8 w-8" />
            </div>
        </summary>

        <ul class="dropdown-content z-[1] menu p-2 shadow bg-base-200 w-56 rounded-box">
            <li class="menu-title">Enviar multimedia</li>
            <li>
                <a @click="selectMedia('document')">
                    <DocumentIcon class="h-4 w-4" /> Documento
                </a>
            </li>
            <li>
                <a @click="selectMedia('image')">
                    <PhotoIcon class="h-4 w-4" /> Imagen
                </a>
            </li>
            <li>
                <a @click="selectMedia('video')">
                    <VideoCameraIcon class="h-4 w-4" /> Video
                </a>
            </li>
            <li>
                <a @click="selectMedia('audio')">
                    <MicrophoneIcon class="h-4 w-4" /> Audio
                </a>
            </li>
        </ul>
    </details>


</template>
<script setup>
import { PaperClipIcon } from '@heroicons/vue/24/solid';
import { DocumentIcon, VideoCameraIcon, PhotoIcon, MicrophoneIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue'

const file = ref();
const type = ref('');

const emit = defineEmits(['sendMessage'])

function uploadFile(event) {
    file.value = event.target.files[0];
    emit('sendMessage', file.value, type.value)
    document.getElementById('dropdown').open = false;
}

const selectMedia = (typeDoc) => {
    type.value = typeDoc;
    const input = document.getElementById('media-to-send');
    input.click();
}
</script>
