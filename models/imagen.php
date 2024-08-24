<?php

namespace Model;

class Imagen extends ActiveRecord
{
    protected static $tabla = 'imagen';
    protected static $columnasDB = ['ID', 'rutaImagen'];

    public $id;
    public $rutaImagen;

    protected static function tiposAtributos()
    {
        return [
            'ID' => 'i',
            'rutaImagen' => 's'
        ];
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->rutaImagen = $args['rutaImagen'] ?? '';
    }
}