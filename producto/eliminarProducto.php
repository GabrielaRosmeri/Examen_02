<?php
if (isset($_GET['cod'])) {
    $codigo = $_GET['cod'];
    $sql = "DELETE FROM producto WHERE producto.codigo='$codigo'";
    try {
       
        include( '../conectar.php');
        $cantidad = $conexion->exec($sql);
        if ($cantidad>0) {
            header( 'location:usuario.php');
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>