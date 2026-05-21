# 🚀 Sistema de Gestión Full Stack

> Aplicación Full Stack para gestión de usuarios, perfiles y auditoría de cambios.  
> Desarrollada como evaluación técnica con arquitectura separada Backend + Frontend.

## 🛠️ Tecnologías

- Laravel 11
- PHP 8.2
- MongoDB
- REST API
- Laravel Resources
- Soft Deletes
- Auditoría de cambios (Audit Logs)

## ⚙️ Instalación

```bash
git clone <URL_BACKEND>
cd backend
composer install
cp .env.example .env
php artisan key:generate
```

🗄️ Configuración .env
```bash
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=nombre_base_datos
```

▶️ Ejecutar backend
```bash
php artisan serve
```

📌 Módulos
👤 Usuarios
CRUD completo
Soft deletes
Relación con perfiles
🧩 Perfiles
CRUD
Conteo de usuarios (users_count)
Detalle con usuarios
📜 Auditoría
created / updated / deleted
snapshot de datos
comparación de cambios
trazabilidad completa

📍 API:
```bash
http://127.0.0.1:8000/api
```
