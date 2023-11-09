<?php
    session_start();
    include './resources/myFunctions.php';
    $backToStartButton = trans('backToStartButton', $_SESSION['lang']);
    $createTitle = trans('createTitle', $_SESSION['lang']);
    $languajeCreate = trans('languajeCreate', $_SESSION['lang']);
    $catCreate = trans('catCreate', $_SESSION['lang']);
    $spCreate = trans('spCreate', $_SESSION['lang']);
    $enCreate = trans('enCreate', $_SESSION['lang']);
    $levelCreate = trans('levelCreate', $_SESSION['lang']);
    $nextQuestion = trans('nextQuestion', $_SESSION['lang']);
    $correctAnswer = trans('correctAnswer', $_SESSION['lang']);
    $incorrectAnswer1 = trans('incorrectAnswer1', $_SESSION['lang']);
    $incorrectAnswer2 = trans('incorrectAnswer2', $_SESSION['lang']);
    $incorrectAnswer3 = trans('incorrectAnswer3', $_SESSION['lang']);
    $imageCreate = trans('imageCreate', $_SESSION['lang']);
    $sendCreate = trans('sendCreate', $_SESSION['lang']);
?>
<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $createTitle; ?></title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
</head>
<body>
    <?php
    if (!isset($_SESSION["login"])) {
        http_response_code(403);
        echo "<h1>403 Forbidden</h1>
        <a class='rankingButton' href='/index.php'>$backToStartButton</a>";
        exit;
    }
    ?>
    <h1><?php echo $createTitle; ?></h1>
    <?php if(isset($_SESSION['formFeedback'])) {echo "<div class='containerformFeedbackIncorrect'><h2 class='formFeedback'>" . $_SESSION['formFeedback'] . "</h2></div>";} ?>
    <?php if(isset($_SESSION['formFeedbackOK'])) {echo "<div class='containerformFeedbackCorrect'><h2 class='formFeedback'>" . $_SESSION['formFeedbackOK'] . "</h2></div>";} ?>
    <div class="create">
        <form action="./resources/checkForm.php" method="post" enctype="multipart/form-data" class="form">
            <label for="questionLang"><?php echo $languajeCreate; ?></label>
            <select id="questionLang" name="questionLang" required>
                <option value="catalan_"><?php echo $catCreate; ?></option>
                <option value="spanish_"><?php echo $spCreate; ?></option>
                <option value="english_"><?php echo $enCreate; ?></option>
            </select><br><br>

            <label for="questionLevel"><?php echo $levelCreate; ?></label>
            <select id="questionLevel" name="questionLevel" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select><br><br>

            <input type="text" id="question" name="question" required class="form__input" placeholder="<?php echo $nextQuestion; ?>">
            <label for="question" class="form__label"><?php echo $nextQuestion; ?></label> 

            <input type="text" id="correctAnswer" name="correctAnswer" required class="form__input" placeholder="<?php echo $correctAnswer; ?>">
            <label for="correctAnswer" class="form__label"><?php echo $correctAnswer; ?></label>

            <input type="text" id="incorrectAnswer1" name="incorrectAnswer1" required class="form__input" placeholder="<?php echo $incorrectAnswer1; ?>">
            <label for="incorrectAnswer1" class="form__label"><?php echo $incorrectAnswer1; ?></label>

            <input type="text" id="incorrectAnswer2" name="incorrectAnswer2" required class="form__input" placeholder="<?php echo $incorrectAnswer2; ?>">
            <label for="incorrectAnswer2" class="form__label"><?php echo $incorrectAnswer2; ?></label>

            <input type="text" id="incorrectAnswer3" name="incorrectAnswer3" required class="form__input" placeholder="<?php echo $incorrectAnswer3; ?>">
            <label for="incorrectAnswer3" class="form__label"><?php echo $incorrectAnswer3; ?></label>

            <label for="imagen"><?php echo $imageCreate; ?></label>
            <input type="file" name="image" id="image" accept="image/*">

            <input type="submit" value="<?php echo $sendCreate; ?>" class="sendInput">
        </form>
    </div>
    <div class="autocenter"><a class="standardA" href="/"><?php echo $backToStartButton; ?></a></div>
    
</body>
</html>