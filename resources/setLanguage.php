<?php
if (isset($_POST['lang'])) {
        $selectedLanguage = $_POST['lang'];
    
        $_SESSION['lang'] = $selectedLanguage;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>