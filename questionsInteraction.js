let respuesta1 = checkAnswer("form1", "respuesta1", "feedback1", "feedback11", "question2", "answer1");
let respuesta2 = checkAnswer("form2", "respuesta2", "feedback2", "feedback22", "question3", "answer2");
let respuesta3 = checkAnswer("form3", "respuesta3", "feedback3", "feedback33", "question4", "answer3");

// Suponiendo que obtienes los elementos de audio por sus IDs
var audioCorrecto = document.getElementById('audioCorrecto');
var audioIncorrecto = document.getElementById('audioIncorrecto');
var correctAnswers = 0;
//Scroll
var currentQuestion = 1; // Pregunta actual
var totalQuestions = 3; // Número total de preguntes

var countDownTimer;
var time = initialTime;

// Disable question after being answered
function disableQuestion(answers) {
    for (var i = 0; i < answers.length; i++) {
        answers[i].disabled = true;
    }
}

function checkAnswer(formId, answerName, feedbackId, feedbackId2, nextQuestionId, answerClass) {
    document.getElementById(formId).addEventListener("change", function () {
        var selectedAnswer = document.querySelector(`input[name="${answerName}"]:checked`);
        var feedbackElement = document.getElementById(feedbackId);
        var feedbackElement2 = document.getElementById(feedbackId2);
        var nextQuestionElement = document.getElementById(nextQuestionId);
        var answers = document.querySelectorAll(`.${answerClass}`);

        if (selectedAnswer) {
            stopCountDown();
            var playerAnswer = selectedAnswer.value;
            var firstChar = playerAnswer.charAt(0);
            var isCorrect = (firstChar === '+');
            if (isCorrect) {
                time = initialTime;
                correctAnswers++;
                audioCorrecto.play();
                selectedAnswer.classList.remove(answerClass);
                selectedAnswer.classList.add("correct");
                if (correctAnswers == 3) {
                    var btnSeguent = document.getElementById('buttonNext');
                    btnSeguent.style.display = "block";
                    showNextQuestion(nextQuestionId);
                } else {
                    checkSessionLevel();
                    feedbackElement.style.display = "block";
                    nextQuestionElement.classList.remove("questionHidden");
                    showNextQuestion(nextQuestionId);
                }

                // Disable question after being answered
                disableQuestion(answers);
            } else {
                selectedAnswer.classList.remove(answerClass);
                selectedAnswer.classList.add("incorrect");
                feedbackElement2.style.display = "block";
                audioIncorrecto.play();
                var btnInici = document.getElementById('btnInici');
                // Show index button if the answer is not correct
                if (btnInici) {
                    btnInici.style.display = 'block';

                }
                // Disable question after being answered
                disableQuestion(answers);

            }
        }
    });
}
function showNextQuestion(nextQuestionId) {
    if (currentQuestion < totalQuestions) {
        var nextQuestionElement = document.getElementById(nextQuestionId);
        nextQuestionElement.scrollIntoView({ behavior: "smooth" }); // Desplaçar-se a la següent pregunta
        currentQuestion++; // Incrementa la pregunta actual
    }
}

async function startCountDown() {
    if (initialTime !== null) {
        var counterId = '';
        if (correctAnswers == 0) {
            counterId = 'countDownTimer1';
        }
        else if (correctAnswers == 1) {
            counterId = 'countDownTimer2';
        } else {
            counterId = 'countDownTimer3';
        }
        var countDownElement = document.getElementById(counterId);

        async function updateCountDown() {
            countDownElement.textContent = time;
            if (time <= 0) {
                //countDownElement.textContent = 'Tiempo agotado';
                window.location.href = 'lose.php';

            } else {
                time--;
                countDownTimer = setTimeout(updateCountDown, 1000);
            }
        }

        updateCountDown();
    }
}

async function stopCountDown() {
    clearTimeout(countDownTimer);
}

async function checkSessionLevel() {
    try {
        if (sessionLevel >= 2) {
            // Starts the regresive counter for question
            startCountDown();
        }
    } catch (error) {
        console.error('Error at check level session:', error);
    }
}
// checks if the session level is greater than 2
checkSessionLevel();


// Variable de control para rastrear si la función ya se ha ejecutado

// Variable de control para rastrear si el botón "50%" ya se ha ejecutado

// Variable de control para rastrear si el botón "50%" ya se ha ejecutado
let fiftyPercentUsed = false;

document.addEventListener("DOMContentLoaded", function () {
    // Obtener el botón "50%" por su id
    const fiftyPercentButton = document.getElementById("submit");

    // Agregar un manejador de eventos al hacer clic en el botón
    fiftyPercentButton.addEventListener("click", function () {
        // Verificar si el botón "50%" ya se ha utilizado
        if (!fiftyPercentUsed) {
            // Obtener el id de la pregunta actual, reemplaza "question1" con el id correcto
            const currentQuestionId = "question" + currentQuestion; // Reemplaza con el id de la pregunta actual

            // Obtener todos los elementos <li> dentro de la lista de respuestas de la pregunta actual
            const listaRespuestas = document.querySelectorAll(`#${currentQuestionId} .answer-list li`);

            // Contador para llevar el seguimiento de respuestas ocultas
            let respuestasOcultas = 0;

            // Iterar a través de los elementos de la lista de respuestas de la pregunta actual
            listaRespuestas.forEach(function (item) {
                // Obtener el input de tipo radio en cada elemento <li>
                const radioInput = item.querySelector('input[type="radio"]');
                // Obtener el valor del input de tipo radio
                const valorRespuesta = radioInput.value;

                // Verificar si el valor de la respuesta comienza con "-" y aún no se han ocultado dos respuestas
                if (valorRespuesta.startsWith("-") && respuestasOcultas < 2) {
                    // Ocultar el elemento <li>
                    item.style.display = "none";
                    respuestasOcultas++;
                }
            });

            // Marcar el botón "50%" como utilizado
            fiftyPercentUsed = true;

            // Deshabilitar el botón "50%" después de usarlo
            fiftyPercentButton.disabled = true;
        }
    });

    // Aquí debes agregar código para habilitar nuevamente el botón "50%" cuando vuelvas a la página de inicio (index).
    // Puedes hacer esto mediante un enlace o un botón en la página de inicio que restablezca la variable fiftyPercentUsed y habilite el botón.
});
