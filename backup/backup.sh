#!/bin/bash
# Script de copia de seguridad para la base de datos
# Este script debe ser ejecutado diariamente mediante un cron job

# Variables de configuración
DB_USER="postgres"
DB_PASS="tu_contraseña"
DB_NAME="impuestos_db"
BACKUP_DIR="/var/backup"
DATE=$(date +"%Y%m%d")

# Crear directorio de respaldo si no existe
if [ ! -d "$BACKUP_DIR" ]; then
    mkdir -p $BACKUP_DIR
fi

# Realizar copia de seguridad
pg_dump -U $DB_USER -d $DB_NAME > $BACKUP_DIR/backup_$DATE.sql

# Comprimir el archivo
gzip $BACKUP_DIR/backup_$DATE.sql

# Registrar en el log
echo "Copia de seguridad completada: $DATE" >> /var/log/backup.log
