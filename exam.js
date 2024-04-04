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
    if (title == ""){
        alert("Please enter a title");
    }
    else{
        responsestxt.forEach(function(response){
            formData.append(response.name, response.value);
        })
        var radio = qContainer.querySelectorAll('input[type="radio"]:checked');
        radio.forEach(function(radio) {
            formData.append(radio.name, radio.value);
        });
        formData.append('index', index);

        formData.append('title', title);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "submitexam.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // send to home or pop up box
                //document.getElementById("error").insertAdjacentHTML("beforeend", xhr.responseText);
                alert("Test/quiz Submitted");
                window.location.href = "/education/teachers_page.php";
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