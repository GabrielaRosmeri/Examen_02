<?php
    $codigo = 0;
    $msje = '';
    $nombres = '';
    $apellidoPaterno = '';
    $apellidoMaterno = '';
    $DNI = '';
    $celular = '';
    $correo = '';
    $vigencia = false;
    $sql = '';

    if(isset( $_GET['cod'])== true){
        //mostrar datos
        $codigo = $_GET['cod'];
        $sql = 'SELECT P.Nombres, P.ApellidoPaterno, P.ApellidoMaterno, P.DNI, 
        P.Celular, P.Correo, P.Vigencia 
        FROM personal P WHERE P.Codigo = ' . $codigo;

        try {
            require '../conectar.php';
            $datos = $conexion->query($sql);
            if( $datos == true ){
                $filas = $datos->fetchAll();
                if (count($filas) == 1) {
                    $nombres = $filas[0]['Nombres'];
                    $apellidoPaterno = $filas[0]['ApellidoPaterno'];
                    $apellidoMaterno = $filas[0]['ApellidoMaterno'];
                    $DNI = $filas[0]['DNI'];
                    $celular = $filas[0]['Celular'];
                    $correo = $filas[0]['Correo'];
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
        isset($_POST['txtNombres'])== true &&
        isset($_POST['txtApellidoPaterno'])== true &&
        isset($_POST['txtApellidoMaterno'])== true &&
        isset($_POST['txtDNI'])== true &&
        isset($_POST['txtCelular'])== true &&
        isset($_POST['txtCorreo'])== true){

            $codigo = $_POST['hCodigo'];
            $nombres = $_POST['txtNombres'];
            $apellidoPaterno = $_POST['txtApellidoPaterno'];
            $apellidoMaterno = $_POST['txtApellidoMaterno'];
            $DNI = $_POST['txtDNI'];
            $celular = $_POST['txtCelular'];
            $correo = $_POST['txtCorreo'];
            if(isset($_POST['chkVigencia']) == true){
                $vigencia = true;
            }

    $sql = 'UPDATE Personal SET Nombres = \''. $nombres .
            '\', ApellidoPaterno = \''. $apellidoPaterno .
            '\', ApellidoMaterno = \'' . $apellidoMaterno .
            '\', DNI =  \'' . $DNI . '\', Celular = \'' . 
            $celular. '\', Correo = \'' . $correo . '\', Vigencia = ' .
            ( $vigencia == true ? 1 : 0)
            . ' WHERE Codigo = ' . $codigo ;

    try{
        echo $sql;
        include( '../conectar.php');
        $cantidad = $conexion->exec($sql);
        if($cantidad > 0){
            //$msje = 'Personal registrado exitosamente';
            header( 'location:personal.php');
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
    <title>Modificar Personal</title>
</head>
<body>
   <h1>Modificar Personal</h1> 
   <?php
        if( $msje != ''){
            echo '<div>' . $msje . '</div>';
        }
    ?>
    <form action="personaleditar.php"method="post">
    <input type="hidden" name="hCodigo" value="<?= $codigo?>">
    <div>Nombres <input type="text"name= "txtNombres" value="<?=$nombres?>"></div>
    <div>Apellido Paterno <input type="text"name= "txtApellidoPaterno" value="<?=$apellidoPaterno?>"></div>
    <div>Apellido Materno <input type="text"name= "txtApellidoMaterno" value="<?=$apellidoMaterno?>"></div>
    <div>DNI<input type="text"name= "txtDNI" value="<?=$DNI?>"></div>
    <div>Celular<input type="text"name= "txtCelular" value="<?=$celular?>"></div>
    <div>Correo<input type="text"name= "txtCorreo" value="<?=$correo?>"></div>
    <div>Vigencia<input type="checkbox"name= "chkVigencia" 
    <?= ( $vigencia == true?'checked' : 'unchecked') ?>></div>
    <div><input type="submit"name="btnRegistrar"value="Registrar"></div>
    </form>
</body>
</html>