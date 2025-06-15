DROP DATABASE IF EXISTS db_ndong_viajes;

CREATE DATABASE db_ndong_viajes;

USE db_ndong_viajes;

CREATE TABLE agencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    direccion VARCHAR(200),
    descripcion TEXT,
    telefono VARCHAR(100),
    email VARCHAR(100),
    usuario VARCHAR(9),
    PASSWORD_HASH VARCHAR(255),
    imagen VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    edad INT(9),
    DNI VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(10),
    PASSWORD_HASH VARCHAR(100),
    imagen VARCHAR(100),
    agencia INT(9),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE buses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    placa VARCHAR(20),
    numero_bus VARCHAR(100),
    modelo VARCHAR(100),
    capacidad INT(9),
    activo BOOLEAN DEFAULT TRUE,
    agencia INT(9),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rutas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    region ENUM('continental', 'insular') NOT NULL,
    origen VARCHAR(100),
    destino VARCHAR(100),
    horario TIME,
    precio DECIMAL(10.9),
    agencia INT(9),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE viajes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha_viaje DATE,
    hora_llegada TIME,
    hora_salida TIME,
    bus INT(9),
    ruta INT(9),
    agencia INT(9),
    estado ENUM(
        'pendiente',
        'activo',
        'cancelado',
        'finalizado'
    ) DEFAULT 'pendiente',
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    FOREIGN KEY (bus) REFERENCES buses (id),
    FOREIGN KEY (ruta) REFERENCES rutas (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ALTER TABLE viajes DROP COLUMN fecha_salida;
-- ALTER TABLE viajes DROP COLUMN fecha_llegada;
-- ALTER TABLE viajes DROP COLUMN precio;
-- ALTER TABLE viajes ADD COLUMN hora_salida TIME;
-- ALTER TABLE reservas DROP COLUMN id_ruta;
-- ALTER TABLE reservas DROP COLUMN id_bus;
-- ALTER TABLE reservas ADD COLUMN viaje_id INT DEFAULT NULL;
-- ALTER TABLE reservas
-- ADD FOREIGN KEY (viaje_id) REFERENCES viajes (id);
-- ALTER TABLE viajes 
-- ADD COLUMN estado ENUM('pendiente', 'activo', 'cancelado', 'finalizado') 
-- DEFAULT 'pendiente';

CREATE TABLE empleados_agencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    telefono VARCHAR(100),
    edad INT(9),
    fecha_nacimiento DATETIME,
    DNI VARCHAR(255),
    email VARCHAR(100),
    imagen VARCHAR(100),
    agencia INT(9),
    PASSWORD_HASH VARCHAR(255),
    rol ENUM(
        'admin',
        'empleado',
        'conductor'
    ) NOT NULL DEFAULT 'empleado',
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tutores (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    telefono VARCHAR(20),
    dni VARCHAR(20)
    usuario INT(9),
    FOREIGN KEY (usuario) REFERENCES usuarios (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE clientes_temporales (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    edad INT(9),
    DNI VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(10),
    imagen VARCHAR(100) DEFAULT NULL,
    agencia INT(9),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT DEFAULT NULL, -- si es un usuario registrado
    cliente_temporal_id INT DEFAULT NULL, -- si no está registrado
    agencia_id INT,
    viaje_id INT,
    tipo_servicio VARCHAR(50),
    num_asiento_bus INT(9),
    tutor_id INT DEFAULT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado_pago ENUM(
        'pendiente',
        'confirmada',
        'cancelada',
        'finalizada'
    ) DEFAULT 'pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id),
    FOREIGN KEY (cliente_temporal_id) REFERENCES clientes_temporales (id),
    FOREIGN KEY (agencia_id) REFERENCES agencias (id),
    FOREIGN KEY (viaje_id) REFERENCES viajes (id),
    FOREIGN KEY (tutor_id) REFERENCES tutores (id)
);


CREATE TABLE pasajeros_reserva (
    id INT PRIMARY KEY AUTO_INCREMENT,
    reserva_id INT,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    edad INT,
    telefono VARCHAR(20),
    FOREIGN KEY (reserva_id) REFERENCES reservas (id)
);

CREATE TABLE reseñas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    viaje_id INT NOT NULL,
    comentario TEXT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    FOREIGN KEY (viaje_id) REFERENCES viajes (id) ON DELETE CASCADE
);

CREATE TABLE asignaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bus_id INT NOT NULL,
    conductor_id INT NOT NULL,
    fecha_asignacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (bus_id) REFERENCES buses (id) ON DELETE CASCADE,
    FOREIGN KEY (conductor_id) REFERENCES empleados_agencias (id) ON DELETE CASCADE
);