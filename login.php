<?php
    session_start();
    include './resources/myFunctions.php';
    $userName = trans('username', $_SESSION['lang']);
    $passWord = trans('password', $_SESSION['lang']);
    $btnSubmit= trans('submit', $_SESSION['lang']);
    $feedbackNotLog= trans('feedbackNotLog', $_SESSION['lang']);
    $logIn= trans('login', $_SESSION['lang']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
    <div>
        <h2><?php echo $logIn ?></h2>
        <form method="post">
            <label for="username"><?php echo $userName ?>:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password"><?php echo $passWord ?>:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button type="submit"><?php echo $btnSubmit ?></button>
        </form>
    </div>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Leer el contenido del archivo JSON
    $usuariosJSON = file_get_contents("logs.json");
    $usuarios = json_decode($usuariosJSON, true);

    // Iterar a través de los usuarios y comparar las credenciales
    foreach ($usuarios["usuarios"] as $user) {
        if ($user["username"] === $username && $user["password"] === $password) {
            // Las credenciales coinciden, usuario autenticado
            header("Location: create.php");
            exit;
        }
        else {
            echo $feedbackNotLog;
        }
    }

    // Las credenciales no coinciden, usuario no autenticado
}
?>