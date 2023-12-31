<?php
session_start();
include './resources/getPhotos.php';
include './resources/myFunctions.php';
if (!isset($_SESSION['counter'])) {
    $_SESSION['counter'] = 0;
}
if (!isset($_SESSION['level'])) {
    $_SESSION['level'] = 1;
}
if ($_SESSION['lang'] == 'cat') {
    $fileRoute = 'questions/catalan_' . $_SESSION['level'] . '.txt';
} elseif ($_SESSION['lang'] == 'es') {
    $fileRoute = 'questions/spanish_' . $_SESSION['level'] . '.txt';
} elseif ($_SESSION['lang'] == 'en') {
    $fileRoute = 'questions/english_' . $_SESSION['level'] . '.txt';
}

$rutaFoto = 'FotosPreguntas/1/GhandiDoFor.png';
$rutaFoto2 = 'FotosPreguntas/1/SoccerCentury.jpg';

$letersArray = ["A. ", "B. ", "C. ", "D. "];
$iteration = 0;

$contenido = file_get_contents($fileRoute);
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
            $linea = $parte1 . " " . $parte2;
        }
        $pregunta_actual['respuestas'][] = $linea; // Esta parte del código accede al array asociativo $pregunta_actual y específicamente al elemento 'respuestas'. La clave 'respuestas' se utiliza para almacenar las respuestas de la pregunta actual. 
    } else { // Si el primer caracter que encuentra en cada linea no es '+' ni '-', asume que ha llegado a la siguiente pregunta
        if (!empty($pregunta_actual)) {
            $preguntas[] = $pregunta_actual;
        }
        $pregunta_actual = ['pregunta' => $linea = substr($linea, 2), 'respuestas' => []];
    }
}
if (!empty($pregunta_actual)) {
    $preguntas[] = $pregunta_actual;
}
shuffle($preguntas);
$preguntasAleatorias = array_slice($preguntas, 0, 3);
$gameTittle = trans('gameTittle', $_SESSION['lang']);
$nextButtonText = trans('nextButton', $_SESSION['lang']);
$backToStartButtonText = trans('backToStartButton', $_SESSION['lang']);
$correctAnswerText = trans('correctAnswer', $_SESSION['lang']);
$incorrectAnswerText = trans('incorrectAnswer', $_SESSION['lang']);
$publicWildcardText = trans('publicWildCard', $_SESSION['lang']);
$publicWildcardFeedback = trans('publicWildCardFeedback', $_SESSION['lang']);
$closeButtonText = trans('close', $_SESSION['lang']);
$callTitle = trans('callTitle',$_SESSION['lang']);
$callText = trans('callText', $_SESSION['lang']);
$responseCall = trans('responseCall', $_SESSION['lang']);
$sendCall = trans('sendCall', $_SESSION['lang']);
$cronoTitle = trans('cronoTitle', $_SESSION['lang']);
$timeTitle = trans('timeTitle', $_SESSION['lang']);
$incorrectAnswerCall = trans('incorrectAnswerCall', $_SESSION['lang']);

echo "<!DOCTYPE html>";
echo "<html lang='{$_SESSION['lang']}'>";

echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>$gameTittle</title>";
echo "<link rel='stylesheet' href='styles.css'>";
echo "<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Kanit'>";
echo "<link rel='icon' href='./images/question-icon.svg' type='image/png'>";
echo "</head>";

echo "<body>";
echo "<script>var sessionLevel = '" . $_SESSION['level'] . "'; var initialTime = 30;</script>";
echo "   <h1>$gameTittle</h1>";
?>
<audio id="audioCorrecto" src="audio/acierto.mp3"></audio>
<audio id="audioIncorrecto" src="audio/error.mp3"></audio>
<audio id="audioHelp" src="audio/help.mp3"></audio>
<audio id="audioPublic" src="audio/publicWildcard.mp3"></audio>
<audio id="audioCall" src="audio/callWildcard.mp3"></audio>
<div id="help">
  <button onclick="callWildcard()" type="submit" class="wildCard" value="call" id="callWildcard" disabled="true"><img src='./images/call.png'></button>
  <button onclick="fiftyPercentWildcard()" type="submit" class="wildCard" value="50%" id="50Wildcard" disabled="true"><img src='./images/50-percent.png'></button>
  <button onclick="publicWildcard()" type="submit" class="wildCard" value="Public" id="publicWildcard" disabled="true"><img src='./images/group.png'></button>
  <button type="submit" id="extraTime" class="wildCard" value="extraTime" disabled="true" onClick="extraTime();"><img src='./images/clock.png'></button>
</div>
<div id="incremental">
    <h3 id="cronoTitle"><?php echo $cronoTitle; ?></h3>
    <h3 id='crono'>00:00:00</h3>
</div>

