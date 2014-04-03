drop database `ldaw@1018566`;
create database `ldaw@1018566`;
use ldaw@1018566;

SET storage_engine=INNODB;

SOURCE Ajax_Estados.sql;

CREATE TABLE Direcciones (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, calle varchar(30) NOT NULL DEFAULT 'N/D', no_exterior varchar(10) DEFAULT "-", no_interior varchar(10) DEFAULT "-", colonia varchar(30) NOT NULL DEFAULT 'N/D', id_Municipio int NOT NULL, ciudad varchar(30) NOT NULL, cp varchar(10) NOT NULL DEFAULT "0", FOREIGN KEY(id_Municipio) REFERENCES Municipios(id) ON DELETE RESTRICT);

CREATE TABLE Complejidades (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, complejidad int NOT NULL);

CREATE TABLE Despachos (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(50) NOT NULL, id_Direccion int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Direccion) REFERENCES Direcciones(id) ON DELETE SET NULL);

CREATE TABLE Roles (id int PRIMARY KEY AUTO_INCREMENT, rol varchar(15) NOT NULL DEFAULT 'Sin rol');

CREATE TABLE Abogados (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(30) NOT NULL, apellidoP varchar(30) NOT NULL, apellidoM varchar(30) NOT NULL, telefono int, email varchar(30), contrasena varchar(128) NOT NULL, id_Rol int, id_Despacho int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Rol) REFERENCES Roles(id) ON DELETE SET NULL, FOREIGN KEY (id_Despacho) REFERENCES Despachos(id) ON DELETE CASCADE);

CREATE TABLE Casos (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100), status int, id_Despacho int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Despacho) REFERENCES Despachos(id) ON DELETE CASCADE);

CREATE TABLE Abogados_Casos ( id_Abogado int NOT NULL, id_Caso int NOT NULL, PRIMARY KEY(id_Abogado, id_Caso), FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY (id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Tareas (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100), descripcion varchar(250), inicio DATE , fin DATE, status int , id_Abogado int, id_Caso int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Expedientes(id int PRIMARY KEY AUTO_INCREMENT, id_Caso int, nombre varchar(50) NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Tipos(id int PRIMARY KEY AUTO_INCREMENT, tipo varchar(10) NOT NULL);

CREATE TABLE Documentos (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, nombre varchar(200) NOT NULL, documento blob NOT NULL, id_Expediente int NOT NULL, id_Tipo int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Expediente) REFERENCES Expedientes(id) ON DELETE CASCADE);

CREATE TABLE Clientes(id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(30) NOT NULL, apellidoP varchar(30) NOT NULL, apellidoM varchar(30) NOT NULL, id_Direccion int NOT NULL, telefono int, email varchar(50) NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Direccion) REFERENCES Direcciones(id) ON DELETE CASCADE);

CREATE TABLE Abogados_Clientes (id_Abogado int NOT NULL, id_Cliente int NOT NULL, PRIMARY KEY(id_Abogado, id_Cliente), FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);

CREATE TABLE Logs (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, id_Documento int NOT NULL, fecha date NOT NULL, id_Abogado int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Documento) REFERENCES Documentos(id) ON DELETE CASCADE, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE);

CREATE TABLE Pagos (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, cantidad decimal(30,5) NOT NULL, id_Cliente int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);

INSERT INTO Direcciones (calle, no_exterior, no_interior, colonia,id_Municipio, ciudad, cp) VALUES ("Av. Vasco de Quiroga", "1000", "A", "Santa Fe", 1, "Ciudad de México", "01780");

INSERT INTO Despachos (nombre, id_Direccion) VALUES ("Despacho 1", 1);

INSERT INTO Roles (rol) VALUES ("Administrador");

INSERT INTO Abogados (nombre, apellidoP, apellidoM, telefono, email, contrasena, id_Rol, id_Despacho) VALUES ("José Luis", "Valencia", "Herrera", 55851891, "pepedou@gmail.com", SHA1("asdf"), 1, 1);

INSERT INTO Clientes (nombre, apellidoP, apellidoM, id_Direccion, telefono, email) VALUES ("Juan Abrupto", "Carrazco", "Solís", 1, 22101465, "jabrc@gmail.com");

INSERT INTO Tipos (tipo) VALUES ("PDF");

INSERT INTO Casos (nombre, status, id_Despacho) VALUES ("PÉREZ VS JUÁREZ", 1, 1);

INSERT INTO Expedientes (id_Caso, nombre) VALUES (1, "Pruebas");

INSERT INTO Documentos (documento, id_Expediente, id_Tipo) VALUES ("ASDF", 1, 1);

INSERT INTO Abogados_Casos VALUES (1, 1);

INSERT INTO Abogados_Clientes VALUES (1, 1);








