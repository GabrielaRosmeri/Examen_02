<?php
    $codigo = 0;
    $nombre = '';
    $precio = '';
    $negociable = false;
    $tipo = '';
    $codigoC = '';
    $vigencia = false;
    $sql = '';
    $msje = '';

    if (isset($_GET['cod']) == true) {
        //mostrar datos
        $codigo = $_GET['cod'];
        $sql = 'SELECT *
        FROM Producto P WHERE P.Codigo = ' . $codigo;

        try {
            require '../conectar.php';
            $datos = $conexion->query($sql);
            if( $datos == true ){
                $filas = $datos->fetchAll();
                if (count($filas) == 1) {
                    $nombre = $filas[0]['nombre'];
                    $precio = $filas[0]['precio'];
                    $negociable = $filas[0]['negociable'];
                    $tipo = $filas[0]['Tipo'];
                    $codigoC= $filas[0]['CodigoCategoria'];
                    $vigencia = $filas[0]['vigencia'];
                } else {
                    $msje = 'No se pudo encontrar los datos solicitados';
                }
            }else{
                $msje = 'no se pudo realizar la consulta';
            }    
        } catch (PDOException $e) {
            $msje = $e->msje . 'No se pudo acceder a la base de datos';
        }
    } else {
        if( isset( $_POST['hCodigo'] ) == true && 
            isset( $_POST['txtNombre'] ) == true &&
            isset( $_POST['txtPrecio'] ) == true  ){

            $codigo = $_POST['hCodigo'];
            $nombre = $_POST['txtNombre'];
            $precio = $_POST['txtPrecio'];
            $tipo = $_POST['cboTipo'];
    
            if( isset( $_POST['chkVigencia'] ) ==  true){
                $vigencia = true;
            }
            if( isset( $_POST['chkNegociable'] ) ==  true){
                $negociable = true;
            }

            $sql = 'UPDATE Producto
                SET Nombre = \'' . $nombre . '\', negociable = ' . ($negociable== true ? 1 : 0) 
                . ', precio = \''. $precio . '\', tipo =  \''. $tipo . '\', vigencia =' . 
                ($vigencia == true ? 1 : 0) . '   WHERE Codigo = ' . $codigo;
    
            try{
                include( '../conectar.php');
                $cantidad = $conexion->exec($sql);
                if( $cantidad > 0){
                    
                    //$msj = 'Personal modificado exitosamnete';
                    header( 'location:producto.php');
                }else{
                    $msj = 'No se pudo modificar el producto';
                    
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
    <title>Producto Editar</title>
</head>
<body>
    <h1>Producto Editar</h1>
    <?php
        if( $msje != ''){
            echo '<div>' . $msje . '</div>';
        }
    ?>
    <form action="productoeditar.php" method="post">
        <input type="hidden" name="hCodigo" value="<?= $codigo ?>">
       
        <div>Nombre <input type="text" name="txtNombre" value="<?= $nombre ?>"></div>
        <div>Precio <input type="number" name="txtPrecio" value="<?= $precio ?>"></div>
        <div>Negociable <input type="checkbox" name="cboNegociable" value="<?= $negociable ?>"></div>
        <div>Tipo <select name="cboTipo" id="cboTipo">
            <option value="B">Bien</option>
            <option value="S">Servicio</option>
            </select>
        <div>Vigencia<input type="checkbox" name="chkVigencia" 
        <?= ($vigencia == true ? 'checked' : 'unchecked') ?>
        ></div>
        <div><input type="submit" name="btnActualizar" value="Actualizar"></div>
    </form>
</body>
</html>