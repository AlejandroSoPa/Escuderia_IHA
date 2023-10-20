<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        @charset "utf-8";
        .panel{
            position: absolute;
            top:0;
            left:0;
            display:flex;
            justify-content: center;
            align-items: center;
            height:100%;
            width: 100%;
            transition: transform 300ms;
            z-index:-1;
        }
        .panel div{ 
            display:flex;
            flex-direction:column;
            justify-content: center;
            align-items: center;
            background: beige;
            width: 400px;
            height:400px;
            z-index:1000;
        }
        .panel[
            data-on='on'
        ] {transform: scale(1);}.panel[data-on='off']{transform: scale(0);}
    </style>
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
        <input id="btnInici" type="submit" value="Tornar a l' inici">
    </form>
</body>
</html>
