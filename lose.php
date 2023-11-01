<?php
    session_start();
    include './resources/myFunctions.php';
    $loseTitle = trans('loseTitle', $_SESSION['lang']);
    $backToStartButton = trans('backToStartButton', $_SESSION['lang']);
    $loseRanking = trans('loseRanking', $_SESSION['lang']);
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
    if (!isset($_POST["game_lose"])) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>";
        ?>
        <form action='index.php'>
            <input id='btnIniciWin' visibility:visible type='submit' value="<?php echo $backToStartButton; ?>">
        </form>
        <?php
        exit;
    } else {
        echo"<audio autoplay>";
            echo"<source src='audio/GameOver.mp3' type='audio/mpeg'>";
        echo"</audio>";
        echo "<h1>$loseTitle</h1>";
        ?>
        <form action='index.php'>
            <input id='btnIniciWin' visibility:visible type='submit' value="<?php echo $backToStartButton; ?>">
        </form>
        <form action='ranking.php'>
            <input id='btntRanking' visibility:visible type='submit' value='<?php echo $loseRanking; ?>'>
        </form>
    <?php
    }
    ?>
</body>

</html>