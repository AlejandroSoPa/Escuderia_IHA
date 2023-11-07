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
</head>

<body>
    <div class="log">
        <h2><?php echo $logIn ?></h2>
        <form id="loginForm">
            <div class="username">
                <label for="username"><?php echo $userName ?></label>
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
        <div class="feedbackLog" id="feedbackLog"></div>
    </div>

    <script>
        var feedbackNotLog = <?php echo json_encode($feedbackNotLog); ?>;
        document.getElementById("loginForm").addEventListener("submit", function (event) {
            event.preventDefault(); // Evita que se envíe el formulario

            // Obtén las credenciales ingresadas
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            // Realiza una solicitud AJAX para cargar los datos de un archivo JSON
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "logs.json", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var jsonData = JSON.parse(xhr.responseText);

                    // Comprueba las credenciales con los datos del archivo JSON
                    var credencialesCorrectas = false;
                    for (var i = 0; i < jsonData.usuarios.length; i++) {
                        if (jsonData.usuarios[i].username === username && jsonData.usuarios[i].password === password) {
                            credencialesCorrectas = true;
                            break;
                        }
                    }

                    if (credencialesCorrectas) {
                        // Credenciales correctas, redirige a "create.php"
                        window.location.href = "create.php";
                    } else {
                        // Credenciales incorrectas, muestra el mensaje de feedback
                        var feedbackLog = document.getElementById("feedbackLog");
                        feedbackLog.innerHTML = feedbackNotLog; //
                    }
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>
