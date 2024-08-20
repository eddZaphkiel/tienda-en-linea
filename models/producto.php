<?php

namespace Model;

class Producto extends ActiveRecord
{
    protected static $tabla = 'producto';
    protected static $columnasDB = ['ID', 'nombre', 'descripcion', 'precio', 'precioDescuento', 'cantidad'];

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $precioDescuento;
    public $cantidad;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->precioDescuento = $args['precioDescuento'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
    }
}