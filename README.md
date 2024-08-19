Proyecto Tienda MVC
Este proyecto implementa una página de tienda sencilla utilizando el patrón de diseño Modelo-Vista-Controlador (MVC). Está desarrollado en PHP para el backend, JavaScript para la interactividad del frontend y SASS para estilos elegantes y mantenibles.

# Características Principales
  - Catálogo de Productos: Muestra los productos disponibles con imágenes, descripciones y precios.
  - Carrito de Compras: Permite a los usuarios agregar y eliminar productos, ajustar cantidades y ver el total de la compra.
  - Resumen de Venta: Genera un resumen detallado de la venta para el vendedor, incluyendo productos, cantidades y total.
  - Backend Robusto: Gestiona la lógica de la aplicación, la interacción con la base de datos y la generación del resumen de venta.
  - Frontend Interactivo: Proporciona una experiencia de usuario fluida y agradable gracias a JavaScript.
  - Estilos Modernos: Utiliza SASS para crear estilos CSS organizados y fáciles de mantener.
# Tecnologías Utilizadas
-  PHP: Lenguaje de programación principal para el backend.
-  JavaScript: Agrega interactividad al frontend.
-  SASS: Preprocesador CSS para estilos más eficientes.
-  HTML: Estructura básica de la página.
-  MySQL: Almacena información de productos, usuarios, etc.

# Instalación
1. Clona el repositorio: git clone https://github.com/eddZaphkiel/tienda-en-linea.git
2. Configura la base de datos: Crea una base de datos y importa el esquema proporcionado.
3. Ajusta la configuración: Edita el archivo database.php con los detalles de conexión a tu base de datos.
4. Inicia el servidor: Ejecuta un servidor local PHP (como XAMPP o WAMP) y accede al proyecto a través de tu navegador.

# Estructura del Proyecto
/models: Contiene las clases que representan los datos y la lógica de negocio.
/views: Almacena las plantillas HTML que se mostrarán al usuario.
/controllers: Gestiona las solicitudes del usuario, interactúa con los modelos y selecciona las vistas adecuadas.
/build/css: Contiene los estilos CSS generados a partir de SASS.
/build/js: Almacena el código JavaScript para la interactividad.

## Notas Adicionales ##
Pagos: Actualmente, el proyecto no incluye funcionalidad de pagos en línea. El pago se realiza en entrega presencial.
Escalabilidad: El diseño MVC facilita la expansión y el mantenimiento del proyecto a medida que crezca.
Contribuciones: ¡Las contribuciones son bienvenidas! Si encuentras errores o tienes ideas para mejorar el proyecto, no dudes en abrir un issue o enviar un pull request.
¡Disfruta explorando y utilizando este proyecto de tienda MVC!
