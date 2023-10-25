<?php
session_start();

if (isset($_POST['next'])) {
    $_SESSION['counter'] += 3;
    if ($_SESSION['counter'] == 18) {
        header("Location: ../win.php");
    } else {
        $_SESSION['level'] += 1;
        header("Location: ../game.php");
    }
}
?>
