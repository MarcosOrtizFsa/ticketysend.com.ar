# Fases del proyecto

## Fase 1 — Base y autenticación

Estado: **completada**.

- Estructura Laravel 12 con MySQL y Eloquent.
- Registro, inicio de sesión, cierre de sesión y recuperación de contraseña.
- Dashboard protegido en Blade/Livewire con Flux UI.
- Roles, permisos, usuarios demo y autorización de tickets.
- Modelo, enums, migración y factory de tickets, sin interfaz ni acciones CRUD.
- Infraestructura de correo SMTP y colas de base de datos.
- Pruebas funcionales de autenticación y autorización.

## Fase 2 — Operación del sistema

Estado: **completada**.

- Creación, consulta, búsqueda, filtros, edición y cierre auditado de tickets.
- Acceso limitado a tickets propios para usuarios y acceso global para el equipo de soporte.
- Gestión de roles de usuarios exclusiva para administradores.
- Correos automáticos en cola al crear, actualizar y cerrar tickets.
- Pruebas funcionales de los flujos, autorizaciones y notificaciones.

## Fase 3 — Diseño final

Estado: **pendiente**.

- Diseño visual definitivo.
- Refinamiento responsive, accesibilidad y experiencia de usuario.
