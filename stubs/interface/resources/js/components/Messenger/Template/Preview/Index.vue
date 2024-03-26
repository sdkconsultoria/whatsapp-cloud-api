<template>
    <div class="flex">
        <div class="mockup-phone">
            <div class="camera"></div>
            <div class="display">
                <div class="artboard artboard-demo phone-1 justify-start items-start">
                    <div class="chat chat-start mt-12 w-full">
                        <div class="chat-bubble w-full ">
                            <img v-if="model.components.header.format == 'IMAGE' && preview" :src="preview" alt="header" class="w-full" />
                            <embed v-if="model.components.header.format == 'DOCUMENT' && preview" :src="preview"
                                type="application/pdf" width="100%" height="240px">
                            <video v-if="model.components.header.format == 'VIDEO' && preview" width="300" height="240" controls>
                                <source :src="preview" type="video/mp4">
                            </video>
                            <strong>{{ model.components.header.text }}</strong>
                            <p class="mt-2 mb-2">{{ model.components.body.text }}</p>
                            <small>{{ model.components.footer.text }}</small>
                            <div v-for="button in model.components.buttons.buttons">
                                <div class="bg-white w-full" style="height: 0.5px;"></div>
                                <div class="flex justify-center items-center h-10">
                                    <ArrowUturnLeftIcon v-if="button.type == 'QUICK_REPLY'" class="h-4 w-4 mr-1" />
                                    <PhoneIcon v-if="button.type == 'PHONE_NUMBER'" class="h-4 w-4 mr-1" />
                                    <LinkIcon v-if="button.type == 'URL'" class="h-4 w-4 mr-1" />
                                    {{ button.text }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ArrowUturnLeftIcon, PhoneIcon, LinkIcon } from '@heroicons/vue/24/outline';
import { defineModel, ref, watch } from 'vue'

const model = defineModel('model')
const preview = ref(false)

watch(model.value.components.header, async () => {
    if (model.value.components.header.example?.header_handle[0]) {
        preview.value = await fileToBase64(model.value.components.header.example?.header_handle[0])
    } else {
        preview.value = false
    }
})

async function fileToBase64(file) {
    if (file) {
        return await new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }
}
</script>
