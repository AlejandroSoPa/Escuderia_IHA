<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <script src="../crono.js"></script>
</head>
<body>
    <?php
        session_start();
        if (isset($_POST['next'])) {
            $_SESSION['counter'] += 3;
            if ($_SESSION['counter'] == 18) {
                echo "<form action='../win.php' method='post'>";
                    echo "<input type='number' id='inicio' name='inicio' value=''></input>";
                    echo "<input type='number' id='actual' name='actual' value=''></input>";
                    echo "<input type='text' id='crono' name='crono' value=''></input>";
                    echo "<input type='submit' id='game_won' name='game_won' value='' onclick='empezarDetener(this);'></input>";
                echo "</form>";
                echo "<script> showData(); </script>";
            } else {
                $_SESSION['level'] += 1;
                header("Location: ../game.php");
            }
        } else {
            echo "<form action='../lose.php' method='post'>";
                echo "<input type='submit' id='game_lose' name='game_lose' value='' onclick='empezarDetener(this);'></input>";
            echo "</form>";
        }
    ?>
    <script src="../redirect.js"></script>
</body>
<html>