<?php

namespace Model;

/**
 * -- Tabla producto_atributo (relación muchos a muchos entre producto y valor_atributo)
CREATE TABLE producto_atributo (
    ID_valor_atributo INT,
    ID_producto INT,
    PRIMARY KEY (ID_valor_atributo, ID_producto),
    FOREIGN KEY (ID_valor_atributo) REFERENCES valor_atributo(ID),
    FOREIGN KEY (ID_producto) REFERENCES producto(ID),
    INDEX idx_id_valor_atributo (ID_valor_atributo), -- Índice en la columna 'ID_valor_atributo' para búsquedas por valor de atributo
    INDEX idx_id_producto_atributo (ID_producto)     -- Índice en la columna 'ID_producto' para búsquedas por producto
);
 */

class Producto_atributo extends ActiveRecord
{
    protected static $tabla = 'producto_atributo';
    protected static $columnasDB = ['ID_valor_atributo', 'ID_producto'];

    public $ID_valor_atributo;
    public $ID_producto;

    protected static function tiposAtributos()
    {
        return [
            'ID_valor_atributo' => 'i',
            'ID_producto' => 'i'
        ];
    }

    public function __construct($args = [])
    {
        $this->ID_valor_atributo = $args['ID_valor_atributo'] ?? null;
        $this->ID_producto = $args['ID_producto'] ?? null;
    }
}