<?php
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

if (file_exists("archivo.txt")) {
    //si el archivo existe, cargo las tareas en la variable aTareas
    $strjson = file_get_contents("archivo.txt");
    $aTareas = json_decode($strjson, true);
} else {
    //si el archivo no existe es porque no hay tareas
    $aTareas = array();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = "";
}

if (isset($_GET["do"]) && $_GET["do"] == "eliminar") {
    unset($aTareas[$id]);

    //convertir aTareas en json
    $strjson = json_encode($aTareas);
    //almacenar en un archivo.txt el json
    file_put_contents("archivo.txt", $strjson);

    header("Location: index.php");
}

if ($_POST) {
    $titulo = $_POST["txtTitulo"];
    $prioridad = $_POST["lstPrioridad"];
    $usuario = $_POST["lstUsuario"];
    $estado = $_POST["lstEstado"];
    $descripcion = $_POST["txtDescripcion"];


    if ($id >= 0) {
    //Si se está editando hacer esto:
        $aTareas[$id] = array(
            "fecha" => $aTareas[$id]["fecha"],
            "titulo" => $titulo,
            "prioridad" => $prioridad,
            "usuario" => $usuario,
            "estado" => $estado,
            "descripcion" => $descripcion
        );
        header("Location: index.php");
    } else {
    //Si se esta insertando una nueva tarea
        $aTareas[] = array(
            "fecha" => date("d/m/Y"),
            "titulo" => $titulo,
            "prioridad" => $prioridad,
            "usuario" => $usuario,
            "estado" => $estado,
            "descripcion" => $descripcion
        );
        }   
    }

//convertir el array en json
$strjson = json_encode($aTareas);
//almacenar en un archivo.txt el json
file_put_contents("archivo.txt", $strjson);


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="css/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/fontawesome/css/fontawesome.min.css">
</head>

<body>
    <main class="container">
        <div class="row">
            <div class="col-12 py-5 text-center">
                <h1>Gestor de Tareas</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form action="" method="post">

                    <div class="py-1">
                        <label for="txtTitulo">Titulo</label>
                        <input type="text" name="txtTitulo" id="txtTitulo" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["titulo"] : ""; ?>">
                    </div>
                    <div class="py-1">
                        <label for="lstPrioridad">Prioridad</label>
                        <select name="lstPrioridad" id="lstPrioridad" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["prioridad"] : ""; ?>">
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="Alta" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["prioridad"] == "Alta"? "selected": " "; ?> >Alta</option>
                            <option value="Media" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["prioridad"] == "Media"? "selected": " "; ?> >Media</option>
                            <option value="Baja" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["prioridad"] == "Baja"? "selected": " "; ?> >Baja</option>
                        </select>
                    </div>

                    <div class="py-1">
                        <label for="lstUsuario">Usuario</label>
                        <select name="lstUsuario" id="lstUsuario" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["usuario"] : ""; ?>">
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="Jony Moran" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["usuario"] == "Jony Moran"? "selected": " "; ?> >Jony Moran</option>
                            <option value="Ale Medina" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["usuario"] == "Ale Medina"? "selected": " "; ?> >Ale Medina</option>
                            <option value="Naty Figuera" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["usuario"] == "Naty Figuera"? "selected": " "; ?> >Naty Figuera</option>
                        </select>
                    </div>

                    <div class="py-1">
                        <label for="lstEstado">Estado de la Tarea</label>
                        <select name="lstEstado" id="lstEstado" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["estado"] : ""; ?>">
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="Sin Asignar" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["estado"] == "Sin Asignar"? "selected": " "; ?> >Sin Asignar</option>
                            <option value="Asignado" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["estado"] == "Asignado"? "selected": " "; ?> >Asignado</option>
                            <option value="En Proceso" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["estado"] == "En Proceso"? "selected": " "; ?> >En Proceso</option>
                            <option value="Terminado" <?php echo isset ($aTareas[$id]) && $aTareas[$id]["estado"] == "Terminado"? "selected": " "; ?> >Terminado</option>
                        </select>
                    </div>

                    <div class="py-1">
                        <label for="txtDescripcion">Descripción</label>
                        <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["descripcion"] : ""; ?>"></textarea>
                    </div>

                    <div class="py-1">
                        <button type="submit" id="btnEnviar" name="btnEnviar" class="btn btn-primary">Enviar</button>
                    </div>

                </form>
            </div>
        </div>
        <?php if(count($aTareas)): ?>
        <div class="row">
            <div class="col-12 pt-3">
                <table class="table table-hover border">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Inserción</th>
                            <th>Titulo</th>
                            <th>Prioridad</th>
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($aTareas as $posicion => $tarea) : ?>
                            <tr>
                                <td><?php echo $posicion; ?></td>
                                <td><?php echo $tarea["fecha"]; ?></td>
                                <td><?php echo $tarea["titulo"]; ?></td>
                                <td><?php echo $tarea["prioridad"]; ?></td>
                                <td><?php echo $tarea["usuario"]; ?></td>
                                <td>
                                    <a href="?id=<?php echo $posicion; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="?id=<?php echo $posicion; ?>&do=eliminar"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else : ?>
                <div class="row">
                    <div class="col-12 py-3">
                        <div class="alert alert-info" role= "alert">No se han cargado tareas todavia</div>
                    </div>
                </div>
        <?php endif; ?>
    </main>
</body>

</html>