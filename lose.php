<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <audio autoplay>
        <source src="audio/GameOver.mp3" type="audio/mpeg">
    </audio>
    <?php
    echo "<h1>Game Over</h1> <!-- Cambiar por varible-->";
    ?>
    <form action="index.php">
        <input id="btnIniciWin" visibility:visible type="submit" value="Tornar a l' inici"><!-- Cambiar por varible-->
    </form>
    <form action="ranking.php">
        <input id="btntRanking" visibility:visible type="submit" value="Pantalla Ranking"><!-- Cambiar por varible-->
    </form>
</body>

</html>