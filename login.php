<?php
session_start();
include './resources/myFunctions.php';
$userName = trans('username', $_SESSION['lang']);
$passWord = trans('password', $_SESSION['lang']);
$btnSubmit = trans('submit', $_SESSION['lang']);
$feedbackNotLog = trans('feedbackNotLog', $_SESSION['lang']);
$logIn = trans('login', $_SESSION['lang']);
$feedbackMessage = ''; // Variable para almacenar el feedback

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Leer el contenido del archivo JSON
    $usuariosJSON = file_get_contents("logs.json");
    $usuarios = json_decode($usuariosJSON, true);

    // Inicializar una variable para indicar si se encontraron credenciales válidas
    $credencialesValidas = false;

    // Iterar a través de los usuarios y comparar las credenciales
    foreach ($usuarios["usuarios"] as $user) {
        if ($user["username"] === $username && $user["password"] === $password) {
            // Las credenciales coinciden, usuario autenticado
            $credencialesValidas = true;
            header("Location: create.php");
            exit;
        }
    }

    // Verificar si se encontraron credenciales válidas
    if (!$credencialesValidas) {
        $feedbackMessage = $feedbackNotLog;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Log in</title>
</head>

<body>
    <div class="log">
        <h2><?php echo $logIn ?></h2>
        <form method="post">
            <div class="username">
                <label for="username"><?php echo $userName ?>:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <br><br>
            <div class="pswd">
                <label for "password"><?php echo $passWord ?>:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <br><br>
            <button id="btnLog" type="submit"><?php echo $btnSubmit ?></button>
        </form>
        <div class="feedbackLog">
            <?php echo $feedbackMessage; ?>
        </div>
    </div>
</body>

</html>
