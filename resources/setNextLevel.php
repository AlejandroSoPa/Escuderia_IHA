<?php
session_start();
echo "<script src='../crono.js'></script>";
echo "<script src='../questionsInteraction.js'></script>";
echo"<script src='../redirect.js'></script>";
if (isset($_POST['next'])) {
    $_SESSION['counter'] += 3;
    if ($_SESSION['counter'] == 18) {
        echo "<form action='../win.php' method='post'>";
            echo "<input type='number' id='inicio' name='inicio' value='' style='visibility:hidden;'></input>";
            echo "<input type='number' id='actual' name='actual' value='' style='visibility:hidden;'></input>";
            echo "<input type='text' id='crono' name='crono' value='' style='visibility:hidden;'></input>";
            echo "<input type='submit' id='game_won' name='game_won' value='' onclick='empezarDetener(this);' style='visibility:hidden;'></input>";
        echo "</form>";
        echo "<script> cleanLocalStorage(); </script>";
        echo "<script> showData(); </script>";
    } else {
        $_SESSION['level'] += 1;
        echo '<script>window.location.href = "../game.php";</script>';
    }
} else {
    echo "<script> cleanLocalStorage(); </script>";
    echo "<form action='../lose.php' method='post'>";
        echo "<input type='submit' id='game_lose' name='game_lose' value='' onclick='cleanLocalStorageTimer();' style='visibility:hidden;'></input>";
    echo "</form>";
}
?>