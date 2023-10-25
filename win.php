<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <script src="manageButtons.js"></script>
</head>

<body>
    <audio autoplay>
        <source src="audio/exit.mp3" type="audio/mpeg">
    </audio>
    <?php
        echo "<h1>Felicidades! Has Ganadado</h1> <!-- Cambiar por varible-->";
    ?>
    <button id="publish" onclick="document.getElementById('aviso').setAttribute('data-on','on')">Publicar</button> 
    <div class="panel" id="aviso" data-on="off" onclick="this.setAttribute('data-on','on')">  
        <div>
            <?php
                echo"<form action='' method='post'>";
                    echo"<p>Introduce tu nombre</p> <!-- Cambiar por varible-->";
                    echo"<input type='text' name='name' id='name' cols='54' rows='5' required></input><br>";
                    echo"<input type='number' name='point' id='point' cols='40' rows='5' style='display: none;' value='18'></input>";
                    echo"<br><input type='submit'>";
                echo"</form>";
                session_start();
                $texto = preg_replace('/\s+/', "", $_POST["name"]);
                if (isset($texto)) {
                    //Código de validación de datos
                    file_put_contents("records.txt", 
                    file_get_contents("records.txt").trim($texto).",".$_POST["point"].",".session_id()."\n");
                    session_destroy();
                }
            ?>
        </div>
    </div>
    <form action="index.php">
        <input id="btnIniciWin" visibility:visible type="submit" value="Tornar a l' inici"><!-- Cambiar por varible-->
    </form>
    <form action="ranking.php">
        <input id="btntRanking" visibility:visible type="submit" value="Pantalla Ranking"><!-- Cambiar por varible-->
    </form>
</body>

</html>