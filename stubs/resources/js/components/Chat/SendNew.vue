<template>
    <button class="btn btn-primary" onclick="new_message_modal.showModal()">
        <PlusCircleIcon class="h-6 w-6" />
    </button>
    <dialog id="new_message_modal" class="modal">
        <div class="modal-box">
            <div role="tablist" class="tabs tabs-lifted">
                <input type="radio" name="send_new_message" role="tab" class="tab" aria-label="Individual" checked />
                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                    <NewTemplateMessage />
                </div>

                <input type="radio" name="send_new_message" role="tab" class="tab" aria-label="Multiple"  />
                <div role="tabpanel" class="tab-content bg-base-100 border-base-300 rounded-box p-6">
                    <NewCampaign />
                </div>
            </div>
        </div>
    </dialog>
</template>

<script setup>
import { PlusCircleIcon } from '@heroicons/vue/24/outline';
import NewCampaign from './NewCampaign.vue';
import NewTemplateMessage from './NewTemplateMessage.vue';

</script>
