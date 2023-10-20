<?php
if ($_SESSION['lang'] == 'es') {
}
$contenido = file_get_contents('questions/catalan_1.txt');
$lineas = explode("\n", $contenido);

$preguntas = [];
$pregunta_actual = null; //Variable para saber en que pregunta estoy

foreach ($lineas as $linea) {
    $linea = trim($linea); //Elimina espacios en blanco

    if (empty($linea)) {
        continue;
        //Verificar si la linea esta vacia, si esta vacia sigue con la siguiente iteración
    }

    if (strpos($linea, '+ ') === 0 || strpos($linea, '- ') === 0) { //Comprueba el primer caracter, para saber si se trata de una respuesta 
        $pregunta_actual['respuestas'][] = substr($linea, 2); // Esta parte del código accede al array asociativo $pregunta_actual y específicamente al elemento 'respuestas'. La clave 'respuestas' se utiliza para almacenar las respuestas de la pregunta actual. 
    } else { // Si el primer caracter que encuentra en cada linea no es '+' ni '-', asume que ha llegado a la siguiente pregunta
        if (!empty($pregunta_actual)) {
            $preguntas[] = $pregunta_actual;
        }
        $pregunta_actual = ['pregunta' => $linea, 'respuestas' => []];
    }
}
shuffle($preguntas);
$preguntasAleatorias = array_slice($preguntas, 0, 3);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>GAME</h1>

    <div class="question" id="question1">
        <h2><?php echo $preguntasAleatorias[0]['pregunta']; ?></h2>
        <ul>
            <?php foreach ($preguntasAleatorias[0]['respuestas'] as $respuesta) : ?>
                <li><?php echo $respuesta; ?></li>
            <?php endforeach; ?>
        </ul>
        <br>
    </div>

    <div class="questionHidden" id="question2">
        <h2><?php echo $preguntasAleatorias[1]['pregunta']; ?></h2> 
        <ul>
            <?php foreach ($preguntasAleatorias[1]['respuestas'] as $respuesta) : ?>
                <li><?php echo $respuesta; ?></li>
            <?php endforeach; ?>
        </ul>
        <br>
    </div>

    <div class="questionHidden" id="question3">
        <h2><?php echo $preguntasAleatorias[2]['pregunta']; ?></h2>
        <ul>
            <?php foreach ($preguntasAleatorias[2]['respuestas'] as $respuesta) : ?>
                <li><?php echo $respuesta; ?></li>
            <?php endforeach; ?>
        </ul>
        <br>
    </div>

    <button>Següents preguntes</button>
    <form action="index.php">
        <input type="submit" value="Tornar a l' inici">
    </form>
</body>

</html>