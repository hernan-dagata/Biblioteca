<?php
include 'template/header.php';
require_once __DIR__ . "/../controllers/LibroController.php";
require_once __DIR__ . "/../controllers/AutorController.php";

$libroController = new LibroController();
$autorController = new AutorController();

$autores = $autorController->getAllAutores();

if ($_POST) {
    if (isset($_POST['id']) && $_POST['id']) {
        $libroController->updateLibro($_POST['id'], $_POST['titulo'], $_POST['idAutor'], $_POST['anio_publicacion'], $_POST['ISBN']);
    } else {
        $libroController->createLibro($_POST['titulo'], $_POST['idAutor'], $_POST['anio_publicacion'], $_POST['ISBN']);
    }
}

if (isset($_GET['delete'])) {
    $libroController->deleteLibro($_GET['delete']);
    header("Location: gestionar_libro.php"); 
    exit();
}

$libro = null;
if (isset($_GET['edit'])) {
    $db = (new Database())->getConnection();
    $libroObj = new Libro($db);
    $libroObj->id = $_GET['edit'];
    $result = $libroObj->readOne();
    $libro = $result->fetch(PDO::FETCH_ASSOC);
}
?>

    <div class="container">
        <div class="col-12 col-sm-8 col-md-8">
            <h2><?php echo ($libro ? "Editar" : "Registrar"); ?> libro</h2>
            <form action="gestionar_libro.php" method="post">
                <?php if ($libro): ?>
                    <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">
                <?php endif; ?>
                <table>
                    <tr>
                        <td>Título:</td>
                        <td><input type="text" name="titulo" value="<?php echo $libro['titulo'] ?? ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td>Autor:</td>
                        <td>
                            <select name="idAutor" required>
                                <option value="" selected>-</option>
                                <?php foreach ($autores as $autor): ?>
                                    <option value="<?php echo $autor['id']; ?>" <?php echo ($libro && $libro['idAutor'] == $autor['id']) ? "selected" : ""; ?>>
                                        <?php echo $autor['nombre']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Año de Publicación:</td>
                        <td><input type="number" name="anio_publicacion" value="<?php echo $libro['anio_publicacion'] ?? ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td>ISBN:</td>
                        <td><input type="text" name="ISBN" value="<?php echo $libro['ISBN'] ?? ''; ?>" required></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" class="btn btn-success" value="<?php echo ($libro ? "Actualizar" : "Registrar"); ?>"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <hr>

    <div class="container">
        <div class="col-12">
            <h2>Lista de libros</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Año de Publicación</th>
                        <th>ISBN</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $dbInstance = new Database();
                    $db = $dbInstance->getConnection();
                    
                    $result = $libroController->getAllLibros();
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)): 
                        
                        // Aquí es donde recuperas la información del autor para cada libro
                        $autorObj = new Autor($db);
                        $autorObj->id = $row['idAutor'];
                        $autorResult = $autorObj->readOne();
                        $autorData = $autorResult->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['titulo']; ?></td>
                            <td><?php echo $autorData['nombre']; ?></td>
                            <td><?php echo $row['anio_publicacion']; ?></td>
                            <td><?php echo $row['ISBN']; ?></td>
                            <td>
                                <a href="gestionar_libro.php?edit=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                                <a href="gestionar_libro.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('¿Estás seguro que desea eliminar el registro?');" class="btn btn-danger">Eliminar</a>
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