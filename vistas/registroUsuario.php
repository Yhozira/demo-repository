<?php
session_start();

// cargamos el controlador (que a su vez levanta la conexión)
require_once __DIR__ . '/../controladores/UsuarioController.php';

$usuarioController = new UsuarioController();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = trim($_POST['nombre']);
    $correo     = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $tipo       = 'cliente';  // Solo registro de clientes
    
    // registrar y redirigir
    try {
        $usuarioController->registrar($nombre, $correo, $contrasena, $tipo);
        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        $error = 'Hubo un problema al registrar: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Librería</title>
</head>
<body>
    <h1>Regístrate como Cliente</h1>
    
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif ?>

    <form method="post" action="registroUsuario.php">
        <label>
            Nombre:<br>
            <input type="text" name="nombre" required>
        </label><br><br>

        <label>
            Correo:<br>
            <input type="email" name="correo" required>
        </label><br><br>

        <label>
            Contraseña:<br>
            <input type="password" name="contrasena" required>
        </label><br><br>

        <button type="submit">Registrarme</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
</body>
</html>
