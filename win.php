<?php
    session_start();
    include './resources/myFunctions.php';
    $winTitle = trans('winTitle', $_SESSION['lang']);
    $publishTitle = trans('publishTitle', $_SESSION['lang']);
    $popUpTitle = trans('popUpTitle', $_SESSION['lang']);
    $winInicio = trans('winInicio', $_SESSION['lang']);
    $winRanking = trans('winRanking', $_SESSION['lang']);
?>
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
    if (!isset($_POST["game_won"])) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "<form action='index.php'>
                  <input id='btnIniciWin' visibility:visible type='submit' value='$winInicio'>
              </form>";
        exit;
    } else {
        echo"<audio autoplay>";
            echo"<source src='audio/exit.mp3' type='audio/mpeg'>";
        echo"</audio>";
        echo "<h1>$winTitle</h1>";
    ?>
    <button id="publish" onclick="document.getElementById('aviso').setAttribute('data-on','on')"><?php echo $publishTitle; ?></button><br>
    <div class="panel" id="aviso" data-on="off" onclick="this.setAttribute('data-on','on')">  
        <div>
            <?php
                echo"<form action='' method='post'>";
                    echo"<p>".$popUpTitle."</p>";
                    echo"<input type='text' name='name' id='name' cols='54' rows='5' required></input><br>";
                    echo"<input type='number' name='point' id='point' cols='40' rows='5' style='display: none;' value='18'></input>";
                    echo"<br><input type='submit' value='$publishTitle'>";
                echo"</form>";
                
                
                if (isset($_POST["name"])) {
                    $texto = preg_replace('/\s+/', "", $_POST["name"]);
                    if(isset($texto)){
                        //Código de validación de datos
                        file_put_contents("records.txt", 
                        file_get_contents("records.txt").trim($texto).",".$_POST["point"].",".session_id()."\n");
                        session_destroy();
                    }
                }
            ?>
        </div>
    </div>
    <?php
        echo"
        <form action='index.php'>
            <input id='btnIniciWin' visibility:visible type='submit' value='$winInicio'>
        </form>
        <form action='ranking.php'>
            <input id='btntRanking' visibility:visible type='submit' value='$winRanking'>
        </form>";
    }
    if(isset($_POST["name"])){
        header("Location:http://localhost:8080/");
    }
    ?>
    <script src="questionsInteraction.js"></script>
</body>

</html>