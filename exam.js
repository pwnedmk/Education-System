function qRequest(qType, index){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "exam.php?qType=" + qType + "&index=" + index, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("qContainer").insertAdjacentHTML("beforeend", xhr.responseText);
        }
    };
    xhr.send();
}

var index = 0;
document.getElementById("addMC").addEventListener("click", function() {
    index++;
    qRequest("MC", index);
});

document.getElementById("addFIB").addEventListener("click", function() {
    index++;
    qRequest("FI", index);
});

document.getElementById("addEssay").addEventListener("click", function() {
    index++;
    qRequest("ES", index);
});
document.getElementById("submitE").addEventListener("click", function() {
    var formData = new FormData();
    var qContainer = document.getElementById("qContainer");
    var responsestxt = qContainer.querySelectorAll("input[type='text']");
    var title = document.getElementById("addTitle").value;
    var date = document.getElementById("date").value;
    console.log(date);
    var parsedDate = parseDate(date);
    console.log(parsedDate);
    var timeHR = document.getElementById("dueHour").value;
    var timeMIN = document.getElementById("dueMin").value;
    var ampm = document.getElementsByName("ampm");
    if (parsedDate == "" || timeHR == "" || timeMIN == ""){
        alert("Please enter a due date/time");
    }
    else if (title == ""){
        alert("Please enter a title");
    }
    else{
        ampm.forEach(function(ampm){
            if (ampm.checked){
                formData.append(ampm.name, ampm.value);
            }
        });
        responsestxt.forEach(function(response){
            formData.append(response.name, response.value);
        })
        var radio = qContainer.querySelectorAll('input[type="radio"]:checked');
        radio.forEach(function(radio) {
            formData.append(radio.name, radio.value);
        });
        formData.append('index', index);
        formData.append('title', title);
        formData.append('date', parsedDate);
        formData.append('dueHour', timeHR);
        formData.append('dueMin', timeMIN);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "submitexam.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // send to home or pop up box
                document.getElementById("error").insertAdjacentHTML("beforeend", xhr.responseText);
                //alert("Test/quiz Submitted");
                //window.location.href = "/edusys4/teacher_page.php";
            }
        };
        xhr.send(formData);
    }
});
function DelQ(index1) {
    var question = document.querySelector(`.qnas[index='${index1}']`);
    if (question) {
        question.remove();
    }
}
document.getElementById("home").addEventListener("click", function (){
    if (confirm("Are you sure you want to go back?\nYou will lose all progress on this quiz") == true){
        window.location.href = "/edusys4/teacher_page.php"
    }
});
function parseDate(date){
    var parsedDate = date.split("/");
    var fullDate = "";
    fullDate += parsedDate[2];
    fullDate += "-";
    fullDate += parsedDate[0];
    fullDate += "-";
    fullDate += parsedDate[1];
    return fullDate;
}