<?php
// mostrarQR.php

// Incluir la conexión a la base de datos y las funciones necesarias
require_once __DIR__ . '../../../modelo/conexion.php';
require_once __DIR__ . '../../../modelo/articulo/obtenerAnimalPor_Id.php';

// Verificar si se proporcionó un ID en la URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID no válido');
}

$id = (int) $_GET['id'];

// Obtener los datos del animal según el ID
$animal = obtenerAnimalPor_Id($id);

if (!$animal) {
    die('Animal no encontrado.');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Animal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .imagen {
            max-width: 30%;
            height: auto;
            display: block;
            margin: 0 auto 20px;
        }

        .titulo {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #333;
        }

        .subtitulo {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #666;
        }

        .descripcion {
            font-size: 1rem;
            color: #444;
            line-height: 1.5;
        }

        .info {
            margin-top: 20px;
            font-size: 1rem;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <h1 class="titulo"><?= htmlspecialchars($animal['nombre_comun']) ?></h1>
        <h2 class="subtitulo"><?= htmlspecialchars($animal['nombre_cientifico']) ?></h2>

        <?php if (!empty($animal['ruta_imagen'])): ?>
            <img src="vista/<?= htmlspecialchars($animal['ruta_imagen']) ?>" alt="Imagen de <?= htmlspecialchars($animal['nombre_comun']) ?>" class="imagen">
        <?php endif; ?>

        <p class="descripcion"><?= htmlspecialchars($animal['descripcion']) ?></p>

        <div class="info">
            <strong>Mamífero:</strong> <?= ($animal['es_mamifero'] == 1) ? 'Sí' : 'No' ?>
        </div>
    </div>
</body>

</html>
