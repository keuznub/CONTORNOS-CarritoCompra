/*SCRIPTS MySQL BASE DE DATOS LOCAL CON XAMPP*/

CREATE DATABASE IF NOT EXISTS BreixoComponentes;
USE BreixoComponentes;
CREATE TABLE IF NOT EXISTS Productos(
id INT auto_increment primary KEY,
nombre VARCHAR(30),
descripcion VARCHAR(50),
precio DOUBLE,
categoria ENUM("procesador","placaBase"),
imagen LONGBLOB
);

SELECT * FROM Productos;

INSERT INTO Productos(nombre, descripcion, precio, categoria)
VALUES("prueba1", "descripcionTest", "20.5", "procesador2");

DELETE FROM Productos;


USE breixocomponentes;
CREATE TABLE IF NOT EXISTS usuarios(
usuario VARCHAR(20),
contraseña VARCHAR(20),
categoria ENUM("admin","ciente")
);