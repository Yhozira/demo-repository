<?php
session_start();
session_destroy();  // Eliminar todos los datos de la sesión
header('Location: login.php');  // Redirigir al login
exit;
?>
