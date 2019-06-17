<?php
    $nombre = '';
    $clave = '';
    $codPersonal = 0;
    $msj = '';
    $sql = '';

    if( isset($_POST['txtNombre']) == true &&
        isset($_POST['txtClave']) == true &&
        isset($_POST['cboPersonal']) == true ){
        
        $nombre = $_POST['txtNombre'];
        $clave = $_POST['txtClave'];
        $codPersonal = $_POST['cboPersonal'];

        $sql = 'INSERT INTO Usuario( Nombre, Clave, CodigoPersonal, Vigencia)' . 
        'VALUES(\'' . $nombre . '\', \'' . $clave . '\', ' . $codPersonal . ', 1) ';

        try{
            include( '../conectar.php');
            $cantidad = $conexion->exec($sql);
            if( $cantidad > 0){
                // $msj = 'Usuario registrado exitosamente';
                header( 'location:usuario.php');
            }else{
                $msj = 'No se pudo registrar al usuario';
                // PARA RECARGAR header( 'location:personal.php');
            }
        }catch(Exception $e){
            $msj = 'No se pudo realizar la operacion';
            // Mensaje de error
            $msj = $msj . $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nuevo</title>
</head>
<body>
<h1>Nuevo Usuario</h1>
    <?php
        if( $msj != ''){
            echo '<div>' . $msj . '</div>';
        }
    ?>
    <form action="usuarionuevo.php" method="post">
        <div>Nombre <input type="text" name="txtNombre" value="<?= $nombre ?>"></div>
        <div>Clave <input type="password" name="txtClave" value=""></div>
            <div>Personal <select name="cboPersonal" id="cboPersonal">
            <option value="0">Seleccione un personal</option>
        <?php
        $sql = 'SELECT P.Codigo, P.Nombres, P.ApellidoPaterno,
        P.ApellidoMaterno
        FROM personal P
        Where P.Vigencia = 1
        ORDER BY P.apellidoPaterno, P.apellidoMaterno';
        try {
            require '../conectar.php';
            $datos = $conexion->query($sql);
            $i=1;
            foreach ($datos as $fila){
                echo '<option value = "' . $fila['Codigo'] . '" '
                . ( $fila['Codigo'] == $codPersonal ? 'selected' : '' )
                . '>' . $fila['ApellidoPaterno'] . ' ' . 
                $fila['ApellidoMaterno'] . ' ' . $fila['Nombres'] . '</option>';
                $i++;
            }
        } catch (PDOException $e) {
            echo '<option value="-1">' . $e->getMessage().'</option>';
        }
        ?>
        </select></div>
       
        <div><input type="submit" name="btnRegistrar" value="Registrar"></div>
    </form>
</body>
</html>