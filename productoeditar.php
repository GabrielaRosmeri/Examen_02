<?php
    $codigo = 0;
    $nombre = '';
    $precio = '';
    $negociable = false;
    $precioM = '';
    $tipo = '';
    $codigoC = '';
    $vigencia = false;
    $sql = '';
    $msje = '';

    if (isset($_GET['cod']) == true) {
        //mostrar datos
        $codigo = $_GET['cod'];
        $sql = 'SELECT P.Nombre, P.Precio, P.Negociable, P.PrecioMinimo, P.Tipo, P.CodigoCategoria
        FROM Producto P WHERE P.Codigo = ' . $codigo;

        try {
            require 'conectar.php';
            $datos = $conexion->query($sql);
            if( $datos == true ){
                $filas = $datos->fetchAll();
                if (count($filas) == 1) {
                    $nombre = $filas[0]['Nombre'];
                    $precio = $filas[0]['Precio'];
                    $negociable = $filas[0]['Negociable'];
                    $precioM = $filas[0]['PrecioMinimo'];
                    $tipo = $filas[0]['Tipo'];
                    $codigoC= $filas[0]['CodigoCategoria'];
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
    } else {
        if( isset( $_POST['hCodigo'] ) == true && 
            isset( $_POST['txtNombre'] ) == true &&
            isset( $_POST['cboNegociable'] ) == true &&
            isset( $_POST['txtPrecioM'] ) == true &&
            isset( $_POST['cbotipo'] ) == true &&
            isset( $_POST['cboCategoria'] ) == true ){

            $codigo = $_POST['hCodigo'];
            $nombre = $_POST['txtNombre'];
            $negociable = $_POST['cboNegociable'];
            $precioM = $_POST['txtPrecioM'];
            $tipo = $_POST['cboTipo'];
            $codigoC = $_POST['cboCategoria'];
    
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
    <title>Producto Editar</title>
</head>
<body>
    <h1>Producto Editar</h1>
</body>
</html>