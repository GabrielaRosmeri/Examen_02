<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion de Productos</title>
</head>
<body>
<h1>Gestión de Productos</h1>
    <div><a href="productonuevo.php">Nuevo</a></div>
    <table>
        <tr>
            <td>N°</td>
            <td>Producto</td>
            <td>Categoria</td>
            <td>Opciones</td>
        </tr>

        <?php
            $sql = ' SELECT P.Codigo, P.Nombre, C.Nombre as categoriaNombre
            FROM producto P JOIN categoria C ON C.Codigo = P.CodigoCategoria
            ORDER BY P.Nombre';
            try{
                require '../conectar.php';
                $datos = $conexion->query($sql);
                $i=1;
                foreach ($datos as $fila) {
                    echo '<tr>';
                    echo '<td>' . $i . '</td>';
                    echo '<td>'  . $fila['Nombre'] . '</td>';
                    echo '<td>' . $fila['categoriaNombre'] . '</td>';
                    echo '<td><a href="productoeditar.php?cod=' . $fila['Codigo'] . '">Editar</a></td>';
                    echo '<td><a href="eliminarProducto.php?cod=' . $fila['Codigo'] .
                    '">eliminar</a></td>';
                    echo '</tr>';
                    $i++;
                }
            }catch(PDOException $e){
                echo '<tr><td colspan="3">' . $e->getMessage() . '</td></tr>';
            }
        ?>

    </table>
</body>
</html>