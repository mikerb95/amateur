-- BD AMATEUR (consolidada)
-- =============================================

DROP DATABASE IF EXISTS AMATEUR;
CREATE DATABASE AMATEUR;
USE AMATEUR;

-- =============================================
-- TABLA: roles
-- =============================================
CREATE TABLE roles (
  id_rol INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
);

-- =============================================
-- TABLA: datos_usuarios
-- =============================================
CREATE TABLE datos_usuarios (
  id_usuario INT AUTO_INCREMENT PRIMARY KEY,
  cedula BIGINT UNIQUE NOT NULL,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  correo VARCHAR(120) NOT NULL,
  direccion VARCHAR(150) NULL,
  telefono VARCHAR(20) NULL,
  genero VARCHAR(15) NULL,
  fecha_nacimiento DATE NULL
);

-- =============================================
-- TABLA: perfil
-- =============================================
CREATE TABLE perfil (
  id_perfil INT AUTO_INCREMENT PRIMARY KEY,
  nombre_usuario VARCHAR(100) NOT NULL,
  contraseña VARCHAR(255) NOT NULL,
  id_rol INT NOT NULL DEFAULT 3,
  id_usuario INT UNIQUE NOT NULL,
  CONSTRAINT perfil_rol_fk FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
  CONSTRAINT perfil_usuario_fk FOREIGN KEY (id_usuario) REFERENCES datos_usuarios(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- TABLA: planes
-- =============================================
CREATE TABLE planes (
  id_planes INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT NULL,
  precio DECIMAL(10,2) NOT NULL,
  total_clases INT NOT NULL,
  duracion_dias INT NOT NULL DEFAULT 30,
  estado ENUM('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO',
  created_at DATETIME NULL,
  updated_at DATETIME NULL
);

-- =============================================
-- TABLA: clases
-- =============================================
CREATE TABLE clases (
  id_clases INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT NULL,
  fecha DATE NULL,
  dia_semana ENUM('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo') NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin TIME NOT NULL,
  cupo_maximo INT DEFAULT 8,
  cupo_disponible INT DEFAULT 8,
  id_rol INT NOT NULL,
  id_planes INT NOT NULL,
  disponible TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT clases_rol_fk FOREIGN KEY (id_rol) REFERENCES roles(id_rol),
  CONSTRAINT clases_plan_fk FOREIGN KEY (id_planes) REFERENCES planes(id_planes)
);

-- =============================================
-- TABLA: pagos
-- =============================================
CREATE TABLE pagos (
  id_pago INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  estado ENUM('Pago Cancelado','Pago Pendiente') DEFAULT 'Pago Pendiente',
  fecha_pago DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT pagos_usuario_fk FOREIGN KEY (id_usuario) REFERENCES datos_usuarios(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- =============================================
-- TABLA: reservas
-- =============================================
CREATE TABLE reservas (
  id_reservas INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  id_clases INT NOT NULL,
  fecha_reserva DATETIME DEFAULT CURRENT_TIMESTAMP,

  fecha_clase DATE NULL,
  hora_inicio TIME NULL,
  cancelada_en DATETIME NULL,

  id_paquete INT NULL,

  estado ENUM('Pendiente','Confirmada','Cancelada','Cancelada_Tarde','Completada','Consumida')
    NOT NULL DEFAULT 'Pendiente',

  clase_devuelta TINYINT(1) NOT NULL DEFAULT 0,

  CONSTRAINT reservas_usuario_fk FOREIGN KEY (id_usuario) REFERENCES datos_usuarios(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT reservas_clase_fk FOREIGN KEY (id_clases) REFERENCES clases(id_clases)
);

-- Evita duplicar reserva del mismo usuario a la misma clase el mismo día
ALTER TABLE reservas
  ADD UNIQUE KEY uq_reserva_usuario_clase_fecha (id_usuario, id_clases, fecha_clase);

-- =============================================
-- TABLA: paquetes_clases
-- =============================================
CREATE TABLE paquetes_clases (
  id_paquete INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  total_clases INT NOT NULL,
  clases_restantes INT NOT NULL,
  fecha_inicio DATETIME NOT NULL,
  fecha_vencimiento DATETIME NOT NULL,
  estado ENUM('ACTIVO','VENCIDO','AGOTADO') NOT NULL DEFAULT 'ACTIVO',
  creado_por INT NULL,
  CONSTRAINT paquetes_usuario_fk FOREIGN KEY (id_usuario) REFERENCES datos_usuarios(id_usuario)
    ON DELETE CASCADE ON UPDATE CASCADE
);

-- FK de reservas hacia paquetes (después de crear paquetes)
ALTER TABLE reservas
  ADD CONSTRAINT reservas_paquete_fk
  FOREIGN KEY (id_paquete) REFERENCES paquetes_clases(id_paquete)
  ON DELETE SET NULL ON UPDATE CASCADE;

-- =============================================
-- TABLA: consumo_clases
-- =============================================
CREATE TABLE consumo_clases (
  id_consumo INT AUTO_INCREMENT PRIMARY KEY,
  id_reservas INT NOT NULL UNIQUE,
  id_paquete INT NOT NULL,
  motivo ENUM('ASISTIO','NO_CANCELO_A_TIEMPO') NOT NULL,
  descontado_en DATETIME NOT NULL,
  CONSTRAINT consumo_reserva_fk FOREIGN KEY (id_reservas) REFERENCES reservas(id_reservas)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT consumo_paquete_fk FOREIGN KEY (id_paquete) REFERENCES paquetes_clases(id_paquete)
    ON DELETE RESTRICT ON UPDATE CASCADE
);

-- =============================================
-- TABLA: paquetes_catalogo
-- =============================================
CREATE TABLE paquetes_catalogo (
  id_catalogo INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL,
  clases_mes INT NOT NULL,
  vigencia_dias INT NOT NULL DEFAULT 30,
  activo TINYINT(1) NOT NULL DEFAULT 1
);

-- =============================================
-- INSERTS BASE
-- =============================================

INSERT INTO roles (id_rol, nombre) VALUES
(1, 'Administrador'),
(2, 'Instructor'),
(3, 'Usuario');

INSERT INTO planes (nombre, descripcion, precio, total_clases) VALUES

-- =========================
-- PLAN INDIVIDUAL
-- =========================
('Individual - Prueba 1 día',
 'Plan individual 1 día',
 25000,
 1),

('Individual - 12 clases',
 'Plan individual 12 clases',
 180000,
 12),

('Individual - 16 clases',
 'Plan individual 16 clases',
 224000,
 16),

('Individual - 20 clases',
 'Plan individual 20 clases',
 260000,
 20),

-- =========================
-- PLAN PAREJA
-- =========================
('Pareja - Prueba 1 día',
 'Plan pareja 1 día (por persona)',
 40000,
 1),

('Pareja - 12 clases',
 'Plan pareja 12 clases (por persona)',
 288000,
 12),

('Pareja - 16 clases',
 'Plan pareja 16 clases (por persona)',
 352000,
 16),

('Pareja - 20 clases',
 'Plan pareja 20 clases (por persona)',
 400000,
 20),

-- =========================
-- PLAN 4 PERSONAS
-- =========================
('4 Personas - Prueba 1 día',
 'Plan 4 personas 1 día (por persona)',
 45000,
 1),

('4 Personas - 12 clases',
 'Plan 4 personas 12 clases (por persona)',
 360000,
 12),

('4 Personas - 16 clases',
 'Plan 4 personas 16 clases (por persona)',
 432000,
 16),

('4 Personas - 20 clases',
 'Plan 4 personas 20 clases (por persona)',
 480000,
 20);

INSERT INTO datos_usuarios (cedula, nombre, apellido, correo, direccion, telefono, genero, fecha_nacimiento) VALUES
(1001094766, 'Juan', 'Cardenas', 'jecpecp2002@gmail.com', '', '3124990624', 'Masculino', '2002-01-01'),
(1001094666, 'Juan', 'Cardenas', 'jecpecp2002@gmail.com', NULL, '3124990624', 'Masculino', '2002-01-01'),
(1010101010, 'Sebastian', 'Luque', 'pesas.pesas@gmail.com', NULL, '3124991111', 'Masculino', '2002-01-01');

-- OJO: contraseñas en texto plano (solo pruebas)
INSERT INTO perfil (nombre_usuario, contraseña, id_rol, id_usuario) VALUES
('juanjuan','123',1,1),
('pruebausuario','pruebausuario',3,3);

INSERT INTO paquetes_catalogo (nombre, clases_mes, vigencia_dias, activo) VALUES
('Paquete 12', 12, 30, 1),
('Paquete 16', 16, 30, 1),
('Paquete 20', 20, 30, 1);

-- =============================================
-- CLASES (base)
-- =============================================
INSERT INTO clases (nombre, descripcion, fecha, dia_semana, hora_inicio, hora_fin, cupo_maximo, cupo_disponible, id_rol, id_planes) VALUES
('Clase 05:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '05:00:00', '06:00:00', 8, 8, 1, 1),
('Clase 06:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '06:00:00', '07:00:00', 8, 8, 1, 1),
('Clase 07:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '07:00:00', '08:00:00', 8, 8, 1, 1),
('Clase 08:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '08:00:00', '09:00:00', 8, 8, 1, 1),
('Clase 09:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '09:00:00', '10:00:00', 8, 8, 1, 1),
('Clase MMA Lunes 16-18', 'Clase MMA de 2 horas', NULL, 'Lunes', '16:00:00', '18:00:00', 8, 8, 1, 1),
('Clase 18:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '18:00:00', '19:00:00', 8, 8, 1, 1),
('Clase 19:00 Lunes', 'Clase de 1 hora', NULL, 'Lunes', '19:00:00', '20:00:00', 8, 8, 1, 1),

('Clase 05:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '05:00:00', '06:00:00', 8, 8, 1, 1),
('Clase 06:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '06:00:00', '07:00:00', 8, 8, 1, 1),
('Clase 07:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '07:00:00', '08:00:00', 8, 8, 1, 1),
('Clase 08:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '08:00:00', '09:00:00', 8, 8, 1, 1),
('Clase 09:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '09:00:00', '10:00:00', 8, 8, 1, 1),
('Clase MMA Martes 16-18', 'Clase MMA de 2 horas', NULL, 'Martes', '16:00:00', '18:00:00', 8, 8, 1, 1),
('Clase 18:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '18:00:00', '19:00:00', 8, 8, 1, 1),
('Clase 19:00 Martes', 'Clase de 1 hora', NULL, 'Martes', '19:00:00', '20:00:00', 8, 8, 1, 1),

('Clase 05:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '05:00:00', '06:00:00', 8, 8, 1, 1),
('Clase 06:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '06:00:00', '07:00:00', 8, 8, 1, 1),
('Clase 07:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '07:00:00', '08:00:00', 8, 8, 1, 1),
('Clase 08:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '08:00:00', '09:00:00', 8, 8, 1, 1),
('Clase 09:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '09:00:00', '10:00:00', 8, 8, 1, 1),
('Clase MMA Miércoles 16-18', 'Clase MMA de 2 horas', NULL, 'Miércoles', '16:00:00', '18:00:00', 8, 8, 1, 1),
('Clase 18:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '18:00:00', '19:00:00', 8, 8, 1, 1),
('Clase 19:00 Miércoles', 'Clase de 1 hora', NULL, 'Miércoles', '19:00:00', '20:00:00', 8, 8, 1, 1),

('Clase 05:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '05:00:00', '06:00:00', 8, 8, 1, 1),
('Clase 06:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '06:00:00', '07:00:00', 8, 8, 1, 1),
('Clase 07:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '07:00:00', '08:00:00', 8, 8, 1, 1),
('Clase 08:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '08:00:00', '09:00:00', 8, 8, 1, 1),
('Clase 09:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '09:00:00', '10:00:00', 8, 8, 1, 1),
('Clase MMA Jueves 16-18', 'Clase MMA de 2 horas', NULL, 'Jueves', '16:00:00', '18:00:00', 8, 8, 1, 1),
('Clase 18:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '18:00:00', '19:00:00', 8, 8, 1, 1),
('Clase 19:00 Jueves', 'Clase de 1 hora', NULL, 'Jueves', '19:00:00', '20:00:00', 8, 8, 1, 1),

('Clase 05:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '05:00:00', '06:00:00', 8, 8, 1, 1),
('Clase 06:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '06:00:00', '07:00:00', 8, 8, 1, 1),
('Clase 07:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '07:00:00', '08:00:00', 8, 8, 1, 1),
('Clase 08:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '08:00:00', '09:00:00', 8, 8, 1, 1),
('Clase 09:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '09:00:00', '10:00:00', 8, 8, 1, 1),
('Clase MMA Viernes 16-18', 'Clase MMA de 2 horas', NULL, 'Viernes', '16:00:00', '18:00:00', 8, 8, 1, 1),
('Clase 18:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '18:00:00', '19:00:00', 8, 8, 1, 1),
('Clase 19:00 Viernes', 'Clase de 1 hora', NULL, 'Viernes', '19:00:00', '20:00:00', 8, 8, 1, 1),

('Clase 07:00 Sábado', 'Clase de 1 hora', NULL, 'Sábado', '07:00:00', '08:00:00', 8, 8, 1, 1),
('Clase 08:00 Sábado', 'Clase de 1 hora', NULL, 'Sábado', '08:00:00', '09:00:00', 8, 8, 1, 1),
('Clase 09:00 Sábado', 'Clase de 1 hora', NULL, 'Sábado', '09:00:00', '10:00:00', 8, 8, 1, 1),
('Clase 10:00 Sábado', 'Clase de 1 hora', NULL, 'Sábado', '10:00:00', '11:00:00', 8, 8, 1, 1),
('Clase 11:00 Sábado', 'Clase de 1 hora', NULL, 'Sábado', '11:00:00', '12:00:00', 8, 8, 1, 1);

-- ============================================
