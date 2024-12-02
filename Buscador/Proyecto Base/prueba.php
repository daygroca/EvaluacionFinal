<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
$data = file_get_contents('data-1.json');
if ($data === false) {
    die('Error: No se pudo leer el archivo JSON.');
}

$json = json_decode($data, true);
if ($json === null) {
    die('Error: El archivo JSON tiene un formato incorrecto.');
}

echo '<pre>';
print_r($json);
echo '</pre>';
?>
