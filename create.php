<!DOCTYPE html>
<html lang="cat">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nova pregunta</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="icon" href="./images/question-icon.svg" type="image/png">
</head>
<body>
    <h1>Formulari de creació de preguntes</h1>
    <div class="feedback"></div>
    <div class="create">
        <form action="./resources/checkForm.php" method="post" class="form">
            <label for="questionLang">Idioma de la pregunta:</label>
            <select id="questionLang" name="questionLang" required>
                <option value="catalan_">Català</option>
                <option value="spanish_">Castellà</option>
                <option value="english_">Anglès</option>
            </select><br><br>

            <label for="questionLevel">Nivell de dificultat de la pregunta:</label>
            <select id="questionLevel" name="questionLevel" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select><br><br>

            <input type="text" id="question" name="question" required class="form__input" placeholder="Nova pregunta">
            <label for="question" class="form__label">Nova pregunta</label> 

            <input type="text" id="correctAnswer" name="correctAnswer" required class="form__input" placeholder="Resposta correcta">
            <label for="correctAnswer" class="form__label">Resposta correcta</label>

            <input type="text" id="incorrectAnswer1" name="incorrectAnswer1" required class="form__input" placeholder="Opció incorrecta 1">
            <label for="incorrectAnswer1" class="form__label">Opció incorrecta 1</label>

            <input type="text" id="incorrectAnswer2" name="incorrectAnswer2" required class="form__input" placeholder="Opció incorrecta 2">
            <label for="incorrectAnswer2" class="form__label">Opció incorrecta 2</label>

            <input type="text" id="incorrectAnswer3" name="incorrectAnswer3" required class="form__input" placeholder="Opció incorrecta 3">
            <label for="incorrectAnswer3" class="form__label">Opció incorrecta 3</label>

            <input type="submit" value="Enviar" class="sendInput">
        </form>
    </div>
    
</body>
</html>