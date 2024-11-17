<?php
session_start();
require_once 'connect.php';


$sql = "SELECT id, nombre, apellido, email, direccion_envio FROM LOGS";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar'])) {
    $idEliminar = $_POST['id'];
    $sqlDelete = "DELETE FROM LOGS WHERE id = $idEliminar";
    
    if ($conn->query($sqlDelete)) {
        echo "Registro eliminado con éxito.";
    } else {
        echo "Error al eliminar el registro: " . $conn->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $idActualizar = $_POST['id'];
    $nombreNuevo = $_POST['nombre'];
    $apellidoNuevo = $_POST['apellido'];
    $direccionNueva = $_POST['direccion'];

    $sqlUpdate = "UPDATE LOGS SET nombre = '$nombreNuevo', apellido = '$apellidoNuevo', direccion_envio = '$direccionNueva' WHERE id = $idActualizar";
    
    if ($conn->query($sqlUpdate)) {
        echo "Registro actualizado con éxito.";
    } else {
        echo "Error al actualizar el registro: " . $conn->error;
    }
}


?>
<html>
<body>
<h2>Usuarios Registrados</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Dirección</th>
        <th>Acciones</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['nombre']; ?></td>
            <td><?= $row['apellido']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><?= $row['direccion_envio']; ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <button type="submit" name="eliminar">Eliminar</button>
                </form>

                <form method="POST" action="info.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <input type="hidden" name="nombre" value="<?= $row['nombre']; ?>">
                    <input type="hidden" name="apellido" value="<?= $row['apellido']; ?>">
                    <input type="hidden" name="direccion" value="<?= $row['direccion_envio']; ?>">
                    <button type="submit" name="editar">Editar</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
    <tr><td colspan="6">No hay registros disponibles.</td></tr>
<?php endif; ?>

</table>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editar'])):
    ?>
    <h2>Actualizar Usuario</h2>
    <form method="POST" action="info.php">
        <input type="hidden" name="id" value="<?= $_POST['id']; ?>">
        Nombre: <input type="text" name="nombre" value="<?= $_POST['nombre']; ?>"><br>
        Apellido: <input type="text" name="apellido" value="<?= $_POST['apellido']; ?>"><br>
        Dirección: <input type="text" name="direccion" value="<?= $_POST['direccion']; ?>"><br>
        <button type="submit" name="actualizar">Actualizar</button>
    </form>
<?php endif; ?>


</body>
</html>
