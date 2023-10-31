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

function publicWildcard() {
    let numberOfAnswers;
    changeWildcardSession("publicWildcard");
    document.getElementById("publicWildcard").disabled = true;

    if (sessionLevel >= 2) {
        stopCountDown();
    }
    if (correctAnswers == 0) {
        numberOfAnswers = document.getElementById("list1").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer1");
        createChart(numberOfAnswers, correctAnswer);
    }
    else if (correctAnswers == 1) {
        numberOfAnswers = document.getElementById("list2").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer2");
        createChart(numberOfAnswers, correctAnswer);
    } else {
        numberOfAnswers = document.getElementById("list3").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer3");
        createChart(numberOfAnswers, correctAnswer);
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
    popup.style.display = "none";
    // Enable interaction with the main screen
    document.body.style.overflow = "auto";
}

function createChart(numberOfBars, correctAnswerPos) {
    let publicCorrect = generatePublicProbability();
    let percentages = [];
    let totalAudience = 100;
    let probabilityByOption = totalAudience / numberOfBars;
    alert(publicCorrect);
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
    const height = 350;
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

function changeWildcardSession(wildCardName) {
    // Realizar una solicitud AJAX al servidor
    var xhr = new XMLHttpRequest();
    xhr.open('POST', './resources/wildCardsSession.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
    xhr.send(wildCardName + '=' + false);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };
}


// checks if the session level is greater than 2
checkSessionLevel();

  