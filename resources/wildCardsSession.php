<?php
session_start();

if(isset($_POST['publicWildcard'])){
    $_SESSION['publicWildcard'] = $_POST['publicWildcard'];
} else {
    echo "No se proporcionó un nuevo valor.";
}
?>