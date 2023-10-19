<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="autocenter">
    <?php
        session_start();
        include './resources/myFunctions.php';
        if (!isset($_SESSION['lang'])) {
            $_SESSION['lang'] = 'cat';
        }
        
        echo "  <header>";
        echo "  <form method='POST' action='./resources/setLanguage.php'>";
        echo "      <button type='submit' name='lang' value='en'><img src='./images/estados-unidos.png'></button>";
        echo "      <button type='submit' name='lang' value='es'><img src='./images/espana.png'></button>";
        echo "      <button type='submit' name='lang' value='cat'><img src='./images/catalonia.png'></button>";
        echo "  </form>";
        echo "  </header>";

        $welcomeMessage = trans('welcome', $_SESSION['lang']);
        echo "  <h1>$welcomeMessage</h1>";
        $asd = $_SESSION['lang'];
        echo "<h4>$asd</h4>";
    ?>
    </div>
</body>
</html>