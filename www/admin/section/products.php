<?php ob_start(); include("../template/head.php");?>
<?php include("../cofig/bd.php");?>

<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$action = (isset($_POST['action'])) ? $_POST['action'] : "";


switch ($action) {

    case "Agregar":

       /* $sentenciaSQL = $conection->prepare("INSERT INTO libros (nombre,imagen ) VALUES (:nombre,:imagen);");
        $sentenciaSQL->bindParam(':nombre', $txtNombre);
        $sentenciaSQL->bindParam(':imagen', $txtImagen);
        $sentenciaSQL->execute();*/


       $stmt = $conection->prepare("INSERT INTO libros (nombre, imagen) VALUES (?, ?)");

       $fecha = new DateTime();
       $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

       $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
       
       if($tmpImagen!=""){

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }




       $stmt->bind_param("ss", $txtNombre, $nombreArchivo);
       $stmt->execute();

        
       header("Location:products.php");
        break;

    case "Modificar":


        $stmt = $conection->prepare("UPDATE libros SET nombre=? WHERE id=?");
        $stmt->bind_param("ss", $txtNombre, $txtID);
        $stmt->execute();

        if($txtImagen!=""){

            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

            $sql = "SELECT * FROM libros WHERE id=$txtID";
            $result = mysqli_query($conection, $sql);
            $libro = $result->fetch_all(MYSQLI_ASSOC);
    
            foreach($libro as $selecLibro){
                if(isset($selecLibro["imagen"])&&($selecLibro["imagen"]!="imagen.jpg")){
    
                    if(file_exists("../../img/".$selecLibro["imagen"])){
        
                        unlink("../../img/".$selecLibro["imagen"]);
                    }
        
                }
    
            }

            

            $stmt = $conection->prepare("UPDATE libros SET imagen=? WHERE id=?");
            $stmt->bind_param("ss", $nombreArchivo, $txtID);
            $stmt->execute();

        }


        header("Location:products.php");
        //echo "Presionado botón Modificar";
        break;

    case "Cancelar":        
        header("Location:products.php");
        /*($action=="Cancelar")?"disabled":"";
        $txtID="";
        $txtNombre="";*/
        break;

    case "Seleccionar":

        $sql = "SELECT * FROM libros WHERE id=$txtID";
        $result = mysqli_query($conection, $sql);
        $libro = $result->fetch_all(MYSQLI_ASSOC);

        foreach($libro as $selecLibro){
            $txtNombre=$selecLibro['nombre'];
            $txtImagen=$selecLibro['imagen'];

        }

        //echo "Presionado botón Seleccionar";
        break;

    case "Borrar":

        $sql = "SELECT * FROM libros WHERE id=$txtID";
        $result = mysqli_query($conection, $sql);
        $libro = $result->fetch_all(MYSQLI_ASSOC);

        foreach($libro as $selecLibro){
            if(isset($selecLibro["imagen"])&&($selecLibro["imagen"]!="imagen.jpg")){

                if(file_exists("../../img/".$selecLibro["imagen"])){
    
                    unlink("../../img/".$selecLibro["imagen"]);
                }
    
            }

        }

        $stmt = $conection->prepare("DELETE FROM libros WHERE id=?");
        $stmt->bind_param("s", $txtID);
        $stmt->execute();
        header("Location:products.php");
        break;
}

   //$stmt = $conection->prepare("SELECT * FROM libros");
   //$stmt = execute();
   $sql = "SELECT * FROM libros";
   $result = mysqli_query($conection, $sql);
   $listaLibros = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="col-md-5">

    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <div class="form-group" >
                    <label for="txtID">ID: </label>
                    <input type="text" readonly value="<?php echo $txtID;?>" class="form-control" id="txtID" name="txtID" placeholder="ID">
                </div>

                <div class="form-group">
                    <label for="txtNombre">Nombre: </label>
                    <input type="text" required value="<?php echo $txtNombre;?>" class="form-control" id="txtNombre" name="txtNombre" placeholder="Nombre del libro">
                </div>

                <div class="form-group d-flex flex-column">
                    <label for="txtImagen">Imagen: </label>

                    <?php if($txtImagen!=""){?>

                        <img src="../../img/<?php echo $txtImagen; ?>" width="50" alt="" srcset="">

                    <?php } ?>

                    <input type="file" class="form-control mt-2" id="txtImagen" name="txtImagen" placeholder="Nombre del libro">
                </div>

                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="action" <?php echo ($action=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="action" <?php echo ($action!="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="action" <?php echo ($action!="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>

            </form>

        </div>
    </div>

</div>

<div class="col-md-7">

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($listaLibros as $libro){ ?>
            <tr>
                <td><?php echo $libro['id']; ?></td>
                <td><?php echo $libro['nombre']; ?></td>
                <td>
                    <img src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="" srcset="">
                </td>

                <td>

                    <form method="POST">

                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['id']; ?>" />
                        <input type="submit" name="action" value="Seleccionar" class="btn btn-primary" />
                        <input type="submit" name="action" value="Borrar" class="btn btn-danger" />

                    </form>
                
                </td>

            </tr>
        <?php } ?>

        </tbody>
    </table>

</div>







<?php include("../template/footer.php");?>