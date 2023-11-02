let respuesta1 = checkAnswer("form1", "respuesta1", "feedback1", "feedback11", "question2", "answer1");
let respuesta2 = checkAnswer("form2", "respuesta2", "feedback2", "feedback22", "question3", "answer2");
let respuesta3 = checkAnswer("form3", "respuesta3", "feedback3", "feedback33", "question4", "answer3");

var audioCorrecto = document.getElementById('audioCorrecto');
var audioIncorrecto = document.getElementById('audioIncorrecto');
var audioPublic = document.getElementById('audioPublic');
var audioCall = document.getElementById('audioCall');
var correctAnswers = 0;
var currentQuestion = 1; 
var totalQuestions = 3;
var repeticion = 0;

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
        nextQuestionElement.scrollIntoView({ behavior: "smooth" }); // Scroll to next question
        currentQuestion++;
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
    localStorage.removeItem("callWildcard");
}

function checkWildcard() {
    if (localStorage.getItem("publicWildcard") == null) {
        document.getElementById('publicWildcard').disabled=false;
    }
    if (localStorage.getItem("50Wildcard") == null) {
        document.getElementById('50Wildcard').disabled=false;
    }
    if (localStorage.getItem("callWildcard") == null) {
        document.getElementById('callWildcard').disabled=false;
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
            // After a time of 15 seconds hide the loading animation and the feedback and create the svg chart
            document.getElementById('loading').style.display = 'none';
            document.getElementById('wildcardFeedback').style.display = 'none';
            createChart(numberOfAnswers, correctAnswer);
        }, 15000);
    }
    else if (correctAnswers == 1) {
        numberOfAnswers = document.getElementById("list2").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer2");
        setTimeout(function() {
            // After a time of 15 seconds hide the loading animation and the feedback and create the svg chart
            document.getElementById('loading').style.display = 'none';
            document.getElementById('wildcardFeedback').style.display = 'none';
            createChart(numberOfAnswers, correctAnswer);
        }, 15000);
    } else {
        numberOfAnswers = document.getElementById("list3").getElementsByTagName("li").length;
        let correctAnswer = returnCorrectAnswerPosition("answer3");
        setTimeout(function() {
            // After a time of 15 seconds hide the loading animation and the feedback and create the svg chart
            document.getElementById('loading').style.display = 'none';
            document.getElementById('wildcardFeedback').style.display = 'none';
            createChart(numberOfAnswers, correctAnswer);
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
        let incrementCorrect = Math.floor(Math.random() * (25 - 10 + 1)) + 10; // random number from 10 to 25
        percentages[correctAnswerPos] += incrementCorrect;
        while (true) {
            let modIndex = Math.floor(Math.random() * percentages.length); // a number from 0 to lenght of the percentatges - 1
            if (modIndex != correctAnswerPos) {
                percentages[modIndex] -= incrementCorrect;
                break;
            } 
        }
    } else {
        let decrementCorrect = Math.floor(Math.random() * (25 - 10 + 1)) + 10; // random number from 10 to 25
        percentages[correctAnswerPos] -= decrementCorrect;
        while (true) {
            let modIndex = Math.floor(Math.random() * percentages.length); // a number from 0 to lenght of the percentatges - 1
            if (modIndex != correctAnswerPos) {
                percentages[modIndex] += decrementCorrect;
                break;
            }
        }
    }

    const etiquetas = ["A", "B", "C", "D"];

    // Chart config
    const width = 410;
    const height = 300;
    const barSpacing = 20;
    const barWidth = (width - (barSpacing * (numberOfBars - 1))) / numberOfBars;

    // Create a svg element using D3.js
    const svg = d3.select("#chart")
    .attr("width", width)
    .attr("height", height);

    // Chart bars css shadow filter
    svg.append("defs").append("filter")
    .attr("id", "drop-shadow")
    .append("feDropShadow")
    .attr("dx", 4)
    .attr("dy", 4)
    .attr("stdDeviation", 0)
    .attr("flood-color", "#42393b"); // Color of the shadow

    // Create the bars of the chart
    for (let i = 0; i < numberOfBars; i++) {
    const x = i * (barWidth + barSpacing);
    const barHeight = height * (percentages[i] / 100);

    svg.append("rect")
        .attr("x", x)
        .attr("y", (height - barHeight) - 30)
        .attr("width", barWidth - 5)
        .attr("height", barHeight)
        .attr("fill", "#ffc897")
        .attr("stroke", "#42393b") // Border color
        .attr("stroke-width", 3) // Border width
        .attr("rx", 5) // X corner radio
        .attr("ry", 5) // Y corner radio
        .style("filter", "url(#drop-shadow)"); // Apply the shadow

    // Add the percentage tags above the bars
    svg.append("text")
        .attr("x", x + barWidth / 2)
        .attr("y", height - barHeight - 40)
        .attr("text-anchor", "middle")
        .text((percentages[i]) + "%");

    // Add the tags "A", "B", "C", "D" below of the bars
    svg.append("text")
        .attr("x", x + barWidth / 2)
        .attr("y", height)
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

function fiftyPercentWildcard() {
    localStorage.setItem("50Wildcard", true);
    document.getElementById("50Wildcard").disabled = true;
    // Obtains the current question id. Replaces "question1" with the correct id
    const currentQuestionId = "question" + currentQuestion;
    // Obtains all of the <li> elements inside the answers list of the actual question
    const listaRespuestas = document.querySelectorAll(`#${currentQuestionId} .answer-list li`);

    // Counter to keep track of hidden responses
    let respuestasOcultas = 0;

    listaRespuestas.forEach(function (item) {
        const radioInput = item.querySelector('input[type="radio"]');
        const valorRespuesta = radioInput.value;

        // Check if the value of the answer starts with "-" and two answers have not been hidden yet
        if (valorRespuesta.startsWith("-") && respuestasOcultas < 2) {
            // Delete the <li> element
            item.remove();
            respuestasOcultas++;
        }
    });
    // We replace the first character of each label with new letters from A to B
    const letters = ["A", "B", "C", "D"];
    const labelList = document.querySelectorAll(`#${currentQuestionId} .answer-list li`);
    for (let i = 0; i < labelList.length; i++) {
        // Obtains the <label> on each <li> element
        const labelElement = labelList[i].querySelector('label');
        const newText = letters[i] + labelElement.innerText.substring(1);
        labelElement.innerText = newText;
    }
}

function callWildcard() {
    localStorage.setItem("callWildcard", true);
    document.getElementById("callWildcard").disabled = true;
    var repeticion = getNRandom();
    callAnimationAndSound(repeticion);
}

function getNRandom() {
  const numRandom = Math.floor(Math.random() * 10) + 1;
  return numRandom;
}

function callAnimationAndSound(repeticion) {
    if(repeticion>=1){
        console.log(repeticion);
        audioCall.play();
        setTimeout(function() {
            callAnimationAndSound(repeticion - 1);
          }, 2000);
    }
}

// Checks if the session level is greater than 2
// This is used to start the regresive counter for the first time
checkSessionLevel();
