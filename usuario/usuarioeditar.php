<?php 
    $codigo = 0;
    $nombres = '';
    $clave = '';
    $codigoPersonal = '';
    $vigencia = false;
    $msje = '';
    $sql = '';

    if( isset( $_GET['cod'] ) == true){
        //mostrar datos
        $codigo = $_GET['cod'];
        $sql = 'SELECT U.Nombre, U.CodigoPersonal, U.Vigencia 
        FROM Usuario U WHERE U.Codigo = ' . $codigo;

        try {
            require 'conectar.php';
            $datos = $conexion->query($sql);
            if( $datos == true ){
                $filas = $datos->fetchAll();
                if (count($filas) == 1) {
                    $nombres = $filas[0]['Nombre'];
                    $codigoPersonal = $filas[0]['CodigoPersonal'];
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
        if( isset( $_POST['hCodigo'] ) == true && 
            isset( $_POST['txtNombre'] ) == true &&
            isset( $_POST['txtClave'] ) == true &&
            isset( $_POST['cboPersonal'] ) == true ){

            $codigo = $_POST['hCodigo'];
            $nombre = $_POST['txtNombre'];
            $clave = $_POST['txtClave'];
            $codigoPersonal = $_POST['cboPersonal'];
    
            if( isset( $_POST['chkVigencia'] ) ==  true){
                $vigencia = true;
            }

            $sql = 'UPDATE Usuario
                SET Nombre = \'' . $nombre . '\', Clave = \'' . $clave
                . '\', CodigoPersonal = ' . $codigoPersonal . ', Vigencia =' . 
                ($vigencia == true ? 1 : 0) . '   WHERE Codigo = ' . $codigo;
    
            try{
                include( 'conectar.php');
                $cantidad = $conexion->exec($sql);
                if( $cantidad > 0){
                    //$msj = 'Personal modificado exitosamnete';
                    header( 'location:usuario.php');
                }else{
                    $msj = 'No se pudo modificar al personal';
                    
                }
            }catch(Exception $e){
                $msj = 'No se pudo realizar la operacion';
                // Mensaje de error
                $msj = $msj . $e->getMessage();
            }
        }else{
            $msje = 'No llegaron los parámetros necesarios';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar</title>
</head>
<body>
    <h1> Editar Usuario </h1>
    
    <?php
        if( $msje != ''){
            echo '<div>' . $msje . '</div>';
        }
    ?>
    <form action="usuarioeditar.php" method="post">
        <input type="hidden" name="hCodigo" value="<?= $codigo ?>">
        Personal <select name="cboPersonal" id="cboPersonal">
        <option value="0">Seleccione un personal</option>
        <?php
        $sql = 'SELECT P.Codigo, P.Nombres, P.ApellidoPaterno,
        P.ApellidoMaterno
        FROM personal P
        Where P.Vigencia = 1
        ORDER BY P.apellidoPaterno, P.apellidoMaterno';
        try {
            require 'conectar.php';
            $datos = $conexion->query($sql);
            $i=1;
            foreach ($datos as $fila){
                echo '<option value = "' . $fila['Codigo'] . '" '
                . ( $fila['Codigo'] == $codigoPersonal ? 'selected' : '' )
                . '>' . $fila['ApellidoPaterno'] . ' ' . 
                $fila['ApellidoMaterno'] . ' ' . $fila['Nombres'] . '</option>';
                $i++;
            }
        } catch (PDOException $e) {
            echo '<option value="-1">' . $e->getMessage().'</option>';
        }
        ?>
        </select></div>
        <div>Nombre <input type="text" name="txtNombre" value="<?= $nombres ?>"></div>
        <div>Clave <input type="password" name="txtClave" value=""></div>
        <div>Vigencia<input type="checkbox" name="chkVigencia" 
        <?= ($vigencia == true ? 'checked' : 'unchecked') ?>
        ></div>
        <div><input type="submit" name="btnActualizar" value="Actualizar"></div>
    </form>
</body>
</html>