-- La base de datos ya está creada por Docker
-- No necesitamos crear ni conectarnos a ella

-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(100) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    nit VARCHAR(20),
    tipo VARCHAR(20) NOT NULL, -- 'personal' o 'empresa'
    estado VARCHAR(10) DEFAULT 'activo',
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear tabla de logs
CREATE TABLE logs (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id),
    accion VARCHAR(50) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    detalles TEXT
);

-- Crear tabla de declaraciones
CREATE TABLE declaraciones (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id),
    tipo VARCHAR(20) NOT NULL, -- 'IVA', 'IT', 'IUE', etc.
    periodo VARCHAR(7) NOT NULL, -- Formato 'YYYY-MM'
    monto DECIMAL(12, 2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'pendiente', -- 'pendiente', 'pagada', 'vencida'
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_pago TIMESTAMP
);

-- Crear tabla de facturas
CREATE TABLE facturas (
    id SERIAL PRIMARY KEY,
    usuario_id INTEGER REFERENCES usuarios(id),
    nro_factura VARCHAR(20) NOT NULL,
    nit_emisor VARCHAR(20) NOT NULL,
    nombre_emisor VARCHAR(100) NOT NULL,
    fecha_emision DATE NOT NULL,
    monto DECIMAL(12, 2) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar usuarios de prueba (contraseñas vulnerables a propósito)
-- Contraseña 'admin123' = md5('admin123') = '0192023a7bbd73250516f069df18b500'
-- Contraseña 'user123' = md5('user123') = '6ad14ba9986e3615423dfca256d04e3f'

INSERT INTO usuarios (username, password_hash, nombre, email, nit, tipo)
VALUES 
('admin', '0192023a7bbd73250516f069df18b500', 'Administrador Sistema', 'admin@impuestos.gob.bo', '1234567890', 'personal'),
('juanperez', '6ad14ba9986e3615423dfca256d04e3f', 'Juan Pérez', 'juan@example.com', '1234567891', 'personal'),
('marialopez', '6ad14ba9986e3615423dfca256d04e3f', 'María López', 'maria@example.com', '1234567892', 'personal'),
('empresaxyz', '6ad14ba9986e3615423dfca256d04e3f', 'Empresa XYZ S.A.', 'contacto@xyz.com', '9876543210', 'empresa');

-- Insertar algunos logs de ejemplo
INSERT INTO logs (usuario_id, accion, ip_address, detalles)
VALUES 
(1, 'inicio_sesion', '192.168.1.100', 'Login desde navegador Chrome'),
(1, 'acceso_dashboard', '192.168.1.100', NULL),
(2, 'inicio_sesion', '192.168.1.101', 'Login desde navegador Firefox'),
(2, 'declaracion_creada', '192.168.1.101', 'Declaración IVA período 2025-06'),
(3, 'inicio_sesion', '192.168.1.102', 'Login desde navegador Edge'),
(3, 'declaracion_pagada', '192.168.1.102', 'Pago declaración IT período 2025-06'),
(4, 'inicio_sesion', '192.168.1.103', 'Login desde navegador Safari'),
(4, 'factura_registrada', '192.168.1.103', 'Registro de factura #A-001002');

-- Insertar declaraciones de ejemplo
INSERT INTO declaraciones (usuario_id, tipo, periodo, monto, estado)
VALUES 
(2, 'IVA', '2025-06', 1500.00, 'pendiente'),
(2, 'IT', '2025-06', 650.00, 'pendiente'),
(3, 'IVA', '2025-06', 2300.00, 'pagada'),
(3, 'IT', '2025-06', 980.00, 'pagada'),
(4, 'IUE', '2025-06', 12500.00, 'pendiente');

-- Insertar facturas de ejemplo
INSERT INTO facturas (usuario_id, nro_factura, nit_emisor, nombre_emisor, fecha_emision, monto)
VALUES 
(2, 'F-001234', '1020304050', 'Tienda Comercial', '2025-06-15', 150.50),
(2, 'F-001235', '1020304051', 'Supermercado ABC', '2025-06-18', 235.75),
(3, 'F-001236', '1020304052', 'Papelería XYZ', '2025-06-20', 45.25),
(4, 'F-001237', '1020304053', 'Distribuidora Nacional', '2025-06-22', 1245.80);
