<?php

namespace Model;


class Imagen_producto extends ActiveRecord{
    protected static $tabla = 'imagen_producto';
    protected static $columnasDB = ['ID_producto', 'ID_imagen'];

    public $ID_producto;
    public $ID_imagen;

    public function __construct($args = [])
    {
        $this->ID_producto = $args['ID_producto'] ?? null;
        $this->ID_imagen = $args['ID_imagen'] ?? null;
    } 
}