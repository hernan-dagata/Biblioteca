<?php
require_once __DIR__ . "/../controllers/PrestamoController.php";
require_once __DIR__ . "/../controllers/UsuarioController.php";
require_once __DIR__ . "/../controllers/LibroController.php";

$prestamoController = new PrestamoController();
$usuarioController = new UsuarioController();
$libroController = new LibroController();

if ($_POST) {
    if (isset($_POST['id']) && $_POST['id']) {
        $prestamoController->updatePrestamo($_POST['id'], $_POST['idUsuario'], $_POST['idLibro'], $_POST['fechaPrestamo'], $_POST['fechaDevolucion']);
    } else {
        $prestamoController->createPrestamo($_POST['idUsuario'], $_POST['idLibro'], $_POST['fechaPrestamo'], $_POST['fechaDevolucion']);
    }
}

if (isset($_GET['delete'])) {
    $prestamoController->deletePrestamo($_GET['delete']);
    header("Location: gestionar_prestamo.php");
    exit();
}

$prestamo = null;
if (isset($_GET['edit'])) {
    $db = (new Database())->getConnection();
    $prestamoObj = new Prestamo($db);
    $prestamoObj->id = $_GET['edit'];
    $result = $prestamoObj->readOne();
    $prestamo = $result->fetch(PDO::FETCH_ASSOC);
}

include 'template/header.php';
?>

    <div class="container">
        <div class="col-12 col-sm-8 col-md-8">
            <h2><?php echo ($prestamo ? "Editar" : "Registrar"); ?> préstamo </h2>
            <form action="gestionar_prestamo.php" method="post">
                <?php if ($prestamo): ?>
                    <input type="hidden" name="id" value="<?php echo $prestamo['id']; ?>">
                <?php endif; ?>
                <table>
                    <tr>
                        <td>Usuario:</td>
                        <td>
                        <select name="idUsuario" required>
                            <option value="" selected>-</option>
                            <?php foreach ($usuarioController->getAllUsuarios() as $usuario): ?>
                                <option value="<?php echo $usuario['id']; ?>" <?php if (isset($prestamo['idUsuario']) && $prestamo['idUsuario'] == $usuario['id']) echo 'selected'; ?>>
                                    <?php echo $usuario['nombre']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        </td>
                    </tr>
                    <tr>
                        <td>Libro:</td>
                        <td>
                            <select name="idLibro" required>
                                <option value="" selected>-</option>
                                <?php foreach ($libroController->getAllLibros() as $libro): ?>
                                    <option value="<?php echo $libro['id']; ?>" <?php if (isset($prestamo['idLibro']) && $prestamo['idLibro'] == $libro['id']) echo 'selected'; ?>>
                                        <?php echo $libro['titulo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de Préstamo:</td>
                        <td><input type="date" name="fechaPrestamo" value="<?php echo $prestamo['fechaPrestamo'] ?? ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Fecha de Devolución:</td>
                        <td><input type="date" name="fechaDevolucion" value="<?php echo $prestamo['fechaDevolucion'] ?? ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="btn btn-success" value="<?php echo ($prestamo ? "Actualizar" : "Registrar"); ?>"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>

    <div class="container">
        <div class="col-12">
            <h2>Lista de préstamos</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Fecha de Préstamo</th>
                        <th>Fecha de Devolución</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php                   
                    $result = $prestamoController->getAllPrestamos();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $usuarioController->getUsuarioNombreById($row['idUsuario']); ?></td>
                            <td><?php echo $libroController->getLibroTituloById($row['idLibro']); ?></td>
                            <td><?php echo $row['fechaPrestamo']; ?></td>
                            <td><?php echo $row['fechaDevolucion']; ?></td>
                            <td>
                                <a href="gestionar_prestamo.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                                <a href="gestionar_prestamo.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro que desea eliminar el registro?');" class="btn btn-danger">Eliminar</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>

<?php
include 'template/footer.php';
?>