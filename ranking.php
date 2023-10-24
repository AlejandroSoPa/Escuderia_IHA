<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php
        echo "<h1>Ranking</h1> <!-- Cambiar por varible-->";
    ?>
    <div>
        <?php
            
            // Función para ordenar el array por el segundo valor (entero)
            function ordenarPorSegundoValor($a, $b) {
                return $a[0] - $b[0];
            }
            echo "<table border=1>
                    <thead>
                    <tr>
                        <th>Nombre</th><!-- Cambiar por varible-->
                        <th>Puntuacion</th><!-- Cambiar por varible-->
                    </tr>
                    </thead>
                    <tbody>
                    "
            ;
            $file = fopen("records.txt", "r");
            $ranking = [];
            while (!feof($file)) {
                $line = fgets($file);
                $users = explode(",", $line);
                $ranking[$users[0]." ".$users[1]] = $users[1];
            }
            arsort($ranking);
            foreach ($ranking as $order => $valor) {    
                echo "<tr>
                        <td>".substr($order,0,strlen($order)-2)."</td> 
                        <td>".$valor."</td>
                     </tr>";
            }
            fclose($file);

            
            echo "</tbody></table><br>";
        ?>
    </div>
    <form action="index.php">
        <input id="btnIniciWin" visibility:visible type="submit" value="Tornar a l' inici"><!-- Cambiar por varible-->
    </form>
</body>
</html>