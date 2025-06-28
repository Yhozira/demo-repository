<?php
require_once __DIR__ . '/../config/Conexion.php';

class ApiController {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->iniciar();
    }

    public function importarLibros() {
        $url = "https://openlibrary.org/subjects/fiction.json?limit=4000";
        $data = file_get_contents($url);
        $arr  = json_decode($data, true);

        foreach ($arr['works'] as $libro) {
            $nombre      = $libro['title'];
            $descripcion = $libro['description'] ?? 'No disponible';
            $autor       = implode(", ", $libro['authors']);
            $precio      = 20.00;
            $stock       = 100;
            $img         = $libro['cover']['large'] ?? '';

            $sql = "INSERT INTO productos (nombre, descripcion, autor, precio, stock, imagen_url)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$nombre, $descripcion, $autor, $precio, $stock, $img]);
        }
    }
}

// si llamas directo desde api.php:
$api = new ApiController();
$api->importarLibros();
echo "Importación completa.";
