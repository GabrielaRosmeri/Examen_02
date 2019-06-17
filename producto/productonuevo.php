<?php
    $nombre = '';
    $precio = '';
    $negociable = false;
    $precioM = '';
    $tipo = '';
    $codCategoria = 0;
    $msj = '';
    $sql = '';

    if( isset($_POST['txtNombre']) == true &&
        isset($_POST['txtPrecio']) == true &&
        isset($_POST['txtPrecioMinimo']) == true &&
        isset($_POST['cboTipo']) == true &&
        isset($_POST['cboCategoria']) == true ){
        
        $nombre = $_POST['txtNombre'];
        $precio = $_POST['txtPrecio'];
        $_POST['cboNegociable'] ? $negociable=1 : $negociable=0;
        $precioM = $_POST['txtPrecioMinimo'];
        $tipo = $_POST['cboTipo'];
        $codCategoria = $_POST['cboCategoria'];

        $sql = 'INSERT INTO Producto( Nombre, Precio, Negociable, PrecioMinimo, Tipo,CodigoCategoria, Vigencia)' . 
        'VALUES(\'' . $nombre . '\', \'' . $precio . '\','.$negociable .',
        \'' . $precioM . '\', \'' . $tipo . '\',' . $codCategoria . ', 1) ';

        try{
            echo $sql;
            include( '../conectar.php');
            $cantidad = $conexion->exec($sql);
            if( $cantidad > 0){
                // $msj = 'Usuario registrado exitosamente';
                header( 'location:producto.php');
            }else{
                $msj = 'No se pudo registrar el producto';
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
    <title>Producto Nuevo</title>
</head>
<body>
<h1>Nuevo Producto</h1>
    <?php
        if( $msj != ''){
            echo '<div>' . $msj . '</div>';
        }
    ?>
    <form action="productonuevo.php" method="post">
        <div>Nombre <input type="text" name="txtNombre" value="<?= $nombre ?>"></div>
        <div>Precio <input type="number" name="txtPrecio" value="<?= $precio ?>"></div>
        <div>Negociable <input type="checkbox" name="cboNegociable" value="<?= $negociable ?>"></div>
        <div>Precio Minimo<input type="number" name="txtPrecioMinimo" value="<?= $precioM ?>"></div>
        <div>Tipo <select name="cboTipo" id="cboTipo">
            <option value="B">Bien</option>
            <option value="S">Servicio</option>
        </select></div>
            <div>Categoria <select name="cboCategoria" id="cboCategoria">
            <option value="0">Seleccione una Categoria</option>
        <?php
        $sql = 'SELECT C.Codigo, C.Nombre
        FROM categoria C
        Where C.Vigencia = 1
        ORDER BY C.Codigo';
        try {
            require '../conectar.php';
            $datos = $conexion->query($sql);
            foreach ($datos as $fila){
                ?>
                <option value="<?=$fila['Codigo']?>"><?=$fila['Nombre']?></option>
                <?php
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