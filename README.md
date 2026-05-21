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


<img width="2068" height="2928" alt="diagram" src="https://github.com/user-attachments/assets/046608f4-6245-4408-9721-8a709a05ac32" />

## 📄 Documentación de API

Documentación completa disponible en Postman:

🔗 [https://documenter.getpostman.com/view/XXXXXXX](https://juantintos-80827912-5833031.postman.co/workspace/juan-jose-tintos-gutierrez's-Wo~9061037e-836e-4b2f-81a1-c997c2b775a6/collection/54912861-5dcfbe94-9d59-4a7d-859e-8121752395e3?action=share&creator=54912861&active-environment=54912861-18c78a6c-fd38-494c-9bd9-a597fd87b801)

Incluye:
- Endpoints completos
- Ejemplos de request/response
- Filtros
- Paginación
- Casos de uso del sistema
