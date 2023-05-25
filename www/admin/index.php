<?php
session_start();

    if($_POST){

        if(($_POST['usuario']=="tapia")&&($_POST['contrasena']=="inge")){
            $_SESSION['usuario']="ok";
            $_SESSION['nombreUsuario']="Tapia";
            header('location:start.php');
        }else{
            $mensaje = "Error: El usuario o contraseña son incorrectos";
        }


        
    }

?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/estilos.css" />
</head>

<body>

    <div class="container">
        <div class="row d-flex justify-content-center">

            <div class="col-md-4 d-flex align-items-center altura">

                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">

                    <?php if(isset($mensaje)) {?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php }?>

                        <form method="POST" >
                            <div class="form-group">
                                <label for="usuarios">Usuario</label>
                                <input type="text" class="form-control" id="usuarios" name="usuario" placeholder="Escribe tu usuario">
                            </div>

                            <div class="form-group">
                                <label for="pass">Contraseña: </label>
                                <input type="password" class="form-control" id="pass" name="contrasena" placeholder="Escribe tu contraseña">
                            </div>

                            <button type="submit" class="btn btn-primary">Entrar al Administrador</button>
                        </form>



                    </div>

                </div>

            </div>

        </div>
    </div>







</body>

</html>