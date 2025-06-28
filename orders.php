<?php
session_start();
if (!isset($_SESSION['correo']) || $_SESSION['tipo'] !== 'cliente') {
    header('Location: vistas/login.php');
    exit;
}

require_once __DIR__ . '/config/Conexion.php';
require_once __DIR__ . '/controladores/UsuarioController.php';

$db = new Conexion();
$conn = $db->iniciar();
$uc = new UsuarioController();
$user_id = $uc->getId($_SESSION['correo']);

$stmt = $conn->prepare("SELECT id, total, estado, fecha_pedido FROM pedidos WHERE usuario_id = ? ORDER BY fecha_pedido DESC");
$stmt->execute([$user_id]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Pedidos</title>
</head>
<body>
    <h1>Mis Pedidos</h1>
    <table border="1" cellpadding="5">
        <tr><th>ID</th><th>Total</th><th>Estado</th><th>Fecha</th></tr>
        <?php foreach ($pedidos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td>US$ <?= number_format($p['total'],2) ?></td>
                <td><?= htmlspecialchars($p['estado']) ?></td>
                <td><?= htmlspecialchars($p['fecha_pedido']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a href="cliente.php">Volver al catálogo</a></p>
</body>
</html>