<div class="question" id="question1">
    <h2 class="questionText"><?php echo $preguntasAleatorias[0]['pregunta']; ?></h2>
    <?php
    $preguntaActual = $preguntasAleatorias[0]['pregunta'];
    getPhotoAndPath($preguntaActual, $preguntasConFotos);
    ?>
    <?php
    if($_SESSION['level']>1){
        $level = $_SESSION['level'];
        echo "<h3 id='cronoTitle'>$timeTitle</h3>";
    };
    ?>
    <h3 class="countDownTimer" id="countDownTimer1"></h3>
    <form id="form1" class="answer-form">
        <ul class="answer-list" id="list1">
            <?php foreach ($preguntasAleatorias[0]['respuestas'] as $respuesta) : ?>
                <li>
                    <input type="radio" name="respuesta1" value="<?php echo $respuesta; ?>" autocomplete="off" class="answer1">
                    <label><?php echo $respuesta = $letersArray[$iteration].substr($respuesta, 2); $iteration++;?></label>
                </li>
            <?php endforeach; $iteration = 0;?>
        </ul>
        <br>
    </form>
    <div class="feedbackGood" id="feedback1"><?php echo $correctAnswerText; ?></div>
    <div class="feedbackBad" id="feedback11"><?php echo $incorrectAnswerText; ?></div>
    <div class="feedbackBadCall" id="feedback12"><?php echo $incorrectAnswerCall; ?></div>
</div>

<div class="questionHidden" id="question2">
    <h2 class="questionText"><?php echo $preguntasAleatorias[1]['pregunta']; ?></h2>
    <?php
    $preguntaActual = $preguntasAleatorias[1]['pregunta'];
    getPhotoAndPath($preguntaActual, $preguntasConFotos);
    ?>
    <?php
    if($_SESSION['level']>1){
        $level = $_SESSION['level'];
        echo "<h3 id='cronoTitle'>$timeTitle</h3>";
    };
    ?>
    <h3 class="countDownTimer" id="countDownTimer2"></h3>
    <form id="form2">
        <ul class="answer-list" id="list2">
            <?php foreach ($preguntasAleatorias[1]['respuestas'] as $respuesta) : ?>
                <li>
                    <input type="radio" name="respuesta2" value="<?php echo $respuesta; ?>" autocomplete="off" class="answer2">
                    <label><?php echo $respuesta = $letersArray[$iteration].substr($respuesta, 2); $iteration++;?></label>
                </li>
            <?php endforeach; $iteration = 0;?>
        </ul>
        <br>
    </form>
    <div id="feedback2"><?php echo $correctAnswerText; ?></div>
    <div id="feedback22"><?php echo $incorrectAnswerText; ?></div>
    <div class="feedback22Call" id="feedback23"><?php echo $incorrectAnswerCall; ?></div>
</div>

<div class="questionHidden" id="question3">
    <h2 class="questionText"><?php echo $preguntasAleatorias[2]['pregunta']; ?></h2>
    <?php
    $preguntaActual = $preguntasAleatorias[2]['pregunta'];
    getPhotoAndPath($preguntaActual, $preguntasConFotos);
    ?>
    <?php
    if($_SESSION['level']>1){
        $level = $_SESSION['level'];
        echo "<h3 id='cronoTitle'>$timeTitle</h3>";
    };
    ?>
    <h3 class="countDownTimer" id="countDownTimer3"></h3>
    <form id="form3">
        <ul class="answer-list" id="list3">
            <?php foreach ($preguntasAleatorias[2]['respuestas'] as $respuesta) : ?>
                <li>
                    <input type="radio" name="respuesta3" value="<?php echo $respuesta; ?>" autocomplete="off" class="answer3">
                    <label><?php echo $respuesta = $letersArray[$iteration].substr($respuesta, 2); $iteration++;?></label>
                </li>
            <?php endforeach; $iteration = 0;?>
        </ul>
        <br>
    </form>
    <div id="feedback3"><?php echo $correctAnswerText; ?></div>
    <div id="feedback33"><?php echo $incorrectAnswerText; ?></div>
    <div class="feedback33Call" id="feedback34"><?php echo $incorrectAnswerCall; ?></div>
</div>

<form action="./resources/setNextLevel.php" method="post">
    <input id="buttonNext" name="next" type="submit" value="<?php echo $nextButtonText; ?>"></input>
</form>
<form action="index.php">
    <input id="btnInici" type="submit" value="<?php echo $backToStartButtonText; ?>" onclick='empezarDetener(this);'></input>
</form>
<div id="popup" class="popup">
    <div class="popup-content">
        <h1><?php echo $publicWildcardText; ?></h1>
        <p id="wildcardFeedback"><?php echo $publicWildcardFeedback; ?></p>
        <div id="loading" class="loading"></div>
        <svg id="chart"></svg>
        <button onclick="hidePublicWildCard()" class="standardButton"><?php echo $closeButtonText; ?></button>
    </div>
</div>
<div id="popup_call" class="popup_call">
    <div class="popup-content_call">
        <?php echo "<h1>$callTitle</h1>";
            echo "<p>$callText</p>";
            echo "<div id='image' class='image'><img src='./images/call.png' id='callImage' name='callImage'></div>";
            echo "<input type='number' id='userResponse' name='userResponse'></input>";
            echo "<button onClick=\"callChangePopUp('$responseCall')\" class='standardButton'>$sendCall</button>";?>
    </div>
</div>
<script src="questionsInteraction.js"></script>
<?php echo "<script> checkWildcard(); </script>" ?>
<?php
if($_SESSION['level']>1){
    $level = $_SESSION['level'];
    echo "<script> enableExtraTime($level); </script>";
};
?>
<script src="crono.js"></script>
<script src="https://d3js.org/d3.v6.min.js"></script>
</body>
</html>