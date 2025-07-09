#!/bin/bash
# Script para verificar exposición de archivos confidenciales
# Ejecutar regularmente como parte de las medidas de seguridad

echo "=== Verificación de seguridad de archivos confidenciales ==="
echo "Fecha: $(date)"
echo

# Directorio base para la verificación
BASE_DIR="/var/www/html"

# Lista de patrones de archivos sensibles
SENSITIVE_PATTERNS=(
  "*.bak"
  "*.sql"
  "*.config"
  "*.conf"
  "*.log"
  "*.old"
  "*password*"
  "*credential*"
  "*.pem"
  "*.key"
  "*secret*"
  "*.htpasswd"
)

# Directorios que deberían ser inaccesibles
SECURE_DIRS=(
  "admin"
  "backup"
  "secure_config"
  "config"
  ".git"
)

# Verificar archivos sensibles expuestos
echo "1. Verificando archivos potencialmente sensibles expuestos:"
for pattern in "${SENSITIVE_PATTERNS[@]}"; do
  echo -n "   Buscando $pattern... "
  found=$(find $BASE_DIR -name "$pattern" -not -path "*/secure_config/*" -type f | wc -l)
  
  if [ "$found" -gt 0 ]; then
    echo "ALERTA: $found archivos encontrados"
    find $BASE_DIR -name "$pattern" -not -path "*/secure_config/*" -type f | sed 's|^|     - |'
  else
    echo "OK"
  fi
done

echo
echo "2. Verificando protección de directorios sensibles:"
for dir in "${SECURE_DIRS[@]}"; do
  echo -n "   Verificando $dir... "
  
  # Comprobar que existe y tiene .htaccess
  if [ -d "$BASE_DIR/$dir" ]; then
    if [ -f "$BASE_DIR/$dir/.htaccess" ]; then
      echo "OK (Protegido con .htaccess)"
    else
      echo "ALERTA: No tiene archivo .htaccess"
    fi
  else
    echo "No encontrado"
  fi
done

echo
echo "3. Verificando permisos de archivos críticos:"
# Comprobar permisos de archivos y directorios importantes
find $BASE_DIR/secure_config -type f -ls | awk '{print $3, $11}' | 
  grep -v "^-r--" | sed 's|^|   ALERTA: Permisos incorrectos: |'

echo
echo "4. Verificando exposición en robots.txt:"
if grep -q "Disallow: /" "$BASE_DIR/robots.txt"; then
  echo "   OK: robots.txt bloquea indexación general"
else
  echo "   ALERTA: robots.txt no bloquea indexación de todo el sitio"
fi

echo
echo "=== Fin de la verificación ==="
echo "Recomendación: Revisar todas las alertas y corregir los problemas encontrados"
