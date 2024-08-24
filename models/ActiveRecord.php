<?php
namespace Model;

abstract class ActiveRecord {
    protected $ID;

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];
    protected static $tiposColumnasDB = []; 

    // Alertas y Mensajes
    protected static $alertas = [];

    abstract protected static function tiposAtributos();
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    
        // Obtener información de la tabla y columnas desde la base de datos (si es posible)
        if (static::$tabla) {
            $resultado = self::$db->query("DESCRIBE " . static::$tabla);
            if ($resultado) {
                while ($fila = $resultado->fetch_assoc()) {
                    static::$columnasDB[] = $fila['Field'];
                    static::$tiposColumnasDB[$fila['Field']] = static::obtenerTipoDatoDesdeMySQL($fila['Type']);
                }
                $resultado->free();
            }
        }
    }
    
    private static function obtenerTipoDatoDesdeMySQL($tipoMySQL) {
        // Mapear tipos de datos de MySQL a tipos de parámetros de bind_param

        $mapeo = [
            'int' => 'i',
            'varchar' => 's',
            'text' => 's',
            'decimal' => 'd',
        ];
    
        $tipo = strtolower(explode('(', $tipoMySQL)[0]); // Extraer el tipo base (por ejemplo, 'int' de 'int(11)')
        return isset($mapeo[$tipo]) ? $mapeo[$tipo] : 's'; // Devolver el tipo mapeado o 's' por defecto
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
    public static function executeSQL($query, $params = []){
        $stmt = self::$db->prepare($query);

        if ($stmt === false) {
            throw new \Exception("Error al preparar la consulta: " . self::$db->error);
        }

        if (!empty($params)) {
            $types = '';
            $values = [];

            foreach ($params as $param) {
                $types .= $param['type'];
                $values[] = &$param['value']; // Pasar por referencia
            }

            $stmt->bind_param($types, ...$values); 
            
        }

        $stmt->execute();

        // Manejar diferentes tipos de consultas
        if (
            strpos($query, 'SELECT') === 0 ||
            strpos($query, 'CALL') === 0
        ) { // Consulta SELECT
            $resultado = $stmt->get_result();
            $array = [];
            while ($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro); // Crear objetos si es necesario
            }
            return $array;
        } else { // Otras consultas (INSERT, UPDATE, DELETE)
            return $stmt->affected_rows; // Devuelve el número de filas afectadas
        }
    }

    // Consulta SQL sin crear objetos
    public static function consultarSQLSinObjetos($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = $registro; // Almacenar el registro directamente como array asociativo
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
            if($columna === 'ID') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar un dato antes de consultar en la BD
    public static function sanitizar($arg){
        $sanitizado = self::$db->escape_string($arg);
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
    public function save() {
        $resultado = '';
        if(!is_null($this->ID)) {
            // actualizar
            $resultado = $this->update();
        } else {
            // Creando un nuevo registro
            $resultado = $this->create();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::executeSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ID = ?";
        $params = [['type' => static::$tiposColumnasDB['ID'], 'value' => $id]]; // Obtener el tipo de dato de 'ID'
        $resultado = self::executeSQL($query, $params);
        return array_shift($resultado); 
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ?";
        $params = [['type' => 'i', 'value' => $limite]];
        $resultado = self::executeSQL($query, $params);
        return array_shift($resultado); 
    }

    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = ?";
        $params = [['type' => static::$tiposColumnasDB[$columna], 'value' => $valor]]; // Obtener el tipo de dato de la columna
        $resultado = self::executeSQL($query, $params);
        return $resultado; 
    }

    // crea un nuevo registro
    public function create() {
        $atributos = $this->atributos();
        $tipos = static::tiposAtributos();
    
        // Construir la consulta con marcadores de posición
        $columnas = implode(', ', array_keys($atributos));
        $placeholders = implode(', ', array_fill(0, count($atributos), '?'));
        $query = "INSERT INTO " . static::$tabla . " ( $columnas ) VALUES ( $placeholders )";
    
        // Preparar los parámetros para executeSQL
        $params = [];
        foreach ($atributos as $key => $value) {
            $params[] = ['type' => $tipos[$key], 'value' => $value];
        }
    
        // Ejecutar la consulta preparada
        $resultado = self::executeSQL($query, $params);
    
        return [
            'resultado' => $resultado,
            'ID' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function update() {
        $atributos = $this->atributos();
        $tipos = static::tiposAtributos();
    
        $setClause = [];
        foreach ($atributos as $key => $value) {
            $setClause[] = "{$key} = ?";
        }
        $setClause = implode(', ', $setClause);
        $query = "UPDATE " . static::$tabla . " SET $setClause WHERE ID = ?";
    
        // Preparar los parámetros para executeSQL
        $params = [];
        foreach ($atributos as $key => $value) {
            $params[] = ['type' => $tipos[$key], 'value' => $value];
        }
        $params[] = ['type' => static::$tiposColumnasDB['ID'], 'value' => $this->ID]; 
    
        return self::executeSQL($query, $params); 
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE ID = ?";
        $params = [['type' => static::$tiposColumnasDB['ID'], 'value' => $this->ID]];
        return self::executeSQL($query, $params); 
    }

    public function toArray() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public static function getWhere($columna, $valor, $limite) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = ? LIMIT ?";
        $params = [
            ['type' => static::$tiposColumnasDB[$columna], 'value' => $valor],
            ['type' => 'i', 'value' => $limite] 
        ];
        $resultado = self::executeSQL($query, $params);
        return $resultado; 
    }
}