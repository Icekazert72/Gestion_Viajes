DROP DATABASE IF EXISTS db_ndong_viajes;

CREATE DATABASE db_ndong_viajes;

USE db_ndong_viajes;

CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellidos VARCHAR(100),
    edad INT(9),
    DNI VARCHAR(100),
    email VARCHAR BIGINT(100),
    telefono VARCHAR(10),
    PASSWORD_HASH VARCHAR(100),
    imagen VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE agencias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    direccion VARCHAR(200),
    telefono VARCHAR(100),
    email VARCHAR(100),
    usuario INT(9),
    PASSWORD_HASH VARCHAR(255),
    imagen VARCHAR(100),
    activo BOOLEAN DEFAULT TRUE,
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
    region ENUM('continental', 'regional'),
    origen VARCHAR(100),
    destino VARCHAR(100),
    horario TIME,
    precio DECIMAL (10.9),
    agencia INT(9),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE viajes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha_salida DATETIME,
    fecha_llegada DATETIME,
    agencia INT(9),
    precio DECIMAL(10.2),
    bus INT(9),
    ruta INT(9),
    estado ENUM(
        'activo',
        'cancelado',
        'finalizado'
    ),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    FOREIGN KEY (bus) REFERENCES buses (id),
    FOREIGN KEY (ruta) REFERENCES rutas (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE epleados_agencias (
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
    usuario_login VARCHAR(100),
    PASSWORD_HASH VARCHAR(255),
    rol ENUM('admin', 'empleado'),
    activo BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservas (
    id int PRIMARY KEY AUTO_INCREMENT,
    cliente INT(10),
    agencia INT(10),
    ruta INT(10),
    bus INT(10),
    cleinte_agregado_nombre VARCHAR(100),
    cleinte_agregado_apellidos VARCHAR(100),
    cleinte_agregado_edad VARCHAR(10),
    cleinte_agregado_telefono VARCHAR(10),
    tipo_servicio VARCHAR(50),
    FOREIGN KEY (cliente) REFERENCES usuarios (id),
    FOREIGN KEY (agencia) REFERENCES agencias (id),
    FOREIGN KEY (ruta) REFERENCES rutas (id),
    FOREIGN KEY (bus) REFERENCES buses (id),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reseñas (
    id INT PRIMARY AUTO_INCREMENT,
    usuario INT,
    comentario TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);