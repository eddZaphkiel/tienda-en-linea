<?php

namespace Model;

class Valor_atributo extends ActiveRecord
{
    protected static $tabla = 'valor_atributo';
    protected static $columnasDB = ['ID', 'ID_atributo', 'valor'];
    
    public $ID_atributo;
    public $valor;

    protected static function tiposAtributos()
    {
        return [
            'ID' => 'i',
            'ID_atributo' => 'i',
            'valor' => 's'
        ];
    }

    public function __construct($args = [])
    {
        $this->ID = $args['ID'] ?? null;
        $this->ID_atributo = $args['ID_atributo'] ?? null;
        $this->valor = $args['valor'] ?? '';
    }
}