<?php
// URL de la API de Open Library para obtener libros (ejemplo de libros de ficción)
$url = "https://openlibrary.org/subjects/fiction.json?limit=4000";  // Limitar a 4,000 libros
$libros_json = file_get_contents($url);

// Decodificar los datos JSON a un array de PHP
$libros_array = json_decode($libros_json, true);

// Incluir archivo de conexión a la base de datos
require_once 'config/Conexion.php';

foreach ($libros_array['works'] as $libro) {
    $nombre = $libro['title'];
    $descripcion = isset($libro['description']) ? $libro['description'] : 'Descripción no disponible';
    $autor = implode(", ", $libro['authors']);
    $precio = 20.00;  // Precio predeterminado, ajusta según sea necesario
    $stock = 100;  // Stock predeterminado
    $imagen_url = isset($libro['cover']['large']) ? $libro['cover']['large'] : '';  // Imagen del libro, si está disponible

    // Insertar los datos del libro en la base de datos
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, autor, precio, stock, imagen_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $autor, $precio, $stock, $imagen_url]);

    echo "Libro {$nombre} insertado con éxito.<br>";
}
?>
