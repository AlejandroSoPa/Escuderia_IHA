<?php
/*if ($_SESSION['lang'] == 'es') {
}*/
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
        $pregunta_actual['respuestas'][] = substr($linea, 0); // Esta parte del código accede al array asociativo $pregunta_actual y específicamente al elemento 'respuestas'. La clave 'respuestas' se utiliza para almacenar las respuestas de la pregunta actual. 
    } else { // Si el primer caracter que encuentra en cada linea no es '+' ni '-', asume que ha llegado a la siguiente pregunta
        if (!empty($pregunta_actual)) {
            $preguntas[] = $pregunta_actual;
        }
        $pregunta_actual = ['pregunta' => $linea = substr($linea, 2), 'respuestas' => []];
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

    <form action="game.js">
        <input id="btnSeguent" type="submit" value="Següent">
    </form>
    <form action="index.php">
        <input id="btnInici" type="submit" value="Tornar a l' inici">
    </form>


    <script>
        // Info de la estructura HTLM
        let respuesta1=comprobarRespuesta("form1", "respuesta1", "feedback1", "question2", "answer1");
        let respuesta2=comprobarRespuesta("form2", "respuesta2", "feedback2", "question3", "answer2");
        let respuesta3=comprobarRespuesta("form3", "respuesta3", "feedback3", "question4", "answer3");


        function comprobarRespuesta(formId, answerName, feedbackId, nextQuestionId, answerClass) {
            document.getElementById(formId).addEventListener("change", function() {
                var selectedAnswer = document.querySelector(`input[name="${answerName}"]:checked`);
                var feedbackElement = document.getElementById(feedbackId);
                var nextQuestionElement = document.getElementById(nextQuestionId);
                var answers = document.querySelectorAll(`.${answerClass}`);
                
                if (formId!=="form3") {
                    if (selectedAnswer) {
                        var playerAnswer = selectedAnswer.value;
                        var firstChar = playerAnswer.charAt(0);
                        var isCorrect = (firstChar === '+');
                        if (isCorrect) {
                            feedbackElement.innerHTML = "Resposta correcta. Avançant a la següent pregunta...";
                            nextQuestionElement.classList.remove("questionHidden");
                            
                            for (var i = 0; i < answers.length; i++) {
                                answers[i].disabled = true;
                            }
                        } else {
                            feedbackElement.innerHTML = "Resposta incorrecta. Intenteu-ho de nou.";
                        }
                    } else {
                        feedbackElement.innerHTML = "";
                    }
                }else{
                    console.log("---------------->consol")
                    
                }
            });
        }
    </script>
</body>

</html>