<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<?php 
include_once 'funcionamiento.php'; 
?>

<h2>REGISTRARSE</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Nombre: <input type="text" name="name" value="<?php echo $nombre; ?>">
    <span class="error">* <?php echo $errorNombre;?></span>
    <br><br>
    Apellido: <input type="text" name="apellido" value="<?php echo $apellido; ?>">
    <span class="error">* <?php echo $errorApellido;?></span>
    <br><br>
    E-mail: <input type="text" name="email" value="<?php echo $email; ?>">
    <span class="error">* <?php echo $errorEmail;?></span>
    <br><br>
    Contraseña: <input type="password" name="contraseña">
    <span class="error">* <?php echo $errorContraseña;?></span>
    <br><br>
    Confirmar Contraseña: <input type="password" name="confirmar">
    <span class="error">* <?php echo $errorConfirmacion;?></span>
    <br><br>
    Dirección de envío: <input type="text" name="direccionEnvio">
    <span class="error">* <?php echo $errorDireccionEnvio;?></span>
    <br><br>
    Número de tarjeta: <input type="number" name="numTarjeta">
    <span class="error">* <?php echo $errorNumTarjeta;?></span>
    <br><br>
    Fecha de caducidad: <input type="date" name="fechaCaducidad">
    <span class="error">* <?php echo $errorFechaCaducidad;?></span>
    <br><br>
    Código de seguridad: <input type="number" name="codigoSeguridad">
    <span class="error">* <?php echo $errorCodigoSeguridad;?></span>
    <br><br>
    <input type="submit" name="enviar" value="ENVIAR">
</form>

<?php if (isset($_SESSION['user_id'])): ?>
            <form method="GET" action="info.php">
                <button type="submit">VER DATOS</button>
            </form>
<?php endif; ?>

</body>
</html>