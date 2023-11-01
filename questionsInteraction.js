let respuesta1 = checkAnswer("form1", "respuesta1", "feedback1", "feedback11", "question2", "answer1");
let respuesta2 = checkAnswer("form2", "respuesta2", "feedback2", "feedback22", "question3", "answer2");
let respuesta3 = checkAnswer("form3", "respuesta3", "feedback3", "feedback33", "question4", "answer3");

// Suponiendo que obtienes los elementos de audio por sus IDs
var audioCorrecto = document.getElementById('audioCorrecto');
var audioIncorrecto = document.getElementById('audioIncorrecto');
var audioPublic = document.getElementById('audioPublic');
var correctAnswers = 0;
//Scroll
var currentQuestion = 1; // Pregunta actual
var totalQuestions = 3; // Número total de preguntes

var countDownTimer;
var time = initialTime;

const popup = document.getElementById("popup");
const popupButton = document.getElementById("popup-button");

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
                window.location.href = './resources/setNextLevel.php';

            } else {
                time--;
                countDownTimer = setTimeout(updateCountDown, 1000);
            }
        }
        updateCountDown();
    }
}

async function enableExtraTime(level) {
    if(level>1){
        if(localStorage.getItem("extraTime")!=null){
            console.log('Comodin ya utilizado');
        }else{
            document.getElementById('extraTime').disabled=false;
        }
    }
}

async function cleanLocalStorageTime(){
    localStorage.removeItem("extraTime");
}

async function extraTime() {
    time = time + 30;
    localStorage.setItem("extraTime",time);
    document.getElementById('extraTime').disabled=true;
}

async function stopCountDown() {
    clearTimeout(countDownTimer);
}

async function cleanLocalStorage(){
    localStorage.removeItem("extraTime");
    localStorage.removeItem("publicWildcard");
    localStorage.removeItem("50Wildcard");
}

