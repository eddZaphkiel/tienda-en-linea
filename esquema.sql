-- Creación de la base de datos (si aún no existe)
DROP DATABASE IF EXISTS tienda_virtual;
CREATE DATABASE IF NOT EXISTS tienda_virtual;

-- Selección de la base de datos
USE tienda_virtual;

-- Creación de la base de datos (si aún no existe)
CREATE DATABASE IF NOT EXISTS tienda_virtual;

-- Selección de la base de datos
USE tienda_virtual;

CREATE TABLE administrador(
	Usuario VARCHAR(20),
    pass VARCHAR(32)
);

-- Tabla producto
CREATE TABLE producto (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL,
    precioDescuento DECIMAL(10, 2),
    cantidad INT NOT NULL,
    INDEX idx_nombre (nombre) -- Índice en la columna 'nombre' para búsquedas por nombre de producto
);

-- Tabla imagen
CREATE TABLE imagen (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    rutaImagen VARCHAR(255) NOT NULL
);

-- Tabla imagen_producto (relación muchos a muchos entre producto e imagen)
CREATE TABLE imagen_producto (
	ID INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    ID_producto INT,
    ID_imagen INT,
    FOREIGN KEY (ID_producto) REFERENCES producto(ID),
    FOREIGN KEY (ID_imagen) REFERENCES imagen(ID),
    INDEX idx_id_producto (ID_producto), -- Índice en la columna 'ID_producto' para búsquedas por producto
    INDEX idx_id_imagen (ID_imagen)     -- Índice en la columna 'ID_imagen' para búsquedas por imagen
);

-- Tabla atributo
CREATE TABLE atributo (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    INDEX idx_nombre_atributo (nombre) -- Índice en la columna 'nombre' para búsquedas por nombre de atributo
);

-- Tabla valor_atributo
CREATE TABLE valor_atributo (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_atributo INT,
    valor VARCHAR(255) NOT NULL,
    FOREIGN KEY (ID_atributo) REFERENCES atributo(ID),
    INDEX idx_id_atributo (ID_atributo), -- Índice en la columna 'ID_atributo' para búsquedas por atributo
    INDEX idx_valor (valor)             -- Índice en la columna 'valor' para búsquedas por valor de atributo
);

-- Tabla producto_atributo (relación muchos a muchos entre producto y valor_atributo)
CREATE TABLE producto_atributo (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    ID_valor_atributo INT,
    ID_producto INT,
    FOREIGN KEY (ID_valor_atributo) REFERENCES valor_atributo(ID),
    FOREIGN KEY (ID_producto) REFERENCES producto(ID),
    INDEX idx_id_valor_atributo (ID_valor_atributo), -- Índice en la columna 'ID_valor_atributo' para búsquedas por valor de atributo
    INDEX idx_id_producto_atributo (ID_producto)     -- Índice en la columna 'ID_producto' para búsquedas por producto
);

DELIMITER //

CREATE PROCEDURE obtenerProductoCompleto(IN productoId INT)
BEGIN
    -- Obtener la información básica del producto
    SELECT 
        p.ID, 
        p.nombre, 
        p.descripcion, 
        p.precio, 
        p.precioDescuento, 
        p.cantidad
    FROM producto p
    WHERE p.ID = productoId;

    -- Obtener las rutas de las imágenes del producto
    SELECT 
        i.rutaImagen
    FROM imagen i
    JOIN imagen_producto ip ON i.ID = ip.ID_imagen
    WHERE ip.ID_producto = productoId;

    -- Obtener los atributos y sus valores del producto
    SELECT 
        a.nombre AS nombre_atributo, 
        va.valor AS valor_atributo
    FROM atributo a
    JOIN valor_atributo va ON a.ID = va.ID_atributo
    JOIN producto_atributo pa ON va.ID = pa.ID_valor_atributo
    WHERE pa.ID_producto = productoId;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE obtenerProductosBasicos()
BEGIN
    SELECT 
        p.ID, 
        p.nombre, 
        p.precio, 
        p.precioDescuento,
        (
            SELECT i.rutaImagen 
            FROM imagen i
            JOIN imagen_producto ip ON i.ID = ip.ID_imagen
            WHERE ip.ID_producto = p.ID
            ORDER BY ip.ID ASC -- Ordenar por ID de imagen_producto para obtener la primera
            LIMIT 1
        ) AS imagen
    FROM producto p;
END //

DELIMITER ;

INSERT INTO producto (nombre, descripcion, precio, precioDescuento, cantidad)
VALUES 
    ('Smartphone Galaxy S23', 'Potente smartphone con cámara de alta resolución', 1299.99, 1149.99, 120),
    ('Laptop Gamer ASUS ROG', 'Laptop de alto rendimiento para juegos', 1999.00, NULL, 25),
    ('Cámara Canon EOS R5', 'Cámara mirrorless profesional', 3899.00, NULL, 10),
    ('Auriculares inalámbricos Sony WH-1000XM4', 'Cancelación de ruido líder en la industria', 349.99, 299.99, 80),
    ('Smart TV LG OLED 4K', 'Increíble calidad de imagen y sonido', 1599.00, NULL, 30);
    
CALL obtenerProductoCompleto('1');
CALL obtenerProductosBasicos();

CALL obtenerProductoCompleto(1);