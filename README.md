SDK Consultoría - Whatsapp Cloud API
====

Descripción
------------
##### ¿Qué puedo esperar de esta librería?
- Conexión WhatsApp cloud API
- Conexión WhatsApp bussines manager
- Chat en tiempo real con WhatsApp
- Envíos y recepción de mensajes de video, imagen, texto, pdf, stickers y reacciones.
- Envíos masivos de whatsapp
- Envíos de plantillas

Este paquete está en desarrollo, todavía no es una versión estable ni optimizada.

Video Demo
 - https://youtu.be/Tw5X-AVTMa0

Video envíos masivos de whatsapp
 - https://youtu.be/x2nPfEt6HYw

Video envíos y recepción de mensajes de video, imagen, texto, pdf, stickers y reacciones.
 - https://youtu.be/BZUQSeo7yz0

Tutorial de instalación
 - https://youtu.be/EUyvuYIFRz8

##### Coverage

https://coveralls.io/github/sdkconsultoria/whatsapp-cloud-api

[![Coverage Status](https://coveralls.io/repos/github/sdkconsultoria/whatsapp-cloud-api/badge.svg?branch=develop)](https://coveralls.io/github/sdkconsultoria/whatsapp-cloud-api?branch=develop)

Instalación
------------
Ejecuta el comando para instalar la librería en tu proyecto Laravel

```
composer require sdkconsultoria/whatsapp-cloud-api
```

Ejecutar las migraciones, para generar las tablas donde se guardaran los chats
```
php artisan migrate
```

Linkear el storage público para poder obtener la URL de los archivos recibidos y enviados

```
php artisan storage:link
```

Si quieres usar el Messenger en VUE (opcional), también puedes usar los endpoints
```
php artisan sdk:whatsapp-messenger-install
```

Configuración con Laravel sail y soketi
------------

socketi es una opción Open-source para notificaciones push totalmente compatible con pusher y Laravel echo https://docs.soketi.app/

la configuración por defecto para soketi es esta:
```
PUSHER_APP_ID=app-id
PUSHER_APP_KEY=app-key
PUSHER_APP_SECRET=app-secret
PUSHER_HOST=soketi
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST=localhost
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

META_WEBHOOK_TOKEN=
META_TOKEN=
META_APP_ID=
```

Configuración de Whatsapp Business Account WABA
------------

Puedes obtener la información desde

https://developers.facebook.com/apps/

Si no tienes una APP debes crear una en la página de facebook developers.
https://developers.facebook.com/apps

###### Registrar el webhook en meta
{{HOST}}/api/v1/whatsapp-webhook

###### Obtener waba, plantillas, números telefónicos y bussiness profile desde Meta
{{HOST}}/api/v1/waba/{{wabaId}}/init