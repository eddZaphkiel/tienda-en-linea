<?php

namespace Model;

class Producto extends ActiveRecord
{
    protected static $tabla = 'producto';
    protected static $columnasDB = ['ID', 'nombre', 'descripcion', 'precio', 'precioDescuento', 'cantidad'];

    public $nombre;
    public $descripcion;
    public $precio;
    public $precioDescuento;
    public $cantidad;

    public function __construct($args = [])
    {
        $this->ID = $args['ID'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->precioDescuento = $args['precioDescuento'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
    }

    protected static function tiposAtributos(){
        return [
            'id' => 'i',
            'nombre' => 's',
            'descripcion' => 's',
            'precio' => 'd',
            'precioDescuento' => 'd',
            'cantidad' => 'i'
        ];
    }

    public static function getAllProducts(){
        $productos = Producto::all();
        
        $data = [];
        foreach($productos as $producto){
            debug($producto);
        }
    }

    public static function getProduct($id){
        $id = self::sanitizar($id);
        $query = 'CALL obtenerProductoCompleto(?)';
        $params = [
            ['type' => 'i', 'value' => $id]
        ];
        return self::executeSQL($query, $params);
    }
}