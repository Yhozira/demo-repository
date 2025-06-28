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
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #cce7f7, #e6f5ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .login-container {
            background-color: #ffffff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            color: #0077b6;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 10px;
            font-weight: 500;
            color: #333;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #a0d8ef;
            border-radius: 6px;
            margin-top: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button {
            background-color: #00b4d8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0096c7;
        }

        a {
            color: #0077b6;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Iniciar sesión</h1>

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif ?>

        <form method="post" action="login.php">
            <label>
                Correo:<br>
                <input type="email" name="correo" required>
            </label>

            <label>
                Contraseña:<br>
                <input type="password" name="contrasena" required>
            </label>

            <button type="submit">Iniciar sesion</button>
        </form>

        <p>¿No tienes cuenta? <a href="registroUsuario.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
