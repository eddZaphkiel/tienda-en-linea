-- Creación de la base de datos (si aún no existe)
CREATE DATABASE IF NOT EXISTS tienda_virtual;

-- Selección de la base de datos
USE tienda_virtual;

-- Tabla producto
CREATE TABLE producto (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    precioDescuento DECIMAL(10, 2),
    cantidad INT NOT NULL
);

-- Tabla imagen
CREATE TABLE imagen (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    rutaImagen VARCHAR(255) NOT NULL
);

-- Tabla imagen_producto (relación muchos a muchos entre producto e imagen)
CREATE TABLE imagen_producto (
    ID_producto INT,
    ID_imagen INT,
    PRIMARY KEY (ID_producto, ID_imagen),
    FOREIGN KEY (ID_producto) REFERENCES producto(ID),
    FOREIGN KEY (ID_imagen) REFERENCES imagen(ID)
);

-- Tabla atributo
CREATE TABLE atributo (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL
);

-- Tabla valor_atributo
CREATE TABLE valor_atributo (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_atributo INT,
    valor VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_atributo) REFERENCES atributo(ID)
);

-- Tabla producto_atributo (relación muchos a muchos entre producto y valor_atributo)
CREATE TABLE producto_atributo (
    ID_valor_atributo INT,
    ID_producto INT,
    PRIMARY KEY (ID_valor_atributo, ID_producto),
    FOREIGN KEY (ID_valor_atributo) REFERENCES valor_atributo(ID),
    FOREIGN KEY (ID_producto) REFERENCES producto(ID)
);