<?php

header('Content-Type: application/json');

$conexion = new mysqli("localhost", "root", "", "bd_map_UAZ");

$sql = "SELECT 
            ID_EDIFICIO,
            NOMBRE,
            URL_PAG_WEB,
            HORARIO,
            ID_ENCARGADO,
            CONTACTO,
            TELEFONO,
            ST_AsGeoJSON(AREA) AS geometry
        FROM Edificio";
$resultado = $conexion->query($sql);

$features = array();

while ($fila = $resultado->fetch_assoc()) {
    $features[] = array(
        "type" => "Feature",
        "geometry" => json_decode($fila['geometry'], true),
        "properties" => array(
            "ID_EDIFICIO" => $fila['ID_EDIFICIO'],
            "NOMBRE" => $fila['NOMBRE'],
            "URL_PAG_WEB" => $fila['URL_PAG_WEB'],
            "HORARIO" => $fila['HORARIO'],
            "ID_ENCARGADO" => $fila['ID_ENCARGADO'],
            "CONTACTO" => $fila['CONTACTO'],
            "TELEFONO" => $fila['TELEFONO']
        )
    );
}

echo json_encode([
    "type" => "FeatureCollection",
    "features" => $features
]);

$conexion->close();

