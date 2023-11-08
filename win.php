<?php
    session_start();
    include './resources/myFunctions.php';
    $win = trans('win', $_SESSION['lang']);
    $winTitle = trans('winTitle', $_SESSION['lang']);
    $publishTitle = trans('publishTitle', $_SESSION['lang']);
    $popUpTitle = trans('popUpTitle', $_SESSION['lang']);
    $popUpTime = trans('popUpTime', $_SESSION['lang']);
    $backToStartButton = trans('backToStartButton', $_SESSION['lang']);
    $winRanking = trans('winRanking', $_SESSION['lang']);
    $winFeedback = trans('winFeedback', $_SESSION['lang']);

echo "<!DOCTYPE html>";
echo "<html lang='{$_SESSION['lang']}'>";

echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>$win</title>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Kanit'>";
    echo "<link rel=\"icon\" href=\"./images/question-icon.svg\" type=\"image/png\">";
echo "</head>";

echo "<body>";

    if (!isset($_POST["game_won"])) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>
            <a class='rankingButton' href='/index.php'>$backToStartButton</a>";
        exit;
    } else {
        echo"<audio autoplay>";
            echo"<source src='audio/exit.mp3' type='audio/mpeg'>";
        echo"</audio>";
        echo"<h1>$winTitle</h1>";
        ?>
        <button id="publish" onclick="document.getElementById('aviso').setAttribute('data-on','on')" class='rankingButton'><?php echo $publishTitle; ?></button><br>
        <div class="panel" id="aviso" data-on="off" onclick="this.setAttribute('data-on','on')">
            <div>
                <?php
                    echo"<form action='' method='post'>";
                        echo"<p>".$popUpTitle."</p>";
                        echo"<input type='text' name='name' id='name' required></input><br>";
                        $diff = $_POST["actual"] - $_POST["inicio"];
                        if($diff<=60000){
                            $puntos = (120000-$diff)*2 + 18;
                            echo"<input type='number' name='point' id='point' style='display: none;' value='$puntos'></input><br>";
                        } elseif($diff<=120000){
                            $puntos = (120000-($diff/2)) + 18;
                            echo"<input type='number' name='point' id='point' style='display: none;' value='$puntos'></input><br>";
                        } elseif($diff<=180000){
                            $puntos = (180000-$diff) + 18;
                            echo"<input type='number' name='point' id='point' style='display: none;' value='$puntos'></input><br>";
                        } else{
                            echo"<input type='number' name='point' id='point' style='display: none;' value='18'></input><br>";
                        }
                        $crono = $_POST["crono"];
                        echo"<p>".$popUpTime."</p>";
                        echo"<input id='crono' name='crono' value='$crono' readonly></input><br>";
                        echo"<input type='text' id='game_won' name='game_won' style='display: none;'></input>";
                        echo"<br><input type='submit' value='$publishTitle'>";
                    echo"</form>";

                    $censura = file("censura.txt");
                    if (isset($_POST["name"])) {
                        $texto = preg_replace('/\s+/', "", $_POST["name"]);
                        if(isset($texto)){
                            $validar = true;
                            for ($i = 0; $i < count($censura); $i++) {
                                if (str_contains($censura[$i], $texto)) {
                                    $validar = false;
                                    break;
                                }
                            }
                            if ($validar) {
                                file_put_contents("records.txt", 
                                file_get_contents("records.txt")."\n".trim($texto).",".$_POST["point"].",".$_POST["crono"].",".session_create_id());
                                $lenguaje = $_SESSION['lang'];
                                session_destroy();
                                session_start();
                                $_SESSION['lang'] = $lenguaje;
                            } else {
                                unset($_POST["name"])
                                ?>
                                    <script>
                                        window.alert("El nombre introducido no es apropiado, porfavor elige otro")
                                    </script>
                                <?php
                            }
                            
                        }
                    }
            echo "</div>
        </div>
        <br><br>
        <a class='rankingButton' href='/index.php'>$backToStartButton</a>
        <a id='ranking1' class='rankingButton' href='/ranking.php'>$winRanking</a>
        <h2 id='winFeedback'>$winFeedback</h2>
        ";
        }
        if (isset($_POST["name"])) {
            ?>
            <script>
                document.getElementById('publish').disabled = true;
                document.getElementById('winFeedback').style.visibility = "visible";
            </script>
            <?php
        }
        ?>
</body>

</html>