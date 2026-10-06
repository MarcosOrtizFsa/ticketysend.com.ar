# Tickets y Send

Base de un sistema de tickets de soporte desarrollada para Programación IV. La fase 1 incluye autenticación, roles, permisos, estructura de tickets y preparación de correo y colas. Las operaciones y pantallas de tickets pertenecen a la fase 2.

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

El entorno local conserva `MAIL_MAILER=log` para no enviar correos reales durante esta fase. Los mailables y envíos automáticos se implementarán en la fase 2.

## Verificación

Las pruebas usan SQLite en memoria y no acceden a MySQL, Brevo ni DNS externo:

```bash
php artisan test
vendor/bin/pint --test
npm run build
composer audit --locked
npm audit
```

## Preparado para la fase 2

- Modelo, migración, enums, factory y policy de tickets.
- Roles y permisos repetibles.
- Cola con driver `database` y tablas de jobs/fallos.
- Configuración SMTP de ejemplo para Brevo.
- Autenticación completa y dashboard protegido.

No se implementaron todavía CRUD de tickets, gestión de usuarios, mailables ni envíos automáticos.
