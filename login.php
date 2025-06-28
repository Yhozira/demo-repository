<?php
session_start();

// cargamos el controlador (que internamente levanta la conexión)
require_once __DIR__ . '/../controladores/UsuarioController.php';

$usuarioController = new UsuarioController();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // recogemos y saneamos
    $correo     = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];

    // intentamos login
    if ($usuarioController->login($correo, $contrasena)) {
        // login ok: guardamos sesión
        $_SESSION['correo'] = $correo;
        $_SESSION['tipo']   = $usuarioController->getTipo($correo);

        // redirigimos según rol
        if ($_SESSION['tipo'] === 'cliente') {
            header('Location: ../cliente.php');
        } else {
            header('Location: ../dashboard.php');
        }
        exit;
    } else {
        $error = 'Correo o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Librería</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif ?>

    <form method="post" action="login.php">
        <label>
            Correo:<br>
            <input type="email" name="correo" required>
        </label><br><br>

        <label>
            Contraseña:<br>
            <input type="password" name="contrasena" required>
        </label><br><br>

        <button type="submit">Iniciar sesión</button>
    </form>

    <p>¿No tienes cuenta? <a href="registroUsuario.php">Regístrate aquí</a></p>
</body>
</html>
