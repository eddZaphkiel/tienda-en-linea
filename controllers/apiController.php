<?php

namespace Controllers;

use Model\Atributo;
use Model\Imagen;
use Model\Imagen_producto;
use Model\Producto;
use Model\Producto_atributo;
use Model\Valor_atributo;

class apiController {
    public static function producto(){
        header('Content-Type: application/json');

        if(!isset($_GET['id'])){
            echo "false";
        }

        $id = $_GET['id'];

        $producto = Producto::find($id);

        if (!$producto) {
            http_response_code(404); // Establecer el código de respuesta HTTP a 404 Not Found
            echo json_encode(['error' => 'Producto no encontrado']);
            exit; // Detener la ejecución del script
        }

        $producto_codified = [];
        
        $producto_array = $producto->toArray(); 
    
        // Obtener las imágenes del producto (esto ya lo tienes implementado)
        $imagenes = Imagen_producto::where('ID_producto', $producto_array['ID']);
        $rutas_imagenes = [];
        foreach($imagenes as $imagen){
            $imagen_encontrada = Imagen::where('ID',$imagen['ID_imagen']);
            if ($imagen_encontrada) {
                $rutas_imagenes[] = $imagen_encontrada['ruta']; 
            }
        }
    
        // Obtener los atributos y valores de atributo del producto
        $producto_atributos = Producto_atributo::where('ID_producto', $producto_array['ID']);
        $atributos = [];
        foreach ($producto_atributos as $producto_atributo) {
            $valor_atributo = Valor_atributo::find($producto_atributo['ID_valor_atributo']);
            $atributo = Atributo::find($valor_atributo['ID_atributo']);
    
            $atributos[] = [
                'nombre' => $atributo['nombre'],
                'valor' => $valor_atributo['valor']
            ];
        }
    
        $dato = [
            'producto' => $producto_array, 
            'imagenes' => $rutas_imagenes,
            'atributos' => $atributos
        ];
        $producto_codified[] = $dato; 
        echo json_encode($producto_codified); 
    }

    public static function productos(){
        header('Content-Type: application/json');

        $productos = Producto::get(15);

        // Once we have all the records from the table producto, we should get one image from the object

        $productos_codificados = [];

        foreach($productos as $producto){
            $producto_array = $producto->toArray();

            $imagenes = Imagen_producto::where('ID',$producto_array['ID']);
        }
    }
}