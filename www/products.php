<?php include("./template/header.php"); ?>
<?php include("admin/cofig/bd.php"); 

$sql = "SELECT * FROM libros";
$result = mysqli_query($conection, $sql);
$listaLibros = $result->fetch_all(MYSQLI_ASSOC);

?>

<?php foreach($listaLibros as $libro){ ?>
<div class="col-md-3">

    <div class="card">

        <img class="card-img-top" src="./img/<?php echo $libro['imagen']; ?>" alt="">

        <div class="card-body">
            <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
            <a name="" id="" class="btn btn-primary" href="http://goalkicker.com/" role="button">Ver más</a>
        </div>
    </div>
</div>
<?php }?>






<?php include("./template/footer.php"); ?>