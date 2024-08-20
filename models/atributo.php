<?php

namespace Model;

/*
-- Tabla atributo
CREATE TABLE atributo (
    ID INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    INDEX idx_nombre_atributo (nombre) -- Índice en la columna 'nombre' para búsquedas por nombre de atributo
);
*/

class Atributo extends ActiveRecord
{
    protected static $tabla = 'atributo';
    protected static $columnasDB = ['ID', 'nombre'];

    public $ID;
    public $nombre;

    public function __construct($args = [])
    {
        $this->ID = $args['ID'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }
}