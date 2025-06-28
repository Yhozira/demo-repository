<?php
require_once __DIR__ . '/../config/Conexion.php';

class UsuarioController {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->iniciar();
    }

    public function registrar($nombre, $correo, $contrasena, $tipo) {
        $hashed = password_hash($contrasena, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, tipo, fecha_registro)
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nombre, $correo, $hashed, $tipo]);
    }

    public function login($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$correo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user && password_verify($contrasena, $user['contrasena']);
    }

    public function getTipo($correo) {
        $sql = "SELECT tipo FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetchColumn();
    }

    public function getId($correo) {
        $sql = "SELECT id FROM usuarios WHERE correo = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$correo]);
        return $stmt->fetchColumn();
    }
}
