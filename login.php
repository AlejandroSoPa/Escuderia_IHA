<?php
session_start();
include './resources/myFunctions.php';
$userName = trans('username', $_SESSION['lang']);
$passWord = trans('password', $_SESSION['lang']);
$btnSubmit = trans('submit', $_SESSION['lang']);
$feedbackNotLog = trans('feedbackNotLog', $_SESSION['lang']);
$logIn = trans('login', $_SESSION['lang']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Log in</title>
    <script>
        function mostrarFeedback() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            // Leer el contenido del archivo JSON
            fetch("logs.json")
                .then(response => response.json())
                .then(data => {
                    var credencialesValidas = false;

                    // Iterar a través de los usuarios y comparar las credenciales
                    data.usuarios.forEach(function(user) {
                        if (user.username === username && user.password === password) {
                            // Las credenciales coinciden, usuario autenticado
                            credencialesValidas = true;
                            window.location.href = "create.php";
                        }
                    });

                    if (!credencialesValidas) {
                        // Las credenciales no coinciden, muestra el mensaje de feedback
                        var feedbackDiv = document.getElementById("feedbackLog");
                        feedbackDiv.innerHTML = '<?php echo $feedbackNotLog; ?>';
                        feedbackDiv.style.display = 'block'; // Mostrar la clase feedbackLog
                    }
                })
                .catch(error => {
                    console.error("Error al cargar el archivo JSON: " + error);
                });
        }
    </script>
</head>

<body>
    <div class="log">
        <h2><?php echo $logIn ?></h2>
        <form method="post" onsubmit="event.preventDefault(); mostrarFeedback();">
            <div class="username">
                <label for="username"><?php echo $userName ?>:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <br><br>
            <div class="pswd">
                <label for="password"><?php echo $passWord ?>:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <br><br>
            <button id="btnLog" type="submit"><?php echo $btnSubmit ?></button>
        </form>
        <div class="feedbackLog" id="feedbackLog" style="display: none;"></div>
    </div>
</body>

</html>
