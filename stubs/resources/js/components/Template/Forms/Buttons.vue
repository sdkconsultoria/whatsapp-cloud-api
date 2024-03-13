<template>
    <div class="form-control">
        <label for="name">Botones</label>
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn m-1"> <PlusIcon class="h-4 w-4" /> Agregar un botón</div>
            <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52">
                <span class="menu-title">Botones de respuesta rápida</span>
                <li><a>Desactivar marketing</a></li>
                <li><a>Personalizado</a></li>
                <span class="menu-title">Botones de Llamada a la acción</span>
                <li><a>Ir al sitio web</a></li>
                <li><a>Llamar al número de teléfono</a></li>
                <li><a>Copiar óodigo de oferta</a></li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { defineModel } from 'vue'
import { PlusIcon } from '@heroicons/vue/24/outline';

const model = defineModel('model')
</script>
