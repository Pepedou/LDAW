drop database `ldaw@1018566`;
create database `ldaw@1018566`;
use ldaw@1018566;

SET storage_engine=INNODB;

SOURCE Ajax_Estados.sql;

CREATE TABLE Direcciones (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, calle varchar(30) NOT NULL DEFAULT 'N/D', colonia varchar(30) NOT NULL DEFAULT 'N/D', id_Municipio int NOT NULL, ciudad varchar(30) NOT NULL, id_Estado int NOT NULL, cp int NOT NULL DEFAULT 0, FOREIGN KEY(id_Municipio) REFERENCES Municipios(id) ON DELETE RESTRICT, FOREIGN KEY (id_Estado) REFERENCES Estados(id) ON DELETE RESTRICT);

CREATE TABLE Complejidades (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, complejidad int NOT NULL);

CREATE TABLE Despachos (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(50) NOT NULL, id_Direccion int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Direccion) REFERENCES Direcciones(id) ON DELETE SET NULL);

CREATE TABLE Roles (id int PRIMARY KEY AUTO_INCREMENT, rol varchar(15) NOT NULL DEFAULT 'Sin rol');

CREATE TABLE Abogados (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(30) NOT NULL, apellidoP varchar(30) NOT NULL, apellidoM varchar(30) NOT NULL, telefono int, email varchar(30), contrasena varchar(128) NOT NULL, id_Rol int, id_Despacho int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Rol) REFERENCES Roles(id) ON DELETE SET NULL, FOREIGN KEY (id_Despacho) REFERENCES Despachos(id) ON DELETE CASCADE);

CREATE TABLE Casos (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100), status int, id_Despacho int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Despacho) REFERENCES Despachos(id) ON DELETE CASCADE);

CREATE TABLE Abogados_Casos (id int PRIMARY KEY AUTO_INCREMENT, id_Abogado int, id_Caso int, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY (id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Tareas (id int PRIMARY KEY AUTO_INCREMENT, descripcion varchar(250), inicio DATE , fin DATE, status int , id_Abogado int, id_Caso int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Expedientes(id int PRIMARY KEY AUTO_INCREMENT, id_Caso int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Tipos(id int PRIMARY KEY AUTO_INCREMENT, tipo varchar(10) NOT NULL);

CREATE TABLE Documentos (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, documento blob NOT NULL, id_Expediente int NOT NULL, id_Tipo int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Expediente) REFERENCES Expedientes(id) ON DELETE CASCADE);

CREATE TABLE Clientes(id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100) NOT NULL, id_Direccion int NOT NULL, telefono int, email varchar(50) NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Direccion) REFERENCES Direcciones(id) ON DELETE CASCADE);

CREATE TABLE Abogados_Clientes (id int NOT NULL PRIMARY KEY AUTO_INCREMENT, id_Abogado int NOT NULL, id_Cliente int NOT NULL, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);

CREATE TABLE Logs (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, id_Documento int NOT NULL, fecha date NOT NULL, visible bool NOT NULL DEFAULT TRUE, id_Abogado int NOT NULL, FOREIGN KEY(id_Documento) REFERENCES Documentos(id) ON DELETE CASCADE, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE);

CREATE TABLE Pagos (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, cantidad decimal(30,5) NOT NULL, id_Cliente int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);









