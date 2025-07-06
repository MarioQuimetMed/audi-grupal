# Laboratorio de Auditoría Informática - Impuestos Nacionales Bolivia

Este proyecto simula la infraestructura de la página de Impuestos Nacionales de Bolivia con vulnerabilidades intencionales para prácticas de auditoría informática y pruebas de penetración.

## Stack Tecnológico

- **Sistema Operativo**: Linux (Ubuntu Server)
- **Servidor Web**: Apache HTTP Server 2.4
- **Base de Datos**: PostgreSQL
- **Backend**: PHP (sin frameworks)
- **Frontend**: Bootstrap 5.2.3

## Vulnerabilidades Implementadas

Este laboratorio incluye intencionalmente varias vulnerabilidades comunes para prácticas de auditoría:

1. **Inyección SQL**: Login sin parametrización
2. **Hash débil**: Contraseñas almacenadas con MD5
3. **Exposición de información sensible**: Logs con información de todos los usuarios
4. **Falta de validación**: Entradas de usuario sin validar
5. **Credenciales hardcodeadas**: En archivos de configuración

## Configuración

### Método 1: Instalación Manual

1. Instalar y configurar Apache, PHP y PostgreSQL
2. Crear la base de datos usando el script `setup_database.sql`
3. Configurar credenciales en `db.php`
4. Acceder a la aplicación mediante el navegador

### Método 2: Usando Docker (Recomendado)

1. Instalar Docker y Docker Compose en tu sistema
2. Navegar al directorio del proyecto
3. Ejecutar el comando: `docker-compose up -d`
4. Acceder a la aplicación en: `http://localhost:8080`
5. La base de datos PostgreSQL estará disponible en el puerto 5432

## Usuarios de Prueba

- **Usuario**: admin / **Contraseña**: admin123
- **Usuario**: juanperez / **Contraseña**: user123
- **Usuario**: marialopez / **Contraseña**: user123
- **Usuario**: empresaxyz / **Contraseña**: user123

## Nota Importante

Este proyecto es exclusivamente para fines educativos en entornos de laboratorio controlados. No utilizar en entornos de producción ni con datos reales.
