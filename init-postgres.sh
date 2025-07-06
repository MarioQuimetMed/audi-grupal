#!/bin/bash
set -e

# Esperar a que PostgreSQL esté disponible
echo "Esperando a que PostgreSQL esté disponible..."
until pg_isready -h postgres -p 5432; do
  sleep 1
done

# Crear la base de datos y cargar el esquema
echo "Importando esquema SQL..."
psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" -f /docker-entrypoint-initdb.d/setup_database.sql

echo "Configuración de PostgreSQL completada"
