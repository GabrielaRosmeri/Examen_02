<?php
 $nombre = '';
 $descripcion = '';
 $msje = '';
 $sql = '';

 if(isset($_POST['txtNombre'])== true &&
    isset($_POST['txtDescripcion'])== true ){

    $nombre = $_POST['txtNombre'];
    $descripcion = $_POST['txtDescripcion'];

    $sql = 'INSERT INTO Categoria(Nombre,Descripcion,Vigencia)' . 
    'VALUES(\''. $nombre . '\', \''. $descripcion  .  '\',1)';

    try{
        include( 'conectar.php');
        $cantidad = $conexion->exec($sql);
        if($cantidad > 0){
            //$msje = 'Personal registrado exitosamente';
            header( 'location:categoria.php');
        }else{
            $msje = 'No se puede registrar el personal';
        }
    }catch(Exception $e){
        $msje = 'No se puede realizar la operacion';
        $msje = $msje . $e->getMessage();
    }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nueva Categoria</title>
</head>
<body>
    <h1>Nueva Categoria</h1>
    <?php
        if( $msje != ''){
            echo '<div>' . $msje . '</div>';
        }
    ?>
    <form action="categorianuevo.php"method="post">
    <div>Nombre <input type="text"name= "txtNombre" value="<?=$nombre?>"></div>
    <div>Descripcion <input type="text"name= "txtDescripcion" value="<?=$descripcion?>"></div>
    <div><input type="submit"name="btnRegistrar"value="Registrar"></div>
    </form>
</body>
</html>