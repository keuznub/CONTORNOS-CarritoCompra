DROP DATABASE IF EXISTS breixocomponentes;
CREATE DATABASE IF NOT EXISTS BreixoComponentes;
USE BreixoComponentes;
CREATE TABLE IF NOT EXISTS Productos(
id INT auto_increment primary KEY,
nombre VARCHAR(30),
descripcion VARCHAR(50),
precio DOUBLE,
categoria ENUM("procesador","placa Base"),
imagen LONGBLOB
);
CREATE TABLE IF NOT EXISTS usuarios(
id INT auto_increment primary key,
usuario VARCHAR(20),
contraseña VARCHAR(20),
categoria ENUM("admin","cliente")
);
CREATE TABLE IF NOT EXISTS carrito(
productID INT ,
userID INT,
cantidad INT,
foreign key (productID) REFERENCES productos(id),
foreign key (userID) REFERENCES usuarios(id),
PRIMARY KEY(productID, userID)
);
INSERT INTO usuarios(usuario, contraseña, categoria)
VALUES("antonio", "antonio", "admin");

INSERT INTO usuarios(usuario, contraseña, categoria)
VALUES("pepe", "pepe", "admin");

INSERT INTO usuarios(usuario, contraseña, categoria)
VALUES("breixo", "breixo", "cliente");