<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
// Habilitar manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Leer los datos del archivo JSON
$data = json_decode(file_get_contents('data-1.json'), true);
if (!$data) {
    die('Error al leer los datos del archivo JSON.');
}

// Obtener los parámetros de búsqueda
$ciudad = $_POST['ciudad'] ?? '';
$tipo = $_POST['tipo'] ?? '';
$precio_min = isset($_POST['precio_min']) ? (int) $_POST['precio_min'] : 0;
$precio_max = isset($_POST['precio_max']) ? (int) $_POST['precio_max'] : PHP_INT_MAX;

// Filtrar los resultados
$resultados = array_filter($data, function ($item) use ($ciudad, $tipo, $precio_min, $precio_max) {
    $precio = (int) filter_var($item['Precio'], FILTER_SANITIZE_NUMBER_INT);
    $dentro_rango = $precio >= $precio_min && $precio <= $precio_max;
    $por_ciudad = empty($ciudad) || $item['Ciudad'] === $ciudad;
    $por_tipo = empty($tipo) || $item['Tipo'] === $tipo;
    return $dentro_rango && $por_ciudad && $por_tipo;
});

// Enviar los resultados como JSON
header('Content-Type: application/json');
echo json_encode(array_values($resultados));
?>
