let respuesta1 = checkAnswer("form1", "respuesta1", "feedback1", "feedback11", "question2", "answer1");
let respuesta2 = checkAnswer("form2", "respuesta2", "feedback2", "feedback22", "question3", "answer2");
let respuesta3 = checkAnswer("form3", "respuesta3", "feedback3", "feedback33", "question4", "answer3");

// Suponiendo que obtienes los elementos de audio por sus IDs
var audioCorrecto = document.getElementById('audioCorrecto');
var audioIncorrecto = document.getElementById('audioIncorrecto');
var correctAnswers = 0;

function checkAnswer(formId, answerName, feedbackId, feedbackId2, nextQuestionId, answerClass) {
    document.getElementById(formId).addEventListener("change", function () {
        var selectedAnswer = document.querySelector(`input[name="${answerName}"]:checked`);
        var feedbackElement = document.getElementById(feedbackId);
        var feedbackElement2 = document.getElementById(feedbackId2);
        var nextQuestionElement = document.getElementById(nextQuestionId);
        var answers = document.querySelectorAll(`.${answerClass}`);

        if (selectedAnswer) {
            var playerAnswer = selectedAnswer.value;
            var firstChar = playerAnswer.charAt(0);
            var isCorrect = (firstChar === '+');
            if (isCorrect) {
                correctAnswers++;
                audioCorrecto.play();
                if (correctAnswers == 3) {
                    var btnSeguent = document.getElementById('buttonNext');
                    btnSeguent.style.display = "block";
                } else {
                    feedbackElement.style.display = "block";
                    nextQuestionElement.classList.remove("questionHidden");
                }
                
                // Disable question after being answered
                for (var i = 0; i < answers.length; i++) {
                    answers[i].disabled = true;
                }
            } else {
                feedbackElement2.style.display = "block";
                audioIncorrecto.play();
                var btnInici = document.getElementById('btnInici');
                // Show index button if the answer is not correct
                if (btnInici) {
                    btnInici.style.display = 'block';

                }
                // Disable question after being answered
                for (var i = 0; i < answers.length; i++) {
                    answers[i].disabled = true;
                }

            }
        }
    });
}

async function getInitialTime() {
    try {
        const response = await fetch('game.php');
        const data = await response.json();
        return data.initialTime;
    } catch (error) {
        console.error('Error al obtener el tiempo inicial:', error);
        return null;
    }
}

async function startCountDown() {
    const initialTime = await getInitialTime();
    if (initialTime !== null) {
        let time = initialTime;
        let counterId = '';
        if (correctAnswers <= 1) {
            counterId = 'countDownTimer1';
        }
        else if (correctAnswers == 2) {
            counterId = 'countDownTimer2';
        } else {
            counterId = 'countDownTimer3';
        }
        console.log(counterId + " AAA");
        const countDownElement = document.getElementById(counterId);

        async function updateCountDown() {
            countDownElement.textContent = time;
            if (time <= 0) {
                countDownElement.textContent = 'Tiempo agotado';
            } else {
                time--;
                setTimeout(updateCountDown, 1000);
            }
        }

        updateCountDown();
    }
}

async function checkSessionLevel() {
    alert("alert desde checksession js: "+js_session);
    try {
        const response = await fetch('game.php');
        const data = await response.json();
        if (data.sessionLevel >= 2) {
            // Starts the regresive counter for question
            startCountDown();
        }
    } catch (error) {
        console.error('Error al comprobar el nivel de sesion:', error);
    }
}
checkSessionLevel();

