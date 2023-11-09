<?php
session_start();
include './resources/myFunctions.php';
$userName = trans('username', $_SESSION['lang']);
$passWord = trans('password', $_SESSION['lang']);
$btnSubmit = trans('submit', $_SESSION['lang']);
$feedbackNotLog = trans('feedbackNotLog', $_SESSION['lang']);
$logIn = trans('login', $_SESSION['lang']);
$backToStartButton = trans('backToStartButton', $_SESSION['lang']);
unset($_SESSION['login']);

$feedbackVisible = "hidden";


$file = fopen("admin.txt", "r");
$usuarios = [];
while (!feof($file)) {
    $line = fgets($file);
    $admins = explode(",", $line);
    if(!empty($admins[0])) {
        $usuarios[$admins[0]]= $admins[1];
    }
}
if(isset($_POST["username"])){
    foreach ($usuarios as $order => $valor) { 
        if($_POST["username"]==$order && $_POST["password"]==$valor){
            $_SESSION["login"] = "correcto";
            header("Location:./create.php");
        } else{
            $feedbackVisible = "visible";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo $logIn ?></title>
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
    
</head>

<body>
    <div class="log">
        <h2><?php echo $logIn ?></h2>
        <form method="POST" action="">
            <label for="username"><?php echo $userName; ?>:</label>
            <input type="text" id="username" name="username" required>
            <br><br>
            <label for="password"><?php echo $passWord; ?>:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <button id="btnLog" type="submit"><?php echo $btnSubmit; ?></button>
        </form>
        <div class="feedbackLog" id="feedbackLog" style="visibility:<?php echo $feedbackVisible; ?>"><?php echo $feedbackNotLog; ?></div>
    </div>
    <div class="autocenter"><?php echo "<a class='rankingButton' id='loginToIndex' href='/index.php'>$backToStartButton</a>"; ?></div> 
</body>

</html>