function checkWildcard() {
    if (localStorage.getItem("publicWildcard") == null) {
        document.getElementById('publicWildcard').disabled=false;
    }
    if (localStorage.getItem("50Wildcard") == null) {
        document.getElementById('50Wildcard').disabled=false;
    }
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

function publicWildcard() {
    audioPublic.play();
    let numberOfAnswers;
    localStorage.setItem("publicWildcard", true);
    document.getElementById("publicWildcard").disabled = true;
    // Show the loading animation
    document.getElementById('loading').style.display = 'block';

    if (sessionLevel >= 2) {
        stopCountDown();
    }
    if (correctAnswers == 0) {
        numberOfAnswers = document.getElementById("list1").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer1");
        setTimeout(function() {
            // Ocultar la animación de carga después de un tiempo de espera
            document.getElementById('loading').style.display = 'none';
            document.getElementById('wildcardFeedback').style.display = 'none';
            createChart(numberOfAnswers, correctAnswer);
            // Realiza la acción deseada aquí, por ejemplo, cargar contenido o realizar una solicitud AJAX.
        }, 15000);
    }
    else if (correctAnswers == 1) {
        numberOfAnswers = document.getElementById("list2").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer2");
        setTimeout(function() {
            // Ocultar la animación de carga después de un tiempo de espera
            document.getElementById('loading').style.display = 'none';
            document.getElementById('wildcardFeedback').style.display = 'none';
            createChart(numberOfAnswers, correctAnswer);
            // Realiza la acción deseada aquí, por ejemplo, cargar contenido o realizar una solicitud AJAX.
        }, 15000);
    } else {
        numberOfAnswers = document.getElementById("list3").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer3");
        setTimeout(function() {
            // Ocultar la animación de carga después de un tiempo de espera
            document.getElementById('loading').style.display = 'none';
            document.getElementById('wildcardFeedback').style.display = 'none';
            createChart(numberOfAnswers, correctAnswer);
            // Realiza la acción deseada aquí, por ejemplo, cargar contenido o realizar una solicitud AJAX.
        }, 15000);
    }
    popup.style.display = "block";
    // Block interaction with the main screen
    document.body.style.overflow = "hidden";
}

function returnCorrectAnswerPosition(className) {
    let answersArray = document.getElementsByClassName(className);
    for (var i = 0; i < answersArray.length; i++) {
        if (answersArray[i].value.charAt(0) === '+') {
            return i;
        }
    }
}

function hidePublicWildCard() {
    if (sessionLevel >= 2) {
        startCountDown();
    }
    popup.style.display = "none";
    // Enable interaction with the main screen
    document.body.style.overflow = "auto";
}

function createChart(numberOfBars, correctAnswerPos) {
    let publicCorrect = generatePublicProbability();
    let percentages = [];
    let totalAudience = 100;
    let probabilityByOption = totalAudience / numberOfBars;
    for (let i = 0; i < numberOfBars; i++) {
        percentages.push(probabilityByOption);
    }
    if (publicCorrect) {
        let incrementCorrect = Math.floor(Math.random() * (25 - 10 + 1)) + 10; // numero random que genera un num del 10 al 25
        percentages[correctAnswerPos] += incrementCorrect;
        while (true) {
            let modIndex = Math.floor(Math.random() * percentages.length); // a number from 0 to lenght of the percentatges - 1
            if (modIndex != correctAnswerPos) {
                percentages[modIndex] -= incrementCorrect;
                break;
            } 
        }
    } else {
        let decrementCorrect = Math.floor(Math.random() * (25 - 10 + 1)) + 10; // numero random que genera un num del 10 al 25
        percentages[correctAnswerPos] -= decrementCorrect;
        while (true) {
            let modIndex = Math.floor(Math.random() * percentages.length); // a number from 0 to lenght of the percentatges - 1
            if (modIndex != correctAnswerPos) {
                percentages[modIndex] += decrementCorrect;
                break;
            }
        }
    }

    // Datos de ejemplo (porcentajes para cuatro barras y etiquetas correspondientes)
    const etiquetas = ["A", "B", "C", "D"]; // Etiquetas correspondientes

    // Configuración del gráfico
    const width = 410;
    const height = 300;
    const barSpacing = 20;
    const barWidth = (width - (barSpacing * (numberOfBars - 1))) / numberOfBars;

    // Crea un elemento SVG usando D3.js
    const svg = d3.select("#chart")
    .attr("width", width)
    .attr("height", height);

    // Crea un filtro de sombra en CSS para aplicar a las barras
    svg.append("defs").append("filter")
    .attr("id", "drop-shadow")
    .append("feDropShadow")
    .attr("dx", 4)
    .attr("dy", 4)
    .attr("stdDeviation", 0)
    .attr("flood-color", "#42393b"); // Color de la sombra

    // Crea las barras del gráfico
    for (let i = 0; i < numberOfBars; i++) {
    const x = i * (barWidth + barSpacing);
    const barHeight = height * (percentages[i] / 100);

    svg.append("rect")
        .attr("x", x)
        .attr("y", (height - barHeight) - 30)
        .attr("width", barWidth - 5)
        .attr("height", barHeight)
        .attr("fill", "#ffc897")
        .attr("stroke", "#42393b") // Color del borde
        .attr("stroke-width", 3) // Ancho del borde
        .attr("rx", 5) // Radio de la esquina X
        .attr("ry", 5) // Radio de la esquina Y
        .style("filter", "url(#drop-shadow)"); // Aplica la sombra

    // Agrega etiquetas de porcentaje encima de las barras
    svg.append("text")
        .attr("x", x + barWidth / 2)
        .attr("y", height - barHeight - 40)
        .attr("text-anchor", "middle")
        .text((percentages[i]) + "%");

    // Agrega etiquetas "A", "B", "C", "D" debajo de las barras
    svg.append("text")
        .attr("x", x + barWidth / 2)
        .attr("y", height) // Ajusta la posición vertical según tus necesidades
        .attr("text-anchor", "middle")
        .text(etiquetas[i]);
    }
}

function generatePublicProbability() {
    const randomNumber = Math.random();
    if (randomNumber < 0.8) { // 80% probability ok
        return true;
      } else {
        return false;
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
    const fiftyPercentButton = document.getElementById("50Wildcard");
    localStorage.setItem("50Wildcard", true);

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
            console.log();
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
