document.addEventListener("DOMContentLoaded", function() {
    const publishButton = document.getElementById("publish");
    publishButton.addEventListener("click", function(){
        publishButton.disabled = true;
    });
});