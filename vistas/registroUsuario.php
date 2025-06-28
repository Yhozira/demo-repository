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

        .registro-container {
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

        input[type="text"],
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
    <div class="registro-container">
        <h1>Regístrate como Cliente</h1>
        
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif ?>

        <form method="post" action="registroUsuario.php">
            <label>
                Nombre:<br>
                <input type="text" name="nombre" required>
            </label>

            <label>
                Correo:<br>
                <input type="email" name="correo" required>
            </label>

            <label>
                Contraseña:<br>
                <input type="password" name="contrasena" required>
            </label>

            <button type="submit">Registrarme</button>
        </form>

        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
