# Tickets y Send

Sistema de tickets de soporte desarrollado para Programación IV. Las fases 1 y 2 incluyen autenticación, roles, permisos, operación completa de tickets, gestión de usuarios y notificaciones por correo en cola. El diseño visual definitivo pertenece a la fase 3.

## Tecnologías

- PHP 8.2 y Laravel 12.
- MySQL/MariaDB con Eloquent ORM.
- Livewire 4, Blade, Tailwind CSS 4 y Flux UI gratuito.
- Laravel Fortify para autenticación.
- Spatie Laravel Permission 6 (rama compatible con PHP 8.2 y Laravel 12).
- Vite, Composer y npm.

## Instalación local

1. Instalar dependencias:

   ```bash
   composer install
   npm install
   ```

2. Copiar `.env.example` como `.env` y generar la clave:

   ```bash
   php artisan key:generate
   ```

3. Crear una base MySQL llamada `ticketysend` y ajustar `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` y `DB_PASSWORD` en `.env`.

4. Ejecutar las migraciones y los roles/permisos:

   ```bash
   php artisan migrate
   php artisan db:seed --class=RolesAndPermissionsSeeder
   ```

No se debe usar `migrate:fresh` ni `migrate:reset` sobre una base con datos.

## Usuarios de demostración

Solo en entorno `local` o `testing`:

```bash
php artisan db:seed --class=DemoUsersSeeder
```

| Usuario | Rol | Contraseña local |
|---|---|---|
| `admin@example.com` | Administrador | `Password123!` |
| `supervisor@example.com` | Supervisor | `Password123!` |
| `usuario@example.com` | Usuario | `Password123!` |

El seeder no cambia contraseñas de cuentas existentes y no se ejecuta automáticamente en producción.

## Roles y permisos

| Permiso | Admin | Supervisor | Usuario |
|---|:---:|:---:|:---:|
| crear tickets | Sí | Sí | Sí |
| ver tickets | Sí | Sí | Sí |
| editar tickets | Sí | Sí | No |
| cerrar tickets | Sí | Sí | No |
| gestionar usuarios | Sí | No | No |

Los usuarios comunes solo pueden visualizar tickets propios. Administradores y supervisores pueden visualizar todos; la edición y el cierre requieren además el permiso correspondiente.

## Operación de tickets

- Los tres roles pueden crear tickets y consultar los que tengan autorizados.
- Los usuarios comunes solo ven sus propios tickets.
- Administradores y supervisores pueden editar prioridad, contenido y estado operativo.
- El cierre registra usuario y fecha, y vuelve inmutable al ticket.
- No se permite eliminar tickets ni usuarios.
- El identificador visible se deriva del ID, por ejemplo `TKT-000001`.

Los administradores acceden además a la gestión de usuarios para asignar uno de los tres roles. Un administrador no puede cambiar su propio rol y el sistema protege la existencia de al menos un administrador.

## Desarrollo

Todos los servicios principales pueden iniciarse juntos:

```bash
composer run dev
```

O en terminales separadas:

```bash
php artisan serve
npm run dev
php artisan queue:work --tries=3
```

En PowerShell con ejecución de scripts restringida, usar `npm.cmd` en lugar de `npm`.

Para consultar trabajos fallidos:

```bash
php artisan queue:failed
```

## Correo

`.env.example` contiene la configuración SMTP de referencia para Brevo mediante `MAIL_SCHEME`, variable consumida por `config/mail.php`. `MAIL_USERNAME` debe ser el usuario SMTP de Brevo y `MAIL_PASSWORD` la **SMTP Key**, no la API Key. El remitente debe estar verificado.

El entorno local conserva `MAIL_MAILER=log` para no enviar correos reales por accidente. Al crear, actualizar o cerrar un ticket se encola un correo para su creador. Para procesarlo se debe mantener activo `php artisan queue:work --tries=3`.

## Verificación

Las pruebas usan SQLite en memoria y no acceden a MySQL, Brevo ni DNS externo:

```bash
php artisan test
vendor/bin/pint --test
npm run build
composer audit --locked
npm audit
```

## Estado de las fases

- Fase 1: base, autenticación y autorización completadas.
- Fase 2: tickets, gestión de usuarios y correos automáticos completados.
- Fase 3: diseño visual definitivo y refinamiento de experiencia pendientes.
