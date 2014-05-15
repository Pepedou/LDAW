drop database `ldaw@1018566`;
create database `ldaw@1018566`;
use ldaw@1018566;

SET storage_engine=INNODB;

SOURCE Ajax_Estados.sql;

CREATE TABLE Direcciones (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, calle varchar(30) NOT NULL DEFAULT 'N/D', no_exterior varchar(10) DEFAULT "-", no_interior varchar(10) DEFAULT "-", colonia varchar(30) NOT NULL DEFAULT 'N/D', id_Municipio int NOT NULL, ciudad varchar(30) NOT NULL, cp varchar(10) NOT NULL DEFAULT "0", FOREIGN KEY(id_Municipio) REFERENCES Municipios(id) ON DELETE RESTRICT);

CREATE TABLE Despachos (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(50) NOT NULL, id_Direccion int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Direccion) REFERENCES Direcciones(id) ON DELETE SET NULL);

CREATE TABLE Roles (id int PRIMARY KEY AUTO_INCREMENT, rol varchar(15) NOT NULL DEFAULT 'Sin rol');

CREATE TABLE Abogados (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(30) NOT NULL, apellidoP varchar(30) NOT NULL, apellidoM varchar(30) NOT NULL, telefono int, email varchar(30), contrasena varchar(128) NOT NULL, fotografia varchar(200) DEFAULT "http://ubiquitous.csf.itesm.mx/~ldaw-1018566/content/Proyecto/Imagenes/default-mr.png" ,id_Rol int, id_Despacho int NOT NULL, visible bool NOT NULL DEFAULT TRUE, puntos int NOT NULL DEFAULT 0, votos int NOT NULL DEFAULT 0, FOREIGN KEY (id_Rol) REFERENCES Roles(id) ON DELETE SET NULL, FOREIGN KEY (id_Despacho) REFERENCES Despachos(id) ON DELETE CASCADE);

CREATE TABLE Clientes(id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(30) NOT NULL, apellidoP varchar(30) NOT NULL, apellidoM varchar(30) NOT NULL, id_Direccion int NOT NULL, telefono int, email varchar(50) NOT NULL, contrasena varchar(128) NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Direccion) REFERENCES Direcciones(id) ON DELETE CASCADE);

CREATE TABLE Casos (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100), descripcion text,  status int, id_Despacho int, id_Cliente int,  visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Despacho) REFERENCES Despachos(id) ON DELETE CASCADE, FOREIGN KEY (id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);

