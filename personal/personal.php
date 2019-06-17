<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion de Personal</title>
</head>
<body>
    <h1>Gestion de Personal</h1>
    <div><a href="personalnuevo.php">Nuevo</a></div>
    <table>
    <tr>
    <td>N°</td>
    <td>Personal</td>
    <td>DNI</td>
    <td>Opciones</td>
    </tr>
    <?php
    $sql = 'SELECT P.Codigo, P.Nombres, P.ApellidoPaterno,
    P.ApellidoMaterno, P.DNI, P.Vigencia 
    FROM personal P ORDER BY P.ApellidoPaterno, P.ApellidoMaterno';
    try {
        require '../conectar.php';
        $datos = $conexion->query($sql);
        $i=1;
        foreach ($datos as $fila) {
            echo '<tr>';
            echo '<td>' . $i . '</td>';
            echo '<td>' . $fila['ApellidoPaterno'] . ' ' . 
            $fila['ApellidoMaterno'] . ' ' . $fila['Nombres'] . '</td>';
            echo '<td>' . $fila['DNI'] . '</td>';
            echo '<td><a href="personaleditar.php?cod=' . $fila['Codigo'] .
            '">editar</a></td>';
            echo '<td><a href="eliminarPersonal.php?cod=' . $fila['Codigo'] .
            '">eliminar</a></td>';
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