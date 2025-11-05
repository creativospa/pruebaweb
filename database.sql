-- Base de datos para Hosting Creativos
CREATE DATABASE IF NOT EXISTS hosting_creativos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE hosting_creativos;

-- Tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ultimo_acceso TIMESTAMP NULL,
    estado ENUM('activo', 'inactivo', 'suspendido') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla de planes de hosting
CREATE TABLE IF NOT EXISTS planes_hosting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    slots INT NOT NULL,
    ram_gb INT NOT NULL,
    almacenamiento_gb INT NOT NULL,
    procesador VARCHAR(100),
    caracteristicas JSON,
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de suscripciones
CREATE TABLE IF NOT EXISTS suscripciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    plan_id INT NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_vencimiento DATE NOT NULL,
    estado ENUM('activa', 'vencida', 'cancelada') DEFAULT 'activa',
    precio_pagado DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (plan_id) REFERENCES planes_hosting(id)
);

-- Tabla de servidores
CREATE TABLE IF NOT EXISTS servidores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    suscripcion_id INT NOT NULL,
    nombre_servidor VARCHAR(100) NOT NULL,
    ip_servidor VARCHAR(45),
    puerto INT DEFAULT 22003,
    juego ENUM('MTA', 'SAMP', 'FiveM', 'Minecraft') NOT NULL,
    estado ENUM('online', 'offline', 'mantenimiento') DEFAULT 'offline',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (suscripcion_id) REFERENCES suscripciones(id)
);

-- Insertar planes de ejemplo
INSERT INTO planes_hosting (nombre, precio, slots, ram_gb, almacenamiento_gb, procesador, caracteristicas) VALUES
('Básico', 1.49, 15, 1, 3, 'Ryzen 9 5950X', JSON_OBJECT(
    'ftp', true,
    'ddos_protection', true,
    'mysql_db', true,
    'soporte_24_7', true
)),
('Premium', 3.49, 25, 3, 6, 'Ryzen 9 5950X', JSON_OBJECT(
    'ftp', true,
    'ddos_protection', true,
    'mysql_db', true,
    'soporte_24_7', true,
    'backup_automatico', true
));

-- Índices para mejor rendimiento
CREATE INDEX idx_usuarios_email ON usuarios(email);
CREATE INDEX idx_suscripciones_usuario ON suscripciones(usuario_id);
CREATE INDEX idx_servidores_usuario ON servidores(usuario_id);