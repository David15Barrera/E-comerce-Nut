CREATE SCHEMA IF NOT EXISTS ECOMARCEDB; 

use ECOMARCEDB;

CREATE TABLE IF NOT EXISTS USUARIO(
	idUser INT AUTO_INCREMENT,
	email VARCHAR(100) UNIQUE NOT NULL,
	password VARCHAR(100) NOT NULL,
	rol VARCHAR(100) NOT NULL,
	estatus VARCHAR(75),
	dateRegistro VARCHAR(50),
	lastConexion VARCHAR(50)
	PRIMARY KEY(idUser)
);

CREATE TABLE IF NOT EXISTS USUARIODATOS(
	idUserdatos INT AUTO_INCREMENT,
	name VARCHAR(255),
	lastName VARCHAR(255),
    dpiUser VARCHAR(225) UNIQUE NOT NULL,
    nitUserDatos VARCHAR(100) NOT NULL,
    direccionUser VARCHAR(150),
    telefonoUser VARCHAR(8) NOT NULL,
    genero VARCHAR(15),
	PRIMARY KEY(idUserdatos),
	FOREIGN KEY (idUserdatos) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS PUBLICACIONES(
	idPublicaciones int AUTO_INCREMENT,
	userId int(50),
	Tipo VARCHAR(250),
	titulo VARCHAR(250),
	Descripcion TEXT,
	categoria VARCHAR(255),
	estado ENUM('APROBADA', 'RECHAZADA', 'PENDIENTE'),
	Imagen BLOB,
	precioSistema decimal(10, 2,)
	precioLocal decimal(10, 2),
	cantidadDisponible INT,
	ubicacion VARCHAR(255),
	FechaPublicacion DATETIME,
	FecaExpiracion DATETIME,
	PRIMARY KEY (idPublicaciones),
	FOREIGN KEY (userId) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS CHATS(
	idChat INT,
	publicacionesId INT,
	emisor INT,
	receptor INT,
	mensaje TEXT,
	timeMessage DATETIME,
	PRIMARY KEY (idChat),
	FOREIGN KEY (publicacionesId) REFERENCES PUBLICACIONES(idPublicaciones),
	FOREIGN KEY (emisor) REFERENCES USUARIO(idUser),
	FOREIGN KEY (receptor) REFERENCES USUARIO(idUser)
);

CREATE TABLE IF NOT EXISTS TRANSACCIONES(
	idTransaccion INT AUTO_INCREMENT,
	vendedorId INT,
	compradorId INT,
	publicacionesId INT,
	Monto decimal(10, 2),
	moneda ENUM('sistema','local')
	dateTransaccion DATETIME,
	PRIMARY KEY (idTransaccion),
	FOREIGN KEY (vendedorId) REFERENCES USUARIO(idUser),
    FOREIGN KEY (compradorId) REFERENCES USUARIO(idUser),
    FOREIGN KEY (publicacionesId) REFERENCES PUBLICACIONES(idPublicaciones)
);

--Tabla con datos aun por definir
CREATE TABLE IF NOT EXISTS FACTURAS(
	idFactura INT AUTO_INCREMENT,
	transaccionesId INT,
	PRIMARY KEY (idFactura)
);


CREATE TABLE CREDITOS (
    idCredito INT AUTO_INCREMENT,
    userId INT,
    Monto DECIMAL(10, 2),
    FechaGeneracion DATETIME,
    Estado ENUM('pendiente', 'utilizado'),
	PRIMARY KEY (idCredito),
    FOREIGN KEY (userId) REFERENCES USUARIO(idUser)
);

CREATE TABLE REPORTES (
    idReporte INT AUTO_INCREMENT,
    userReportadoId INT,
    userReportadorId INT,
    publicacionId INT,
    razonReporte TEXT,
    estadoReporte ENUM('pendiente', 'resuelto'),
    PRIMARY KEY (idReporte)
    FOREIGN KEY (userReportadoId) REFERENCES USUARIO(UserID),
    FOREIGN KEY (userReportadorId) REFERENCES USUARIO(UserID),
    FOREIGN KEY (publicacionId) REFERENCES PUBLICACIONES(idPublicaciones)
);

CREATE TABLE VALORACIONES (
    idValoraciones INT AUTO_INCREMENT,
    userEvaluadorId INT,
    userEvaluadoId INT,
    publicacionId INT,
    puntuacion INT,
    comentario TEXT,
    dateValoracion DATETIME,
	PRIMARY KEY (idValoraciones),
    FOREIGN KEY (userEvaluadorId) REFERENCES Usuarios(UserID),
    FOREIGN KEY (userEvaluadoId) REFERENCES Usuarios(UserID),
    FOREIGN KEY (publicacionId) REFERENCES Publicaciones(PublicacionID)
);
