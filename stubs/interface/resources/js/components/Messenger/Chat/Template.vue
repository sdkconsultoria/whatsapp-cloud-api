<template>
    <strong>{{ content.HEADER?.text }}</strong>
    <p>{{ content.BODY?.text }}</p>
    <small>{{ content.FOOTER?.text }}</small>

</template>
<script setup>
import { defineProps } from 'vue'
const props = defineProps({
    content: Object
})
</script>
