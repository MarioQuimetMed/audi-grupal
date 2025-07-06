-- Última copia de seguridad: 05/07/2025
-- Generada automáticamente por el script de backup

-- Backup de tabla usuarios
CREATE TABLE backup_usuarios (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(100) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nit VARCHAR(20),
    tipo VARCHAR(20) NOT NULL,
    estado VARCHAR(10) DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar datos de usuarios (copia de seguridad)
INSERT INTO backup_usuarios (id, username, password_hash, nombre, email, nit, tipo, estado, fecha_registro)
VALUES 
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Administrador Sistema', 'admin@impuestos.gob.bo', '1234567890', 'personal', 'activo', '2025-06-01 10:15:00'),
(2, 'juanperez', '6ad14ba9986e3615423dfca256d04e3f', 'Juan Pérez', 'juan@example.com', '1234567891', 'personal', 'activo', '2025-06-10 14:30:00'),
(3, 'marialopez', '6ad14ba9986e3615423dfca256d04e3f', 'María López', 'maria@example.com', '1234567892', 'personal', 'activo', '2025-06-15 09:45:00'),
(4, 'empresaxyz', '6ad14ba9986e3615423dfca256d04e3f', 'Empresa XYZ S.A.', 'contacto@xyz.com', '9876543210', 'empresa', 'activo', '2025-06-20 11:20:00'),
(5, 'soporte', '25d55ad283aa400af464c76d713c07ad', 'Usuario Soporte', 'soporte@impuestos.gob.bo', '0000000001', 'personal', 'activo', '2025-06-01 08:00:00'),
(6, 'tecnico', '098f6bcd4621d373cade4e832627b4f6', 'Usuario Técnico', 'tecnico@impuestos.gob.bo', '0000000002', 'personal', 'activo', '2025-06-01 08:30:00');

-- Otras tablas de respaldo podrían seguir aquí
