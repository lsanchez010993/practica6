<?php
require_once __DIR__ . '../../conexion.php';
function obtenerAnimalesNoPublicados()
{
 
    $pdo = connectarBD();

    // Consulta para obtener los animales donde 'publicado' es false
    $sql = "SELECT * FROM animales WHERE publicado = 0";
    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function publicarAnimal($id) 
{
    $pdo = connectarBD();


    $sql = "UPDATE animales SET publicado = true WHERE id = :id";
    $stmt = $pdo->prepare($sql);

   
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

   
    $stmt->execute();


    return $stmt->rowCount();
}





