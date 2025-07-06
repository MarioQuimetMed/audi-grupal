# Notas sobre la seguridad del sistema

# Documento de uso interno - Confidencial

## Vulnerabilidades conocidas (pendientes de resolver)

1. Inyección SQL en el módulo de login

   - Archivo: login.php
   - Línea: ~12
   - Prioridad: ALTA
   - Estado: Pendiente

2. Hash débil (MD5) para contraseñas

   - Archivo: login.php
   - Línea: ~17
   - Prioridad: ALTA
   - Estado: Pendiente

3. Carga de archivos sin validación

   - Archivo: dashboard.php
   - Línea: ~180
   - Prioridad: ALTA
   - Estado: Pendiente

4. XSS almacenado en comentarios

   - Archivo: dashboard.php
   - Línea: ~220
   - Prioridad: MEDIA
   - Estado: Pendiente

5. API sin autenticación adecuada
   - Archivo: api/user.php
   - Prioridad: MEDIA
   - Estado: Pendiente

## Credenciales para ambiente de prueba

Usuario: admin
Contraseña: admin123

Usuario: juanperez
Contraseña: user123

Usuario: marialopez
Contraseña: user123

Usuario: empresaxyz
Contraseña: user123

## Recordatorio para el equipo de desarrollo

Por favor no publicar este sistema en producción hasta resolver las vulnerabilidades listadas arriba.
Este sistema es únicamente para pruebas y demostraciones.
