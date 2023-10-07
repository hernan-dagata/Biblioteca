<?php
require_once __DIR__ . "/../controllers/AutorController.php";
$autorController = new AutorController();

if ($_POST) {
    if (isset($_POST['id']) && $_POST['id']) {
        $autorController->updateAutor($_POST['id'], $_POST['nombre'], $_POST['fechaNacimiento']);
    } else {
        $autorController->createAutor($_POST['nombre'], $_POST['fechaNacimiento']);
    }
}

if (isset($_GET['delete'])) {
    $autorController->deleteAutor($_GET['delete']);
    header("Location: gestionar_autor.php"); 
    exit();
}

$autor = null;
if (isset($_GET['edit'])) {
    $db = (new Database())->getConnection();
    $autorObj = new Autor($db);
    $autorObj->id = $_GET['edit'];
    $result = $autorObj->readOne();
    $autor = $result->fetch(PDO::FETCH_ASSOC);
}

include 'template/header.php';
?>

    <div class="container">
        <div class="col-12 col-sm-8 col-md-8">
            <h2> <?php echo ($autor ? "Editar" : "Registrar"); ?> autor </h2>
            <form action="gestionar_autor.php" method="post">
                <?php if ($autor): ?>
                    <input type="hidden" name="id" value="<?php echo $autor['id']; ?>">
                <?php endif; ?>
                <table>
                    <tr>
                        <td> Nombre: </td>
                        <td><input type="text" name="nombre" value="<?php echo $autor['nombre'] ?? ''; ?>" required></td>
                    </tr>
                    <br>
                    <tr>
                        <td>Fecha de nacimiento:</td>
                        <td><input type="date" name="fechaNacimiento" value="<?php echo $autor['fechaNacimiento'] ?? ''; ?>" required></td>
                    </tr>
                    <br>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="btn btn-success" value="<?php echo ($autor ? "Actualizar" : "Registrar"); ?>"> </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>

    <div class="container">
        <div class="col-12">
            <h2>Lista de autores</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha de nacimiento</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $result = $autorController->getAllAutores();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['fechaNacimiento']; ?></td>
                            <td>
                                <a href="gestionar_autor.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                                <a href="gestionar_autor.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro que desea eliminar el registro?');" class="btn btn-danger">Eliminar</a>
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