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
            $file = fopen("records.txt", "r");
            $escribir = "";
            echo "<table border=1>
                    <thead>
                    <tr>
                        <th>Nom</th><!-- Cambiar por varible-->
                        <th>Cognom1</th><!-- Cambiar por varible-->
                    </tr>
                    </thead>
                    <tbody>
                    "
            ;
            while(true){
                $contenido = fgets($file);
                if($contenido){
                    $lista = explode(",", $contenido);
                    $escribir .= "$lista[0]#$lista[1]#$lista[2]#$lista[3]";
                    echo "
                        <tr>
                            <td>$lista[0]</td>
                            <td>$lista[1]</td>
                        </tr>
                    ";
                } else {
                    break;
                }
            }
            
            echo "</tbody></table>";
        ?>
    </div>
    <form action="index.php">
        <input id="btnIniciWin" visibility:visible type="submit" value="Tornar a l' inici"><!-- Cambiar por varible-->
    </form>
</body>
</html>