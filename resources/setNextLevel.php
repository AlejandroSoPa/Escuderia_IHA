<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <script src="../redirect.js"></script>
</head>

<?php
session_start();
if (isset($_POST['next'])) {
    $_SESSION['counter'] += 3;
    if ($_SESSION['counter'] == 18) {
        echo "<form action='../win.php' method='post'>";
        echo "<button id='game_won' name='game_won' value='1'";
        echo "</form>";
    } else {
        $_SESSION['level'] += 1;
        header("Location: ../game.php");
    }
}

?>
