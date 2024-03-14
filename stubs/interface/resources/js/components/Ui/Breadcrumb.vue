<template>
    <div class="text-sm breadcrumbs">
        <ul>
            <li v-for="breadcrumb in breadcrumbs">
                <a :href="breadcrumb.link" v-if="breadcrumb.link">
                    <FolderIcon class="h-4 w-4" /> &nbsp; {{ breadcrumb.label }}
                </a>
                <span v-else class="inline-flex gap-2 items-center">
                    <FolderIcon class="h-4 w-4" /> {{ breadcrumb.label }}
                </span>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { FolderIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    breadcrumbs: {
        type: Array,
        required: true
    }
});
</script>
