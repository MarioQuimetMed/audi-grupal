<?php
// Script para generar hashes bcrypt para contraseñas de prueba
echo "Hash para 'admin123': " . password_hash('admin123', PASSWORD_BCRYPT) . "\n";
echo "Hash para 'user123': " . password_hash('user123', PASSWORD_BCRYPT) . "\n";
?>
