<?php
session_start();
include './resources/JsNotEnable.php';
include './resources/myFunctions.php';
if (isset($_SESSION['counter'])) {
    unset($_SESSION['counter']);
    unset($_SESSION['level']);
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'cat';
}
unset($_SESSION['login']);
echo "<!DOCTYPE html>";
echo "<html lang='{$_SESSION['lang']}'>";
$logIn = trans('login', $_SESSION['lang']);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
    <script src="questionsInteraction.js"></script>
</head>

<body>
    <noscript>
        <div id="JSdisabled" class="JSdisabled">
            <?php
                //Mensaje de error, JS no esta habilitado en el navegador
                $JsNotEnableMessage = trans('jsNone', $_SESSION['lang']);
                $jsNotEnable = CheckJsEnable($JsNotEnableMessage);
                echo "<h4 class='JSdisabled_title'>".$jsNotEnable."</h4>";
            ?>
        </div>
    </noscript>
    <div class="mainDiv">
        <?php
            echo "  <header>\n";
            echo "  <form method='POST' action='./resources/setLanguage.php'>\n";
            echo "      <button type='submit' name='lang' value='en'><img src='./images/estados-unidos.png'></button>\n";
            echo "      <button type='submit' name='lang' value='es'><img src='./images/espana.png'></button>\n";
            echo "      <button type='submit' name='lang' value='cat'><img src='./images/catalonia.png'></button>\n";
            echo "  </form>\n";
            echo "  <form method='POST' action='./login.php'>\n";
            echo "      <button type='submit' name='log' id='log'>$logIn</button>\n";
            echo "  </form>";
            echo "  </header>\n";

            $welcomeMessage = trans('welcome', $_SESSION['lang']);
            $playButtonText = trans('playButton', $_SESSION['lang']);
            $rankingButtonText = trans('rankingButton', $_SESSION['lang']);
            $instructionsText = trans('instructions', $_SESSION['lang']);
            $easterEgg = trans('easterEgg', $_SESSION['lang']);
            echo "  <h1 class='mainTitle'>$welcomeMessage</h1>\n";
            echo "  <a class='rankingButton' href='/ranking.php'>$rankingButtonText</a>\n";
            echo "  <a class='playButton' href='/game.php' onclick='empezarDetener(this);'>$playButtonText</a>\n";
            echo "  <p class='instructions'>$instructionsText</p>";
            echo "<script> cleanLocalStorage(); </script>";
            echo "<button id='easter' onclick=\"document.getElementById('easterEgg').setAttribute('data-on','on')\"></button><br>";
            echo "<div class='panel' id='easterEgg' data-on='off' onclick=\"this.setAttribute('data-on','off')\">";
                echo "<div>";
                    echo "<p>$easterEgg<p>";
                    echo "<img src='./images/gatos-bailando.gif'>";
                echo "</div>";
            echo "</div>";
        ?>
    </div>
    
    <script src="crono.js"></script>
</body>

</html>