<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
// Leer los datos del archivo JSON
$data = json_decode(file_get_contents('data-1.json'), true);

// Obtener todas las ciudades y tipos únicos
$ciudades = array_unique(array_column($data, 'Ciudad'));
$tipos = array_unique(array_column($data, 'Tipo'));

// Ordenar alfabéticamente
sort($ciudades);
sort($tipos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Bienes Raíces</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <div class="contenedor">
        <h1>Buscador de Bienes Raíces</h1>
        <div class="filtros">
            <form id="formulario-busqueda" method="POST" action="buscar.php">
                <label for="ciudad">Ciudad:</label>
                <select name="ciudad" id="ciudad">
                    <option value="">Todas</option>
                    <?php foreach ($ciudades as $ciudad): ?>
                        <option value="<?= $ciudad ?>"><?= $ciudad ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="tipo">Tipo de Vivienda:</label>
                <select name="tipo" id="tipo">
                    <option value="">Todos</option>
                    <?php foreach ($tipos as $tipo): ?>
                        <option value="<?= $tipo ?>"><?= $tipo ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="rango-precio">Rango de Precio:</label>
                <input type="number" name="precio_min" placeholder="Precio mínimo" required>
                <input type="number" name="precio_max" placeholder="Precio máximo" required>

                <button type="submit">Buscar</button>
                <button type="button" id="mostrar-todos">Mostrar Todos</button>
            </form>
        </div>
        <div id="resultados"></div>
    </div>
    <script src="assets/scripts.js"></script>
</body>
</html>
