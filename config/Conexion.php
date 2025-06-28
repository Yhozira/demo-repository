<?php
class Conexion {
    private $dsn;
    private $username;
    private $password;

    public function __construct() {
        // Ajusta aquí tu nombre de base de datos
        $this->dsn      = "mysql:host=localhost;dbname=libreria;charset=utf8";
        $this->username = "root";
        $this->password = "";
    }

    public function iniciar() {
        $conn = new PDO(
            $this->dsn,
            $this->username,
            $this->password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        return $conn;
    }

    public function terminar() {
        return null;
    }
}
