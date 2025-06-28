<?php
require_once __DIR__ . '/../config/Conexion.php';

class PedidosController {
    private $conn;

    public function __construct() {
        $db = new Conexion();
        $this->conn = $db->iniciar();
    }

    public function crearPedido($usuario_id, $total) {
        $sql = "INSERT INTO pedidos (usuario_id, total, fecha_pedido)
                VALUES (?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$usuario_id, $total]);
    }

    public function cambiarEstado($pedido_id, $nuevo_estado) {
        $sql = "UPDATE pedidos SET estado = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$nuevo_estado, $pedido_id]);
    }
}
