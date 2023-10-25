<?php
function trans($key, $lang) {
    $translations = include __DIR__ . "/../resources/lang/$lang.php";
    return $translations[$key] ?? $key;
}


?>