<?php
    $codigo = 0;
    $msje = '';
    $nombre = '';
    $descripcion = '';
    $vigencia = false;
    $sql = '';

    if(isset( $_GET['cod'])== true){
        //mostrar datos
        $codigo = $_GET['cod'];
        $sql = 'SELECT C.Nombre, C.Descripcion, P.Vigencia 
        FROM categoria C WHERE C.Codigo = ' . $codigo;

        try {
            require '../conectar.php';
            $datos = $conexion->query($sql);
            if( $datos == true ){
                $filas = $datos->fetchAll();
                if (count($filas) == 1) {
                    $nombre = $filas[0]['Nombre'];
                    $descripcion = $filas[0]['Descripcion'];
                    $vigencia = $filas[0]['Vigencia'];
                } else {
                    $msje = 'No se pudo encontrar los datos solicitados';
                }
            }else{
                $msje = 'no se pudo realizar la consulta';
            }    
        } catch (PDOException $e) {
            $msje = $e->msje . 'No se pudo acceder a la base de datos';
        }
    }else{
        if(isset( $_POST['hCodigo'])== true && 
        isset($_POST['txtNombre'])== true &&
        isset($_POST['txtDescripcion'])== true ){

            $codigo = $_POST['hCodigo'];
            $nombre = $_POST['txtNombre'];
            $descripcion = $_POST['txtDescripcion'];
            if(isset($_POST['chkVigencia']) == true){
                $vigencia = true;
            }

    $sql = 'UPDATE Categoria SET Nombre = \''. $nombre .
            '\', Descripcion = \''. $descripcion .
             '\', Vigencia = ' .
            ( $vigencia == true ? 1 : 0)
            . ' WHERE Codigo = ' . $codigo ;

    try{
        echo $sql;
        include( '../conectar.php');
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
        }else{
            $msje = 'No llegaron los parametros necesarios';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar Categoria</title>
</head>
<body>
<h1>Modificar Categoria</h1>
<?php
        if( $msje != ''){
            echo '<div>' . $msje . '</div>';
        }
    ?>
    <form action="categoriaeditar.php"method="post">
    <input type="hidden" name="hCodigo" value="<?= $codigo?>">
    <div>Nombre <input type="text"name= "txtNombre" value="<?=$nombre?>"></div>
    <div>Descripcion <input type="text"name= "txtDescripcion" value="<?=$descripcion?>"></div>
    <div>Vigencia<input type="checkbox"name= "chkVigencia" 
    <?= ( $vigencia == true?'checked' : 'unchecked') ?>></div>
    <div><input type="submit"name="btnRegistrar"value="Registrar"></div>
    </form>
</body>
</html>