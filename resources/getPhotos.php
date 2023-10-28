<?php

// Leer el contenido del archivo JSON
$jsonData = file_get_contents('resources/questionsWithPhotos.json');

// Decodificar el JSON en un arreglo asociativo
$preguntasConFotos = json_decode($jsonData, true);

function mostrarFotoParaPregunta($pregunta, $preguntasConFotos) {
    if (array_key_exists($pregunta, $preguntasConFotos)) {
        $rutaFoto = $preguntasConFotos[$pregunta];
        buscarFotoPorRuta($rutaFoto);
    }
}

function buscarFotoPorRuta($rutaArchivo) {
    // Comprobar si el archivo especificado existe
    if (file_exists($rutaArchivo)) {
        // Comprobar si el archivo es una imagen (puedes agregar más extensiones si es necesario)
        $extensionesValidas = array("jpg", "jpeg", "png", "gif");
        $extension = pathinfo($rutaArchivo, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), $extensionesValidas)) {
            // Mostrar la imagen
            echo '<img src="' . $rutaArchivo . '" alt="' . basename($rutaArchivo) . '"><br>';
        } else {
            echo "El archivo no es una imagen válida.";
        }
    } else {
        echo "El archivo especificado no existe.";
    }
}
