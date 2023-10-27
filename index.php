<?php
    session_start();
    include './resources/myFunctions.php';
    if (isset($_SESSION['counter'])) {
        unset($_SESSION['counter']);
        unset($_SESSION['level']);
    }
    if (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = 'cat';
    }

echo "<!DOCTYPE html>";
echo "<html lang='{$_SESSION['lang']}'>";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
</head>
<body>
    <div class="mainDiv">
    <?php   
        echo "  <header>\n";
        echo "  <form method='POST' action='./resources/setLanguage.php'>\n";
        echo "      <button type='submit' name='lang' value='en'><img src='./images/estados-unidos.png'></button>\n";
        echo "      <button type='submit' name='lang' value='es'><img src='./images/espana.png'></button>\n";
        echo "      <button type='submit' name='lang' value='cat'><img src='./images/catalonia.png'></button>\n";
        echo "  </form>\n";
        echo "  </header>\n";

        $welcomeMessage = trans('welcome', $_SESSION['lang']);
        $playButtonText = trans('playButton', $_SESSION['lang']);
        $rankingButtonText = trans('rankingButton', $_SESSION['lang']);
        $instructionsText = trans('instructions', $_SESSION['lang']);
        echo "  <h1 class='mainTitle'>$welcomeMessage</h1>\n";
        echo "  <a class='rankingButton' href='/ranking.php'>$rankingButtonText</a>\n";
        echo "  <a class='playButton' href='/game.php' onclick='empezarDetener(this);'>$playButtonText</a>\n";
        echo "  <p class='instructions'>$instructionsText</p>";
    ?>
    </div>
    <script src="crono.js"></script>
</body>
</html>