CREATE TABLE Abogados_Casos (id int PRIMARY KEY AUTO_INCREMENT, id_Abogado int, id_Caso int, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY (id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Tareas (id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100), descripcion varchar(500), inicio DATE , fin DATE, status int , id_Abogado int, id_Caso int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Expedientes(id int PRIMARY KEY AUTO_INCREMENT, nombre varchar(100) NOT NULL, id_Caso int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY (id_Caso) REFERENCES Casos(id) ON DELETE CASCADE);

CREATE TABLE Documentos (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, nombre varchar(100) NOT NULL, documento varchar(500) NOT NULL, id_Expediente int NOT NULL, tipo varchar(20) NOT NULL, tamano int, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Expediente) REFERENCES Expedientes(id) ON DELETE CASCADE);

CREATE TABLE Abogados_Clientes (id int NOT NULL PRIMARY KEY AUTO_INCREMENT, id_Abogado int NOT NULL, id_Cliente int NOT NULL, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);

CREATE TABLE Logs (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, id_Documento int NOT NULL, fecha date NOT NULL, visible bool NOT NULL DEFAULT TRUE, id_Abogado int NOT NULL, FOREIGN KEY(id_Documento) REFERENCES Documentos(id) ON DELETE CASCADE, FOREIGN KEY(id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE);

CREATE TABLE Pagos (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, cantidad decimal(30,5) NOT NULL, id_Cliente int NOT NULL, visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(id_Cliente) REFERENCES Clientes(id) ON DELETE CASCADE);

CREATE TABLE ComentariosCaso (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, comentario varchar(200) NOT NULL, id_Abogado int NOT NULL, id_Caso int NOT NULL, creado TIMESTAMP NOT NULL DEFAULT NOW(), visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(Id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Caso) REFERENCES Casos(id));

CREATE TABLE ComentariosTarea (id int NOT NULL AUTO_INCREMENT PRIMARY KEY, comentario varchar(200) NOT NULL, id_Abogado int NOT NULL, id_Tarea int NOT NULL,creado TIMESTAMP NOT NULL DEFAULT NOW(),  visible bool NOT NULL DEFAULT TRUE, FOREIGN KEY(Id_Abogado) REFERENCES Abogados(id) ON DELETE CASCADE, FOREIGN KEY(id_Tarea) REFERENCES Tareas(id));


INSERT INTO Direcciones (calle, no_exterior, no_interior, colonia,id_Municipio, ciudad, cp) VALUES ("Av. Vasco de Quiroga", "1000", "A", "Santa Fe", 1, "Ciudad de México", "01780");

INSERT INTO Direcciones (calle, no_exterior, no_interior, colonia,id_Municipio, ciudad, cp) VALUES ("Av. Insurgentes Norte", "2100", "602", "Narvarte", 1, "Ciudad de México", "01010");

INSERT INTO Despachos (nombre, id_Direccion) VALUES ("Despacho 1", 1);

INSERT INTO Despachos (nombre, id_Direccion) VALUES ("Despacho 2", 2);

INSERT INTO Roles (rol) VALUES ("Administrador");

INSERT INTO Roles (rol) VALUES ("Abogado");

INSERT INTO Abogados (nombre, apellidoP, apellidoM, telefono, email, contrasena, id_Rol, id_Despacho, puntos, votos) VALUES ("José Luis", "Valencia", "Herrera", 55851891, "pepedou@gmail.com", SHA1("asdf"), 2, 1, 25, 5);

INSERT INTO Abogados (nombre, apellidoP, apellidoM, telefono, email, contrasena, id_Rol, id_Despacho, puntos, votos) VALUES ("Estefanía Gabriela", "Torres", "Zetina", 22232107, "ani.ammp@gmail.com", SHA1("asdf"), 1, 2, 8, 33);

INSERT INTO Clientes (nombre, apellidoP, apellidoM, id_Direccion, telefono, email, contrasena) VALUES ("Juan Abrupto", "Carrazco", "Solís", 1, 22101465, "jabrc@gmail.com", SHA1("asdf"));

INSERT INTO Clientes (nombre, apellidoP, apellidoM, id_Direccion, telefono, email, contrasena) VALUES ("María Juana", "Ramírez", "Ortiz", 1, 22101465, "majuja@hotmail.com", SHA1("asdf"));

INSERT INTO Casos (nombre, descripcion, status, id_Despacho, id_Cliente) VALUES ("Pérez vs Juárez", "Pelea de hermanos.", 1, 1, 1);

INSERT INTO Casos (nombre, descripcion, status, id_Despacho, id_Cliente) VALUES ("Divorcio Rodríguez", "Diferencias irreconciliables.", 1, 1, 2);

INSERT INTO Casos (nombre, descripcion, status, id_Despacho, id_Cliente) VALUES ("Ejido Roble Grande", "El gobierno les quiere quitar su ejido.", 1, 2, 2);

INSERT INTO Casos (nombre, descripcion, status, id_Despacho, id_Cliente) VALUES ("Herencia Martínez", "Toda la familia quiere el yate.", 1, 2, 1);

INSERT INTO Tareas (nombre, descripcion, inicio, fin, status, id_Abogado, id_Caso) VALUES ("Recoger expediente.", "Hay que ir a recoger el expediente de la señora Pérez para digitalizarlo.", NOW(), NOW() + INTERVAL 1 WEEK, 1, 1, 1);

INSERT INTO Tareas (nombre, descripcion, inicio, fin, status, id_Abogado, id_Caso) VALUES ("Sacar copias.", "Sacar fotocopias de las escrituras.", NOW(), NOW() + INTERVAL 1 WEEK, 1, 2, 3);

INSERT INTO ComentariosCaso (comentario, id_Abogado, id_Caso) VALUES ("Falta entrevistar a la señora Pérez.", 1, 1);

INSERT INTO ComentariosCaso (comentario, id_Abogado, id_Caso) VALUES ("Recoger documentos a la brevedad.", 2, 2);

INSERT INTO ComentariosCaso (comentario, id_Abogado, id_Caso) VALUES ("Investigar con la PGR.", 1, 3);

INSERT INTO ComentariosCaso (comentario, id_Abogado, id_Caso) VALUES ("El señor Juan Martínez no ha pagado.", 2, 4);

INSERT INTO ComentariosTarea (comentario, id_Abogado, id_Tarea) VALUES ("Yo me encargo.", 1, 1);

INSERT INTO ComentariosTarea (comentario, id_Abogado, id_Tarea) VALUES ("Entendido.", 2, 2);

INSERT INTO Expedientes (id_Caso, nombre) VALUES (1, "Pruebas");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (1, "Fotografías");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (1, "Declaraciones");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (2, "Evidencias");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (2, "Fotografías");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (3, "Declaraciones");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (3, "Escrituras");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (4, "Herencia");

INSERT INTO Expedientes (id_Caso, nombre) VALUES (4, "Bienes");

INSERT INTO Abogados_Casos(id_Abogado, id_Caso) VALUES (1, 1);

INSERT INTO Abogados_Casos(id_Abogado, id_Caso) VALUES (1, 2);

INSERT INTO Abogados_Casos(id_Abogado, id_Caso) VALUES (2, 3);

INSERT INTO Abogados_Casos(id_Abogado, id_Caso) VALUES (2, 4);

INSERT INTO Abogados_Clientes(id_Abogado, id_Cliente) VALUES (1, 1);

INSERT INTO Abogados_Clientes(id_Abogado, id_Cliente) VALUES (2, 2);