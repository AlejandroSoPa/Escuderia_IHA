<?php
    session_start();
    include './resources/myFunctions.php';
    $rankingTittle = trans('rankingTittle', $_SESSION['lang']);
    $nameColumn = trans('nameColumn', $_SESSION['lang']);
    $pointsColumn = trans('pointsColumn', $_SESSION['lang']);
    $tempsColumn = trans('tempsColumn', $_SESSION['lang']);
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
</head>
<body>
    <?php echo "<h1>$rankingTittle</h1>"; ?>
    <div class="tableDiv">
        <?php
            echo "<table>
                    <thead>
                    <tr>
                        <th>$nameColumn</th>
                        <th>$pointsColumn</th>
                        <th>$tempsColumn</th>
                    </tr>
                    </thead>
                    <tbody>
                    "
            ;
            $file = fopen("records.txt", "r");
            $ranking = [];
            $contador = 0;
            while (!feof($file)) {
                $line = fgets($file);
                $users = explode(",", $line);
                if(!empty($users[0])) {
                    $ranking[$users[0]." ".$contador][] = $users[1];
                    $ranking[$users[0]." ".$contador][] = $users[2];
                    $contador++;
                }
            }
            arsort($ranking);
            foreach ($ranking as $order => $valor) {    
                $username = substr($order, 0, strpos($order," "));
                $last_publish = ((int)trim(substr($order,strpos($order," "),strlen($order))));
                echo "<tr>";
                if ($last_publish==$contador-1) {
                    echo "<td style='font-size: 30px;' bgcolor='#75c9a3';>$username</td>";
                    echo "<td style='font-size: 30px;' bgcolor='#75c9a3';>".$valor[0]."</td>";
                    echo "<td style='font-size: 30px;' bgcolor='#75c9a3';>".$valor[1]."</td>";
                } else {
                    echo "<td style='font-size: 30px;'>$username</td>";
                    echo "<td style='font-size: 30px;'>".$valor[0]."</td>";
                    echo "<td style='font-size: 30px;'>".$valor[1]."</td>";
                }
                echo "</tr>";
            }
            fclose($file);
            echo "</tbody>
                </table><br>";
        ?>
    </div>
    <div class="centered-link">
        <a class='rankingButton' href='/'><?php echo $backToStartButton; ?></a>
    </div>

</body>
</html>