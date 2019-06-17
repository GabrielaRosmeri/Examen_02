<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestión de Usuarios</title>
</head>
<body>
    <h1>Gestión de Usuarios</h1>
    <div><a href="usuarionuevo.php">Nuevo</a></div>
    <table>
        <tr>
            <td>N°</td>
            <td>Personal</td>
            <td>Usuario</td>
            <td>Opciones</td>
        </tr>

        <?php
            $sql = ' SELECT U.Codigo, P.ApellidoPaterno, P.ApellidoMaterno, P.Nombres, U.Nombre
            FROM personal P JOIN usuario U ON P.Codigo = U.CodigoPersonal
            ORDER BY P.ApellidoPaterno, P.ApellidoMaterno';
            try{
                require '../conectar.php';
                $datos = $conexion->query($sql);
                $i=1;
                echo '<a href="../index.php">Inicio</a>';
                foreach ($datos as $fila) {
                    echo '<tr>';
                    echo '<td>' . $i . '</td>';
                    echo '<td>' . $fila['ApellidoPaterno'] . ' ' . $fila['ApellidoMaterno'] . ' ' . 
                        $fila['Nombres'] . '</td>';
                    echo '<td>' . $fila['Nombre'] . '</td>';
                    echo '<td><a href="usuarioeditar.php?cod=' . $fila['Codigo'] . '">Editar</a></td>';
                    echo '<td><a href="eliminarUsuario.php?cod=' . $fila['Codigo'] .
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