<template>
    <div class="flex gap-2 w-full">
        <div class="form-control w-1/3">
            <label for="name">Tipo de acción</label>
            <select class="select select-bordered w-full">
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
</template>
