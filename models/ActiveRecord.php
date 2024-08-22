<?php
namespace Model;
class ActiveRecord {
    protected $id;

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE ID = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $valor); // Suponiendo que $valor es una cadena
        $stmt->execute();
        $resultado = $stmt->get_result();
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        $stmt->close();
        return $array; 
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos (aunque ya no es estrictamente necesario con consultas preparadas, es una buena práctica mantenerlo)
        $atributos = $this->sanitizarAtributos();
    
        // Preparar la consulta
        $columnas = implode(', ', array_keys($atributos));
        $placeholders = implode(', ', array_fill(0, count($atributos), '?')); 
        $query = "INSERT INTO " . static::$tabla . " ( $columnas ) VALUES ( $placeholders )";
        $stmt = self::$db->prepare($query);
    
        // Vincular los parámetros
        $tipos = str_repeat('s', count($atributos)); // Suponiendo que todos los atributos son cadenas
        $valores = array_values($atributos);
        $stmt->bind_param($tipos, ...$valores); 
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Cerrar la consulta preparada
        $stmt->close();
    
        return [
            'resultado' =>  $resultado,
            'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
    
        // Preparar la consulta
        $setClause = [];
        foreach($atributos as $key => $value) {
            $setClause[] = "{$key} = ?";
        }
        $setClause = implode(', ', $setClause);
        $query = "UPDATE " . static::$tabla . " SET $setClause WHERE id = ?";
        $stmt = self::$db->prepare($query);
    
        // Vincular los parámetros
        $tipos = str_repeat('s', count($atributos)) . 'i'; // Suponiendo que todos los atributos son cadenas y el ID es un entero
        $valores = array_values($atributos);
        $valores[] = $this->id;
        $stmt->bind_param($tipos, ...$valores);
    
        // Ejecutar la consulta
        $resultado = $stmt->execute();
    
        // Cerrar la consulta preparada
        $stmt->close();
    
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function toArray() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public static function getWhere($columna, $valor, $limite) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = ? LIMIT {$limite}";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('s', $valor); // Suponiendo que $valor es una cadena
        $stmt->execute();
        $resultado = $stmt->get_result();
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }
        $stmt->close();
        return $array; 
    }
}