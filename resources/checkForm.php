<?php
    session_start();
    if(!isset($_POST['questionLang']) || !isset($_POST['questionLevel']) || !isset($_POST['question']) || !isset($_POST['correctAnswer']) 
    || !isset($_POST['incorrectAnswer1']) || !isset($_POST['incorrectAnswer2']) || !isset($_POST['incorrectAnswer3'])) {
        // devolver un feedback de rellenar todos los datos
        $_SESSION['formFeedback'] = "Si us plau omple tots els camps";
        header("Location: create.php");
    }
?>