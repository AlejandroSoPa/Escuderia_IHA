<?php
    session_start();
    if(isset($_SESSION['formFeedbackOK'])) {
        unset($_SESSION['formFeedbackOK']);
    }
    if(!isset($_POST['questionLang']) || !isset($_POST['questionLevel']) || !isset($_POST['question']) || !isset($_POST['correctAnswer']) 
    || !isset($_POST['incorrectAnswer1']) || !isset($_POST['incorrectAnswer2']) || !isset($_POST['incorrectAnswer3'])) {
        $_SESSION['formFeedback'] = "Si us plau omple tots els camps";
        header("Location: ../create.php");
        exit;
    }
    elseif(strlen(trim($_POST['questionLang'])) == 0 || strlen(trim($_POST['questionLevel'])) == 0 || strlen(trim($_POST['question'])) == 0 
        || strlen(trim($_POST['correctAnswer'])) == 0 || strlen(trim($_POST['incorrectAnswer1'])) == 0 || strlen(trim($_POST['incorrectAnswer2'])) == 0 || strlen(trim($_POST['incorrectAnswer3'])) == 0) {
            $_SESSION['formFeedback'] = "No es permet sols espais en blanc.";
            header("Location: ../create.php");
            exit;
    }
    elseif (strlen($_POST["question"]) > 116) {
        $_SESSION['formFeedback'] = "La pregunta no pot tindre més de 116 caràcters";
        header("Location: ../create.php");
        exit;
    }
    elseif (strlen($_POST["correctAnswer"]) > 40 || strlen($_POST["incorrectAnswer1"]) > 40 || strlen($_POST["incorrectAnswer2"]) > 40 || strlen($_POST["incorrectAnswer3"]) > 40) {
        $_SESSION['formFeedback'] = "Les respostes tenen un màxim de 40 caràcters.";
        header("Location: ../create.php");
        exit;
    }
    // Check the level value. If it is not between 1 and 6, the user is trying to fool us
    // Check the selected language. If it is not between the 3 languages specified in the array, the user is trying to fool us
    $correctLanguage = false;
    $languagesArray = ["catalan_", "english_", "spanish_"];
    foreach ($languagesArray as $lang) {
        if ($lang == $_POST['questionLang']) {
            $correctLanguage = true;
        }
    }
    $correctLevel = false;
    for ($i=1; $i <= 6; $i++) { 
        if ($i . "" == $_POST['questionLevel']) {
            $correctLevel = true;
            break;
        }
    }
    if (!$correctLevel || !$correctLanguage) {
        $_SESSION['formFeedback'] = "T'observem i no ens agrada que facis això.";
        header("Location: ../create.php");
        exit;
    }
    if(isset($_FILES['image'])) {
        $archivo = $_FILES['image'];
    
        // Check if there is an error with the uploaded file
        if ($archivo['error'] === UPLOAD_ERR_OK) {
            // Check if it is an image
            $infoImagen = getimagesize($archivo['tmp_name']);
            if ($infoImagen !== false) {
                $jsonRoute = 'questionsWithPhotos.json';

                // Read the actual content of the JSON
                $jsonData = file_get_contents($jsonRoute);

                // Decode the content of the JSON into an associative array
                $data = json_decode($jsonData, true);

                // Add new data to the array
                $imgExtension = pathinfo($_FILES['image']['name'])['extension'];
                $imgPath = "FotosPreguntas/" . $_POST['questionLevel'] . "/" . time() . "." . $imgExtension;
                $newData = array(
                    $_POST['question'] => $imgPath
                );

                $data = array_merge($data, $newData);

                // Turns the associative array into a JSON with the new content
                $jsonUpdated = json_encode($data, JSON_PRETTY_PRINT);

                // Write the new content in the JSON
                file_put_contents($jsonRoute, $jsonUpdated);

                // Save the image into the corresponding folder
                move_uploaded_file($_FILES['image']['tmp_name'], "../" . $imgPath);

            } else {
                $_SESSION['formFeedback'] = "El fitxer no és una imatge vàlida.";
                header("Location: ../create.php");
                exit;
            }
        }
    }
    if(isset($_SESSION['formFeedback'])) {
        unset($_SESSION['formFeedback']);
    }

    // save the new question and turns to the create.php page
    $fileRoute = "../questions/".$_POST['questionLang'].$_POST['questionLevel'].".txt";
    $newFileContent = file_get_contents($fileRoute)."\n* ".trim($_POST['question'])."\n+ ".trim($_POST['correctAnswer'])."\n- ".trim($_POST['incorrectAnswer1'])."\n- ".trim($_POST['incorrectAnswer2'])."\n- ".trim($_POST['incorrectAnswer3']);
    file_put_contents($fileRoute, $newFileContent);
    $_SESSION['formFeedbackOK'] = "S'ha enregistrat la nova pregunta";
    header("Location: ../create.php");
    exit;
    
?>