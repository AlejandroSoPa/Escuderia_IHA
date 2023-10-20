let respuesta1=comprobarRespuesta("form1", "respuesta1", "feedback1", "question2", "answer1");
let respuesta2=comprobarRespuesta("form2", "respuesta2", "feedback2", "question3", "answer2");
let respuesta3=comprobarRespuesta("form3", "respuesta3", "feedback3", "question4", "answer3");


function comprobarRespuesta(formId, answerName, feedbackId, nextQuestionId, answerClass) {
    document.getElementById(formId).addEventListener("change", function() {
        var selectedAnswer = document.querySelector(`input[name="${answerName}"]:checked`);
        var feedbackElement = document.getElementById(feedbackId);
        var nextQuestionElement = document.getElementById(nextQuestionId);
        var answers = document.querySelectorAll(`.${answerClass}`);

        if (selectedAnswer) {
            var playerAnswer = selectedAnswer.value;
            var firstChar = playerAnswer.charAt(0);
            var isCorrect = (firstChar === '+');
            if (isCorrect) {
                feedbackElement.innerHTML = "Resposta correcta. Avançant a la següent pregunta...";
                nextQuestionElement.classList.remove("questionHidden");
                
                for (var i = 0; i < answers.length; i++) {
                    answers[i].disabled = true;
                }
            } else {
                feedbackElement.innerHTML = "Resposta incorrecta. Intenteu-ho de nou.";
            }
        } else {
            feedbackElement.innerHTML = "";
        }
        
    });
}