<template>
    <div class="mockup-phone">
        <div class="camera"></div>
        <div class="display">
            <div class="artboard artboard-demo phone-1 justify-start items-start">
                <div class="chat chat-start mt-12 w-full">
                    <div class="chat-bubble w-full">
                        <small>{{ model.components.header.text }}</small>
                        <p class="mt-3 mb-2">{{ model.components.body.text }}</p>
                        <small>{{ model.components.footer.text }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
const model = defineModel('model')

</script>
