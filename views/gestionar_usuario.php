<?php
require_once __DIR__ . "/../controllers/UsuarioController.php";
$usuarioController = new UsuarioController();

if ($_POST) {
    if (isset($_POST['id']) && $_POST['id']) {
        $usuarioController->updateUsuario($_POST['id'], $_POST['nombre'], $_POST['direccion'], $_POST['telefono']);
    } else {
        $usuarioController->createUsuario($_POST['nombre'], $_POST['direccion'], $_POST['telefono']);
    }
}

if (isset($_GET['delete'])) {
    $usuarioController->deleteUsuario($_GET['delete']);
    header("Location: gestionar_usuario.php"); 
    exit();
}

$usuario = null;
if (isset($_GET['edit'])) {
    $db = (new Database())->getConnection();
    $usuarioObj = new Usuario($db);
    $usuarioObj->id = $_GET['edit'];
    $result = $usuarioObj->readOne();
    $usuario = $result->fetch(PDO::FETCH_ASSOC);
}

include 'template/header.php';
?>

    <div class="container">
        <div class="col-12 col-sm-8 col-md-8">
            <h2> <?php echo ($usuario ? "Editar" : "Registrar"); ?> usuario </h2>
            <form action="gestionar_usuario.php" method="post">
                <?php if ($usuario): ?>
                    <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                <?php endif; ?>
                <table>
                    <tr>
                        <td> Nombre: </td>
                        <td><input type="text" name="nombre" value="<?php echo $usuario['nombre'] ?? ''; ?>" required></td>
                    </tr>
                    <br>
                    <tr>
                        <td>Dirección:</td>
                        <td><input type="text" name="direccion" value="<?php echo $usuario['direccion'] ?? ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Teléfono:</td>
                        <td><input type="text" name="telefono" value="<?php echo $usuario['telefono'] ?? ''; ?>" required></td>
                    </tr>
                    <br>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="btn btn-success" value="<?php echo ($usuario ? "Actualizar" : "Registrar"); ?>"> </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>

    <div class="container">
        <div class="col-12">
            <h2>Lista de usuarios</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = $usuarioController->getAllUsuarios();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['direccion']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td>
                                <a href="gestionar_usuario.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                                <a href="gestionar_usuario.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro que desea eliminar el registro?');" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    </br>
<?php
include 'template/footer.php';
?>
