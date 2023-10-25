<?php
    session_start();
    include './resources/myFunctions.php';
    $rankingTittle = trans('rankingTittle', $_SESSION['lang']);
    $nameColumn = trans('nameColumn', $_SESSION['lang']);
    $pointsColumn = trans('pointsColumn', $_SESSION['lang']);
    $backToStartButton = trans('backToStartButton', $_SESSION['lang']);


echo "<!DOCTYPE html>";
echo "<html lang='{$_SESSION['lang']}'>";
?>
<head>
    <?php echo "<title>$rankingTittle</title>"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
</head>
<body>
    <?php echo "<h1>$rankingTittle</h1>"; ?>
    <div class="mainDiv">
        <?php
            echo "<table border=1>
                    <thead>
                    <tr>
                        <th>$nameColumn</th>
                        <th>$pointsColumn</th>
                    </tr>
                    </thead>
                    <tbody>
                    "
            ;
            $file = fopen("records.txt", "r");
            $ranking = [];
            while (!feof($file)) {
                $line = fgets($file);
                $users = explode(",", $line);
                $ranking[$users[0]." ".$users[1]] = $users[1];
            }
            arsort($ranking);
            foreach ($ranking as $order => $valor) {    
                echo "<tr>
                        <td>".substr($order,0,strlen($order)-2)."</td> 
                        <td>".$valor."</td>
                     </tr>";
            }
            fclose($file);
            echo "</tbody></table><br>";
        ?>
    </div>
    <form action="index.php">
        <input id="btnIniciWin" visibility:visible type="submit" value="<?php echo "$backToStartButton"; ?>">
    </form>
</body>
</html>