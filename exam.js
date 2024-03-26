function qRequest(qType, index){
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "examnew.php?qType=" + qType + "&index=" + index, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            document.getElementById("qContainer").insertAdjacentHTML("beforeend", xhr.responseText);
        }
    };
    xhr.send();
}

var index = 0;
var bitmap = "";
document.getElementById("addMC").addEventListener("click", function() {
    index++;
    bitmap += "0";
    qRequest("MC", index);
});

document.getElementById("addFIB").addEventListener("click", function() {
    index++;
    bitmap += "1";
    qRequest("FI", index);
});

document.getElementById("addEssay").addEventListener("click", function() {
    index++;
    bitmap += "2";
    qRequest("ES", index);
});
document.getElementById("submitExam").addEventListener("click", function() {
    var formData = new FormData();
    var qContainer = document.getElementById("qContainer");
    var responsestxt = qContainer.querySelectorAll("input[type='text']");
    responsestxt.forEach("click", function(response){
        formData.append(response.name, response.value)
    })
    var radio = qContainer.querySelectorAll('input[type="radio"]:checked');
    radio.forEach(function(radio) {
        formData.append(radio.name, radio.value);
    });
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "submitexam.php?index=" + index + "&bitmap=" + bitmap, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Handle the response here
        }
    };
    xhr.send(formData);
});