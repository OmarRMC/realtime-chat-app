
# Aplicación de Chat en Tiempo Real

## Descripción
Esta es una aplicación de chat en tiempo real construida con **Laravel**, **Pusher** (o **Reverb**), y **Laravel Echo**. La aplicación permite a los usuarios enviar y recibir mensajes al instante, creando una experiencia de comunicación fluida. Incluye tanto chats privados como globales, permitiendo a los usuarios comunicarse individualmente o en grupos.

## Características
- **Mensajería en Tiempo Real:** Los usuarios pueden enviar y recibir mensajes al instante utilizando WebSockets.
- **Chats Privados:** Enviar mensajes a usuarios individuales en un canal privado.
- **Chat Global:** Un canal público donde los usuarios pueden chatear con todos los demás en el sistema.
- **Autenticación de Usuarios:** Cada usuario tiene una cuenta, y los mensajes se envían y reciben según la autenticación.

## Tecnologías Utilizadas
- **Backend:** Laravel 12 (PHP)
- **Frontend:** Laravel Echo, Pusher o Reverb
- **Autenticación:** Laravel Breeze
- **Base de Datos:** MySQL
- **WebSockets:** Pusher o Reverb para la mensajería en tiempo real
- **Sistema de Colas:** Redis (opcional para trabajos en cola)

## Requisitos Previos

Asegúrate de tener instalado lo siguiente:
- PHP 8.x o superior
- Composer
- Node.js y npm
- Redis (si usas trabajos en cola)
- Laravel Echo Server (para transmitir eventos si no usas Pusher)

## Instalación

### Paso 1: Clonar el Repositorio
Clona el repositorio en tu máquina local:

```bash
git clone https://github.com/OmarRMC/realtime-chat-app.git
cd realtime-chat-app
```

### Paso 2: Instalar Dependencias de PHP
Instala las dependencias de PHP a través de Composer:

```bash
composer install
```

### Paso 3: Instalar Dependencias de Node.js
Instala las dependencias de Node.js:

```bash
npm install
```

### Paso 4: Configurar Variables de Entorno
Copia el archivo `.env.example` a `.env`:

```bash
cp .env.example .env
```

Actualiza el archivo `.env` con la configuración necesaria:
- Configura `APP_KEY`, `APP_NAME`, `APP_URL`, `DB_*` para que coincidan con tu entorno local.
- Configura los parámetros de **Pusher** o **Reverb**. Si usas Pusher, las variables deben ser configuradas de la siguiente manera:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=tu-id-de-pusher
PUSHER_APP_KEY=tu-clave-de-pusher
PUSHER_APP_SECRET=tu-secreto-de-pusher
PUSHER_APP_CLUSTER=tu-cluster-de-pusher
```

Si usas **Reverb**, configura el `BROADCAST_DRIVER` a `reverb` y ajusta las configuraciones de `REVERB_*` según sea necesario.

Para Redis (si usas Redis para trabajos en cola):

```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Paso 5: Generar la Clave de la Aplicación
Ejecuta el siguiente comando para generar la clave de la aplicación de Laravel:

```bash
php artisan key:generate
```

### Paso 6: Migrar la Base de Datos
Ejecuta las migraciones de la base de datos para crear las tablas necesarias:

```bash
php artisan migrate
```

### Paso 7: Configurar Redis (Opcional)
Si usas Redis para trabajos en cola, asegúrate de que Redis esté instalado y funcionando en tu máquina local. Puedes instalar Redis con los siguientes comandos según tu sistema operativo:

#### Para Ubuntu:
```bash
sudo apt-get update
sudo apt-get install redis-server
```

#### Para Mac (usando Homebrew):
```bash
brew install redis
```

Inicia el servidor de Redis:

```bash
redis-server
```

Alternativamente, si usas **Docker** para Redis, ejecuta:

```bash
docker run --name redis -p 6379:6379 -d redis
```

### Paso 8: Configurar la Transmisión
Si usas **Pusher**:
Asegúrate de haber agregado la configuración de **Pusher** en tu archivo `.env`, como se explicó anteriormente.

Si usas **Reverb**, asegúrate de configurar el archivo `broadcasting.php` con la configuración correcta de Reverb.

### Paso 9: Iniciar el Servidor Reverb (Si usas Reverb)
Si usas **Pusher**, no necesitas iniciar un servidor . Pusher manejará la conexión WebSocket por ti.

Sin embargo, si usas **Reverb** (o tienes tu propio servidor Echo configurado), necesitas iniciar el servidor

Se intala cuando se ejecuta el comando 
```bash
php artisan install:broadcasting
```
o 
```bash
composer require laravel/reverb
```
Iniciar el servidor de Reverb:

```bash
php artisan reverb:start
```

### Paso 10: Ejecutar el Servidor de Desarrollo
Ahora, puedes iniciar el servidor de desarrollo de Laravel:

```bash
php artisan serve
```

Además, ejecuta el compilador de activos del frontend:

```bash
npm run dev
```

### Paso 11: Trabajos en Cola (Para que se ejecuten los eventos)
Para trabajos en cola (por ejemplo, enviando notificaciones), necesitas ejecutar el trabajador de colas:

```bash
php artisan queue:work
```

Si quieres que la cola procese trabajos en segundo plano, puedes usar `supervisor` (o una herramienta similar) para mantenerlo ejecutándose.

## Uso

1. **Regístrate o inicia sesión** en el sistema.
2. **Comienza a chatear** en el chat global o envía mensajes privados a otros usuarios.
3. ¡Disfruta de la **comunicación en tiempo real** con tus usuarios!

## Contribuciones
¡Las contribuciones son bienvenidas! Por favor, haz un fork del repositorio y envía pull requests para correcciones de errores o nuevas características.

## Licencia
Este proyecto está bajo la Licencia MIT.

## Solución de Problemas

- **Pusher no funciona:** Asegúrate de tener las claves correctas de Pusher en tu archivo `.env` y que tu aplicación esté conectada al cluster adecuado de Pusher.
- **Problemas con Redis:** Asegúrate de que Redis esté funcionando y correctamente configurado en tu archivo `.env`.
- **El servidor Echo no arranca:** Verifica que todas las dependencias necesarias para Laravel Echo Server estén instaladas y revisa tus configuraciones en el archivo `.env`.
