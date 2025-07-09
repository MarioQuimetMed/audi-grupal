# Sistema Impuestos Nacionales - Versión Segura

Este proyecto simula la infraestructura de la página de Impuestos Nacionales de Bolivia con implementación de medidas de seguridad robustas. Previamente contenía vulnerabilidades para prácticas de auditoría que han sido corregidas.

## Stack Tecnológico

- **Sistema Operativo**: Linux (Ubuntu Server)
- **Servidor Web**: Apache HTTP Server 2.4 con configuración segura
- **Base de Datos**: PostgreSQL con acceso parametrizado
- **Backend**: PHP (sin frameworks) con medidas de seguridad
- **Frontend**: Bootstrap 5.2.3

## Vulnerabilidades Corregidas

Las siguientes vulnerabilidades han sido identificadas y corregidas:

1. **Inyección SQL**: Implementación de sentencias preparadas
2. **Hash débil**: Actualización de MD5 a bcrypt (password_hash)
3. **Exposición de información sensible**: Protección de archivos de configuración
4. **Falta de validación**: Validación estricta de todas las entradas de usuario
5. **XSS**: Sanitización de entrada y salida de datos
6. **Carga de archivos insegura**: Validación de tipo, tamaño y nombre aleatorio
7. **API sin autenticación**: Implementación de autenticación con API key y rate limiting
8. **Credenciales hardcodeadas**: En archivos de configuración

## Medidas de Seguridad Implementadas

### Prevención de Inyección SQL

- Uso de sentencias preparadas en todas las consultas a la base de datos
- Validación y sanitización de parámetros de entrada

### Almacenamiento Seguro de Contraseñas

- Uso de bcrypt (password_hash/password_verify) para gestión segura de contraseñas
- Eliminación de hashes MD5 inseguros

### Protección contra XSS

- Sanitización de entrada de usuario con htmlspecialchars
- Implementación de Content Security Policy
- Codificación HTML de salida sensible

### Gestión Segura de Archivos

- Validación estricta de tipo, tamaño y extensión de archivos
- Generación de nombres aleatorios para prevenir sobrescritura
- Restricción de acceso a directorios de carga

### Seguridad en API

- Autenticación mediante API key
- Rate limiting para prevenir abusos
- Validación de parámetros de entrada

### Configuración de Servidor

- Cabeceras de seguridad HTTP
- Configuración segura de Apache via .htaccess
- Forzado de HTTPS

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

## Consideraciones de Seguridad

- Este sistema utiliza una configuración de seguridad robusta
- Se recomienda mantener actualizadas todas las dependencias
- Realizar auditorías periódicas de seguridad
- Monitorear los logs en busca de actividad sospechosa
