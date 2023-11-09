<?php
    session_start();
    include './resources/myFunctions.php';
    $loseTitle = trans('loseTitle', $_SESSION['lang']);
    $backToStartButton = trans('backToStartButton', $_SESSION['lang']);
    $loseRanking = trans('loseRanking', $_SESSION['lang']);
    $lose = trans('lose', $_SESSION['lang']);

echo "<!DOCTYPE html>";
echo "<html lang='{$_SESSION['lang']}'>";

echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<title>$lose</title>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Kanit'>";
    echo "<link rel=\"icon\" href=\"./images/question-icon.svg\" type=\"image/png\">";
echo "</head>";
    
    echo "<body>";
    if (!isset($_POST["game_lose"])) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        echo "<div class='autocenter'><a class='standardA' href='/'>$backToStartButton</a></div>";
        exit;

    } else {
        echo"<audio autoplay>";
            echo"<source src='audio/GameOver.mp3' type='audio/mpeg'>";
        echo"</audio>";
        echo "<div class='autocenter'>";
        echo "<h1>$loseTitle</h1>";
        echo "<div class='buttonsWinContainer'><a class='rankingButton' href='/'>$backToStartButton</a>";
        echo "<a class='rankingButton' href='/ranking.php'>$loseRanking</a></div>";
        echo "</div>";
    }
    ?>
</body>

</html>