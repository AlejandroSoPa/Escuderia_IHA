<?php
session_start();
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}
if ($_SESSION['lang'] == 'cat') {
    $fileRoute = 'questions/catalan_1.txt';
}
elseif ($_SESSION['lang'] == 'es') {
    $fileRoute = 'questions/spanish_1.txt';
} 
elseif ($_SESSION['lang'] == 'en')  {
    $fileRoute = 'questions/english_1.txt';
}

$contenido = file_get_contents($fileRoute);
//$texto_procesado = preg_replace('/[ \t\n]+/', '', $contenido);
$texto_procesado = preg_replace('/[ \t]+/', ' ', $contenido); // Reemplaza múltiples espacios o tabulaciones con un solo espacio
$texto_procesado = preg_replace('/\s*\n\s*/', "\n", $texto_procesado); // Elimina saltos de línea fuera de lugar
$lineas = explode("\n", $texto_procesado);

$preguntas = [];
$pregunta_actual = null; //Variable para saber en que pregunta estoy

foreach ($lineas as $linea) {
    $linea = trim($linea, " \n"); //Elimina espacios en blanco
    if (empty($linea)) {
        continue;
        //Verificar si la linea esta vacia, si esta vacia sigue con la siguiente iteración
    }

    if (strpos($linea, '+') === 0 || strpos($linea, '-') === 0) { //Comprueba el primer caracter, para saber si se trata de una respuesta
        if ($linea[1] != " ") { // Si no hay un espacio en en carater 1 de la string se añadira 1. Luego facilitara la impresion de las respuestas
            $parte1 = substr($linea, 0, 1);
            $parte2 = substr($linea, 1);
            $linea = $parte1." ".$parte2;
        }
        $pregunta_actual['respuestas'][] = $linea; // Esta parte del código accede al array asociativo $pregunta_actual y específicamente al elemento 'respuestas'. La clave 'respuestas' se utiliza para almacenar las respuestas de la pregunta actual. 
    } else { // Si el primer caracter que encuentra en cada linea no es '+' ni '-', asume que ha llegado a la siguiente pregunta
        if (!empty($pregunta_actual)) {
            $preguntas[] = $pregunta_actual;
        }
        $pregunta_actual = ['pregunta' => $linea=substr($linea, 2), 'respuestas' => []];
    }
}

shuffle($preguntas);
$preguntasAleatorias = array_slice($preguntas, 0, 3);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
</head>

<body>
    <h1>GAME</h1>

    <div class="question" id="question1">
        <h2><?php echo $preguntasAleatorias[0]['pregunta']; ?></h2>
        <form id="form1">
            <ul>
                <?php foreach ($preguntasAleatorias[0]['respuestas'] as $respuesta) : ?>
                    <li>
                        <input type="radio" name="respuesta1" value="<?php echo $respuesta; ?>" autocomplete="off" class="answer1"><?php echo $respuesta = substr($respuesta, 2); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <br>
        </form>
        <div id="feedback1"></div>
    </div>

    <div class="questionHidden" id="question2">
        <h2><?php echo $preguntasAleatorias[1]['pregunta']; ?></h2>
        <form id="form2">
            <ul>
                <?php foreach ($preguntasAleatorias[1]['respuestas'] as $respuesta) : ?>
                    <li>
                        <input type="radio" name="respuesta2" value="<?php echo $respuesta; ?>" autocomplete="off" class="answer2"><?php echo $respuesta = substr($respuesta, 2); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <br>
        </form>
        <div id="feedback2"></div>
    </div>

    <div class="questionHidden" id="question3">
        <h2><?php echo $preguntasAleatorias[2]['pregunta']; ?></h2>
        <form id="form3">
        <ul>
            <?php foreach ($preguntasAleatorias[2]['respuestas'] as $respuesta) : ?>
                <li>
                    <input type="radio" name="respuesta3" value="<?php echo $respuesta; ?>" autocomplete="off" class="answer3"><?php echo $respuesta = substr($respuesta, 2); ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <br>
        </form>
        <div id="feedback3"></div>
    </div>

    <form action="game.php">
        <input id="buttonNext" type="submit" value="Següent">
    </form>
    <form action="index.php">
        <input id="btnInici" type="submit" value="Tornar a l' inici">
    </form>


    <script src="script.js"></script>
</body>

</html>