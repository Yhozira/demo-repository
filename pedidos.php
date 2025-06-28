<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['tipo'] !== 'cliente') {
    header('Location: vistas/login.php');
    exit;
}

require_once __DIR__ . '/controladores/UsuarioController.php';
require_once __DIR__ . '/controladores/PedidosController.php';

$uc = new UsuarioController();
$pc = new PedidosController();

$user_id = $uc->getId($_SESSION['correo']);
$title   = $_POST['title'] ?? '';
$price   = floatval($_POST['price'] ?? 0);

if ($title && $price > 0) {
    $pc->crearPedido($user_id, $price);
    // podrías guardar detalle adicional en otra tabla, pero aquí solo total
}

header('Location: orders.php');
exit;
