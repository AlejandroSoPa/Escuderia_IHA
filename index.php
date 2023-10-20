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
        
        echo "  <header>\n";
        echo "  <form method='POST' action='./resources/setLanguage.php'>\n";
        echo "      <button type='submit' name='lang' value='en'><img src='./images/estados-unidos.png'></button>\n";
        echo "      <button type='submit' name='lang' value='es'><img src='./images/espana.png'></button>\n";
        echo "      <button type='submit' name='lang' value='cat'><img src='./images/catalonia.png'></button>\n";
        echo "  </form>\n";
        echo "  </header>\n";

        $welcomeMessage = trans('welcome', $_SESSION['lang']);
        echo "  <h1>$welcomeMessage</h1>";
    ?>
    </div>
</body>
</html><!DOCTYPE html>
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
        
        echo "  <header>\n";
        echo "  <form method='POST' action='./resources/setLanguage.php'>\n";
        echo "      <button type='submit' name='lang' value='en'><img src='./images/estados-unidos.png'></button>\n";
        echo "      <button type='submit' name='lang' value='es'><img src='./images/espana.png'></button>\n";
        echo "      <button type='submit' name='lang' value='cat'><img src='./images/catalonia.png'></button>\n";
        echo "  </form>\n";
        echo "  </header>\n";

        $welcomeMessage = trans('welcome', $_SESSION['lang']);
        echo "  <h1>$welcomeMessage</h1>";
    ?>
    </div>
</body>
</html>
