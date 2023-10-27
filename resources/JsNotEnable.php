<?php
function CheckJsEnable($message) {
    $output = "<noscript>\n";
    $output .= "    <div class='deshabilitado'>\n";
    $output .= "        $message";
    $output .= "        <a href='http://www.enable-javascript.com/es/' target='_blank'>aquí</a>.\n";
    $output .= "    </div>\n";
    $output .= "</noscript>\n";

    return $output;
}

