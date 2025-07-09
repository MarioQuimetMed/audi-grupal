#!/bin/bash
# Script seguro de copia de seguridad para la base de datos
# Este script debe ser ejecutado diariamente mediante un cron job
# y debe tener permisos de ejecución restrictivos (chmod 700)

# Cargar configuración desde archivo separado
if [ -f "/opt/impnac/secure/backup.conf" ]; then
    source "/opt/impnac/secure/backup.conf"
else
    echo "ERROR: Archivo de configuración no encontrado" >&2
    exit 1
fi

# Variables de configuración con valores predeterminados
: ${DB_HOST:="localhost"}
: ${DB_PORT:="5432"}
: ${DB_NAME:="impuestos_db"}
: ${BACKUP_DIR:="/var/backup"}
: ${LOG_FILE:="/var/log/backup.log"}
: ${RETENTION_DAYS:="30"}

# Validación de parámetros
if [ -z "$DB_USER" ] || [ -z "$DB_NAME" ] || [ -z "$BACKUP_DIR" ]; then
    echo "ERROR: Parámetros de configuración incompletos" >&2
    exit 1
fi

# Asegurar que PGPASSWORD no se muestre en ps
export PGPASSWORD="$DB_PASSWORD"

# Timestamp para el archivo de respaldo
DATE=$(date +"%Y%m%d_%H%M%S")
BACKUP_FILE="$BACKUP_DIR/backup_${DB_NAME}_${DATE}.sql"

# Crear directorio de respaldo con permisos seguros si no existe
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p $BACKUP_DIR
    chmod 700 $BACKUP_DIR
fi

# Realizar copia de seguridad usando parámetros escapados
pg_dump -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USER" -d "$DB_NAME" -f "$BACKUP_FILE" 2>/tmp/pg_dump_error

# Verificar si hubo errores
if [ $? -ne 0 ]; then
    ERROR=$(cat /tmp/pg_dump_error)
    echo "ERROR: Falló el backup de la base de datos: $ERROR" >&2
    rm /tmp/pg_dump_error
    
    # Limpiar variable de contraseña
    unset PGPASSWORD
    exit 1
fi

rm -f /tmp/pg_dump_error

# Comprimir el archivo y protegerlo
gzip -9 "$BACKUP_FILE"
chmod 600 "$BACKUP_FILE.gz"

# Eliminar backups antiguos
find "$BACKUP_DIR" -name "backup_${DB_NAME}_*.sql.gz" -type f -mtime +$RETENTION_DAYS -delete

# Registrar en el log
echo "$(date '+%Y-%m-%d %H:%M:%S') - Copia de seguridad completada: $BACKUP_FILE.gz" >> "$LOG_FILE"

# Limpiar variable de contraseña
unset PGPASSWORD

exit 0
