document.addEventListener('DOMContentLoaded', function() {
    const submitButton = document.getElementById('submitS');
    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            event.preventDefault();
            console.log(1);
            const submitButton = document.getElementById('submitS');
            const examID = submitButton.getAttribute("exam-id");
            console.log(examID);
            var formData = new FormData();
            var qContainer = document.getElementById("qContainer");
            var inputs = qContainer.querySelectorAll("input[type='text'], input[type='radio']:checked");
            var timestamp = new Date().getTime();
            inputs.forEach(function(input) {
                formData.append(input.name, input.value);
            });
            console.log(formData);
            var xhr = new XMLHttpRequest();
            xhr.open("POST", `studentExamSubmit.php?examID=${examID}`, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // send to home or pop up box
                    //document.getElementById("error").insertAdjacentHTML("beforeend", xhr.responseText);
                    const responseData = JSON.parse(xhr.responseText);
                    const grade = responseData.grade;
                    console.log("Grade:" + grade);
                    const checkArray = responseData.checkQuestionIDs;
                    const queryToString = arrayToQueryString(checkArray);
                    const baseURL = '/edusys4/gradeExam.php';
                    const fullURL = `${baseURL}?${queryToString}&grade=${grade}&examID=${examID}`;
                    alert("Test/quiz Submitted");
                    window.location.href = fullURL;
                }
            };
            xhr.send(formData);
        });
    } else {
        console.error('Submit button not found');
    }
});
function arrayToQueryString(array) {
    return array.map((item, index) => {
        return `array[${index}]=${encodeURIComponent(item)}`;
    }).join('&');
}