let respuesta1 = checkAnswer("form1", "respuesta1", "feedback1", "question2", "answer1");
let respuesta2 = checkAnswer("form2", "respuesta2", "feedback2", "question3", "answer2");
let respuesta3 = checkAnswer("form3", "respuesta3", "feedback3", "question4", "answer3");

var correctAnswers = 0;

function updateCounter() {
    var btnSeguent = document.getElementById('buttonNext');
    btnSeguent.addEventListener('click', async function() {
        try {
            const response = await fetch('game.php');

            if (response.ok) {
                const data = await response.text();
                if (data) {
                    console.log('Valor de la variable de sesión: ' + data);
                } else {
                    console.log('La variable de sesión no está definida');
                }
            } else {
                console.error('Error al obtener el valor de la variable de sesión');
            }
        } catch (error) {
            console.error('Error al actualizar la variable de sesión:', error);
        }
    });

}

function checkAnswer(formId, answerName, feedbackId, nextQuestionId, answerClass) {
    document.getElementById(formId).addEventListener("change", function () {
        var selectedAnswer = document.querySelector(`input[name="${answerName}"]:checked`);
        var feedbackElement = document.getElementById(feedbackId);
        var nextQuestionElement = document.getElementById(nextQuestionId);
        var answers = document.querySelectorAll(`.${answerClass}`);

        if (selectedAnswer) {
            var playerAnswer = selectedAnswer.value;
            var firstChar = playerAnswer.charAt(0);
            var isCorrect = (firstChar === '+');
            if (isCorrect) {
                correctAnswers++;
                if (correctAnswers == 3) {
                    var btnSeguent = document.getElementById('buttonNext');
                    btnSeguent.style.display = "block";
                } else {
                    feedbackElement.innerHTML = "Resposta correcta. Avançant a la següent pregunta...";
                    nextQuestionElement.classList.remove("questionHidden");
                }
                
                // Disable question after being answered
                for (var i = 0; i < answers.length; i++) {
                    answers[i].disabled = true;
                }
            } else {

                feedbackElement.innerHTML = "Resposta incorrecta.";
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
        } else {
            feedbackElement.innerHTML = "";
        }

    });
}