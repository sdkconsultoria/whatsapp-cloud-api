<template>
    <div class="form-control">
        <label for="name">Botones</label>
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn m-1">
                <PlusIcon class="h-4 w-4" /> Agregar un botón
            </div>
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
    <div>
        Respuesta Rápida
        <div class="flex gap-2 w-full">
            <div class="form-control w-1/3">
                <label for="name">Tipo</label>
                <select class="select select-bordered w-ful">
                    <option value="AUTHENTICATION">Personalizado</option>
                    <option value="MARKETING">Desactivar marketing</option>
                </select>
            </div>
            <div class="form-control w-2/3">
                <label for="name">Texto del botón</label>
                <input id="header-text" type="text" class="input input-bordered w-full" />
            </div>
        </div>

        <div class="flex gap-2 w-full">
            <div class="form-control w-1/3">
                <label for="name">Tipo</label>
                <select class="select select-bordered w-ful">
                    <option value="AUTHENTICATION">Personalizado</option>
                    <option value="MARKETING">Desactivar marketing</option>
                </select>
            </div>
            <div class="form-control w-1/3">
                <label for="name">Texto del botón</label>
                <input id="header-text" type="text" class="input input-bordered w-full" />
            </div>
            <div class="form-control w-1/3">
                <label for="name">Texto de pie de página</label>
                <input id="header-text" type="text" class="input input-bordered w-full" />
            </div>
        </div>
    </div>
    <div>
        Llamada a la acción
        <div class="flex gap-2 w-full">
            <div class="form-control w-1/3">
                <label for="name">Tipo de acción</label>
                <select class="select select-bordered w-ful">
                    <option value="AUTHENTICATION">LLamar al número</option>
                    <option value="MARKETING">Ir al sitio web</option>
                    <option value="MARKETING">Copiar código de oferta</option>
                    <option value="MARKETING">Ir al sitio web</option>
                </select>
            </div>
            <div class="form-control w-1/3">
                <label for="name">Texto del botón</label>
                <input id="header-text" type="text" class="input input-bordered w-full" />
            </div>
            <div class="form-control w-1/3">
                <label for="name">Texto de pie de página</label>
                <input id="header-text" type="text" class="input input-bordered w-full" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineModel } from 'vue'
import { PlusIcon } from '@heroicons/vue/24/outline';

const model = defineModel('model')
</script>
