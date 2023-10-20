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
        echo "<h1>Felicidades! Has Ganadado</h1> <!-- Cambiar por varible-->";
    ?>
    <button onclick="document.getElementById('aviso').setAttribute('data-on','on')">Publicar</button> 
    <div class="panel" id="aviso" data-on="off" onclick="this.setAttribute('data-on','on')">  
        <div>
            <?php
                echo"<form action='' method='post'>";
                    echo"<p>Introduce tu nombre</p>";
                    echo"<textarea name='name' id='name' cols='54' rows='5'></textarea>";
                    echo"<input type='number' name='point' id='point' cols='40' rows='5' style='display: none;' value='18'></input>";
                    echo"<input type='submit'>";
                echo"</form>";
            
                session_start();
                file_put_contents("records.txt", 
                    file_get_contents("records.txt").$_POST["name"].",".$_POST["point"].",".session_id()."\n");
            ?>
        </div>
    </div>
    <form action="index.php">
        <input id="btnIniciWin" visibility:visible type="submit" value="Tornar a l' inici">
    </form>
</body>
</html>
