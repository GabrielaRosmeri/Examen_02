<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion Categoria</title>
</head>
<body>
    <h1>Gestion Categoria</h1>
    <div><a href="categorianuevo.php">Nuevo</a></div>
    <table>
    <tr>
    <td>N°</td>
    <td>Categoria</td>
    <td>Descripcion</td>
    <td>Opciones</td>
    </tr>
    <?php
    $sql = 'SELECT C.Codigo, C.Nombre,C.Descripcion,
        C.Vigencia 
    FROM categoria C ORDER BY C.Nombre, C.Descripcion';
    try {
        require 'conectar.php';
        $datos = $conexion->query($sql);
        $i=1;
        foreach ($datos as $fila) {
            echo '<tr>';
            echo '<td>' . $i . '</td>';
            echo '<td>' . $fila['Nombre'];
            echo '<td>' . $fila['Descripcion'];
            echo '<td><a href="categoriaeditar.php?cod=' . $fila['Codigo'] .
            '">editar</a></td>';
            echo '</tr>';
            $i++;
        }
    } catch (PDOException $e) {
        echo'<tr><td colspan="3">' . $e->getMessage() . '</td></tr>';
    }
    ?>
    </table>
</body>
</html>