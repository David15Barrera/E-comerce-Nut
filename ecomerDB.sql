CREATE SCHEMA IF NOT EXISTS ECOMARCEDB; 

use ECOMARCEDB;

CREATE TABLE IF NOT EXISTS USUARIO(
    idUser INT UNSIGNED AUTO_INCREMENT,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    rol VARCHAR(100) NOT NULL,
    estatus VARCHAR(75),
    PRIMARY KEY(idUser) 
);

CREATE TABLE IF NOT EXISTS USUARIODATOS(
    idUserdatos INT AUTO_INCREMENT,
    userId INT UNSIGNED,
    name VARCHAR(255),
    lastName VARCHAR(255),
    dpiUser VARCHAR(225) UNIQUE NOT NULL,
    nitUserDatos VARCHAR(100) NOT NULL,
    direccionUser VARCHAR(150),
    telefonoUser VARCHAR(20) NOT NULL,
    genero VARCHAR(15),
    dateRegistro VARCHAR(50),
    PRIMARY KEY(idUserdatos),
    FOREIGN KEY(userId) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS PUNTOS (
    idPuntos INT AUTO_INCREMENT,
    userId INT UNSIGNED,
    Monto INT,
    descripcion VARCHAR(255),
    fechaoObtencion DATETIME,
	PRIMARY KEY (idPuntos),
    FOREIGN KEY (userId) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS UBICACION (
    idUbicacion INT AUTO_INCREMENT,
    pais VARCHAR(255),
    ciudad VARCHAR(255),
    PRIMARY KEY(idUbicacion)
);

CREATE TABLE IF NOT EXISTS PUBLICACIONES (
    idPublicaciones INT AUTO_INCREMENT,
    userId INT UNSIGNED,
    idUbicacion INT,
    Tipo VARCHAR(250),
    titulo VARCHAR(250),
    Descripcion TEXT,
    categoria VARCHAR(255),
    estado ENUM('APROBADA', 'RECHAZADA', 'PENDIENTE'),
    Imagen BLOB,
    precioSistema DECIMAL(10, 2),
    precioLocal DECIMAL(10, 2),
    cantidadDisponible INT,
    FechaPublicacion DATETIME,
    FechaExpiracion DATETIME,
    puntos INT,
    PRIMARY KEY(idPublicaciones),
    FOREIGN KEY (userId) REFERENCES USUARIO(idUser),
    FOREIGN KEY (idUbicacion) REFERENCES UBICACION(idUbicacion)
);

CREATE TABLE IF NOT EXISTS CHATS(
	idChat INT AUTO_INCREMENT,
	publicacionesId INT,
	emisor INT UNSIGNED,
	receptor INT UNSIGNED,
	mensaje TEXT,
	timeMessage DATETIME,
	PRIMARY KEY (idChat),
	FOREIGN KEY (publicacionesId) REFERENCES PUBLICACIONES(idPublicaciones),
	FOREIGN KEY (emisor) REFERENCES USUARIO(idUser),
	FOREIGN KEY (receptor) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS CARRITO (
    idCarrito INT AUTO_INCREMENT,
    userId INT UNSIGNED,
    publicacionId INT,
    cantidad INT,
    fechaAgregado DATETIME,
    PRIMARY KEY(idCarrito),
    FOREIGN KEY(userId) REFERENCES USUARIO(idUser),
    FOREIGN KEY(publicacionId) REFERENCES PUBLICACIONES(idPublicaciones)
);


CREATE TABLE IF NOT EXISTS VENTAS (
    idventas INT AUTO_INCREMENT,
    userId INT UNSIGNED,
    cantidad INT,
    dateRegistro DATE,
    timeRegistro TIME,
    total DECIMAL(10, 2),
    estado VARCHAR(100),
    PRIMARY KEY(idventas),
    FOREIGN KEY(userId) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS DETALLETRANSACCIONES (
    idTransaccion INT AUTO_INCREMENT,
    ventasid INT,
    publicacionesId INT,
    montoUnitario DECIMAL(10, 2),
    moneda ENUM('sistema','local'),
    direccionVenta VARCHAR(150),
    pais VARCHAR(150),
    PRIMARY KEY (idTransaccion),
    FOREIGN KEY (ventasid) REFERENCES VENTAS(idventas),
    FOREIGN KEY (publicacionesId) REFERENCES PUBLICACIONES(idPublicaciones)
);


CREATE TABLE CREDITOS (
    idCredito INT AUTO_INCREMENT,
    userId INT UNSIGNED,
    Monto DECIMAL(10, 2),
    FechaGeneracion DATETIME,
    Estado ENUM('pendiente', 'utilizado'),
	PRIMARY KEY (idCredito),
    FOREIGN KEY (userId) REFERENCES USUARIO(idUser)
);

CREATE TABLE REPORTES (
    idReporte INT AUTO_INCREMENT,
    userReportadoId INT UNSIGNED,
    userReportadorId INT UNSIGNED,
    publicacionId INT,
    razonReporte TEXT,
    estadoReporte ENUM('pendiente', 'resuelto'),
    PRIMARY KEY(idReporte),
    FOREIGN KEY(userReportadoId) REFERENCES USUARIO(idUser),
    FOREIGN KEY(userReportadorId) REFERENCES USUARIO(idUser),
    FOREIGN KEY(publicacionId) REFERENCES PUBLICACIONES(idPublicaciones)
);

CREATE TABLE VALORACIONES (
    idValoraciones INT AUTO_INCREMENT,
    userEvaluadorId INT UNSIGNED,
    publicacionId INT,
    puntuacion INT,
    comentario TEXT,
    dateValoracion DATE,
    PRIMARY KEY(idValoraciones),
    FOREIGN KEY(userEvaluadorId) REFERENCES USUARIO(idUser),
    FOREIGN KEY(publicacionId) REFERENCES PUBLICACIONES(idPublicaciones)
);


-- Datos de ejemplo para la tabla VALORACIONES
INSERT INTO VALORACIONES (userEvaluadorId, publicacionId, puntuacion, comentario, dateValoracion) VALUES
(1, 1, 5, 'Excelente producto, muy satisfecho con la compra.', '2024-03-01'),
(2, 1, 4, 'Buen servicio, entrega rápida.', '2024-03-02'),
(3, 1, 3, 'Producto en buen estado, pero el envío fue un poco lento.', '2024-03-03'),
(1, 2, 5, 'Altamente recomendado, el vendedor es muy amable y atento.', '2024-03-04'),
(2, 2, 4, 'Buena comunicación con el vendedor.', '2024-03-05');
