@component('mail::message')
# Recuperación de contraseña

Hola **{{ $userName }}**,

Tu contraseña ha sido restablecida. Usa las siguientes credenciales para ingresar:

@component('mail::panel')
**Nueva contraseña:** `{{ $newPassword }}`
@endcomponent

> Por seguridad, cambia tu contraseña después de iniciar sesión.

@component('mail::button', ['url' => config('app.url')])
Iniciar sesión
@endcomponent

Gracias,
**{{ config('app.name') }}**
@endcomponent