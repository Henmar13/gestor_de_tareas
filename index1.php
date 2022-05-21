<?php
ini_set("display_errors",1);
ini_set("display_startup_errors",1);
error_reporting(E_ALL);

if (file_exists("archivo.txt")) {
    //Se Leer el archivo y se almacena el contenido json en una variable
    $strJson = file_get_contents("archivo.txt");
    //Se Convierte el json en un array aClientes
    $aTareas = json_decode($strJson, true);
} else {
    //Si el archivo no existe es porque no hay clientes
    $aTareas = array();
}

//BOTON MODIFICAR

if(isset($_GET["id"])){
    $id = $_GET["id"];
}else {
    $id = "";
}

//BOTON ELIMINAR

if(isset($_GET["do"]) && $_GET["do"] == "eliminar"){
    unset($aTareas[$id]);

    //Convertir aClientes en Json
    $strJson = json_encode($aTareas);

    //Almacenar el Json en archivo
    file_put_contents("archivo.txt", $strJson);

    header("location: index.php");
}


if($_POST){
    $titulo = $_POST["txtTitulo"];
    $prioridad = $_POST["txtPrioridad"];
    $usuario = $_POST["txtUsuario"];
    $estado = $_POST["txtEstado"];
    $descripcion = $_POST["txtDescripcion"];

    $aTareas = array();
    $aTareas[] = array(
        "titulo" => $titulo,
        "prioridad" => $prioridad,
        "usuario" => $usuario,
        "estado" => $estado,
        "descripcion" => $descripcion
    );


    if ($id >= 0){  
        //Si se está editando hacer esto:
        $aTareas[] = array(
            "titulo" => $titulo,
            "prioridad" => $prioridad,
            "usuario" => $usuario,
            "estado" => $estado,
            "descripcion" => $descripcion
        );
    }else{
        //Si se esta insertando una nueva tarea
        $aTareas[] = array(
            "titulo" => $titulo,
            "prioridad" => $prioridad,
            "usuario" => $usuario,
            "estado" => $estado,
            "descripcion" => $descripcion
        );
    }
    //convertir el array en json
    $strjson = json_encode($aTareas);
    //almacenar en un archivo.txt el json
    file_put_contents("archivo.txt", $strjson);
}


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
                        <input type="text" name="txtTitulo" id = "txtTitulo" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["titulo"] : "";?>" >
                    </div>

                    <div class="py-1">
                        <label for="lstPrioridad">Prioridad</label>
                        <select name="lstPrioridad" id="lstPrioridad" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["prioridad"] : "";?>" >
                            <option value="" disabled selected >Seleccionar</option>
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>

                    <div class="py-1">
                        <label for="lstUsuario">Usuario</label>
                        <select name="lstUsuario" id="lstUsuario" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["usuario"] : "";?>" >
                            <option value="" disabled selected >Seleccionar</option>
                            <option value="Jony Moran">Jony Moran</option>
                            <option value="Ale Medina">Ale Medina</option>
                            <option value="Naty Figuera">Naty Figuera</option>
                        </select>
                    </div>

                    <div class="py-1">
                        <label for="lstEstado">Estado de la Tarea</label>
                        <select name="lstEstado" id="lstEstado" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["estado"] : "";?>" >
                            <option value="" disabled selected >Seleccionar</option>
                            <option value="Sin Asignar">Sin Asignar</option>
                            <option value="Asignado">Asignado</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Terminado">Terminado</option>
                        </select>
                    </div>

                    <div class="py-1">
                        <label for="txtDescripcion">Descripción</label>
                        <textarea name="txtDescripcion" id="txtDescripcion" class="form-control" value="<?php echo isset($aTareas[$id]) ? $aTareas[$id]["descripcion"] : "";?>" ></textarea>
                    </div>

                    <div class="py-1">
                        <button type="submit" id="btnEnviar" name= "btnEnviar" class="btn btn-primary" >Enviar</button>
                    </div>

                </form>
            </div>
        </div>

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
                                <td>ID</td>
                                <td>FECHA</td>
                                <td><?php echo $tarea["titulo"]; ?></td>
                                <td><?php echo $tarea["prioridad"]; ?></td>
                                <td><?php echo $tarea["usuario"]; ?></td>
                                <td>
                                    <a href="?id=<?php echo $posicion;?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <a href="?id=<?php echo $posicion;?>&do=eliminar"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </main>
</body>
</html>
