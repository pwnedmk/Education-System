<?php
$type = $_GET["qType"];
$index = $_GET["index"];
$questionHtml = typeCase($type, $index);
echo $questionHtml;
function typeCase($qT, $index){
    if ($qT == "MC"){
        return "<div class='qnas' index=$index>Multiple Choice Question: <input type='text' name='" . $qT . "fq[" . $index . "]' placeholder='Enter your question'><button class='Del' onclick='DelQ($index)'>X</button>
        <br> Select Correct Answer: <br>
        <label for='" . $qT . $index . "a'>A</label>
        <input type='radio' name='" . $qT . "a[" . $index . "]' value='1'>
        <input type='text' name='" . $qT . "q[" . $index . "][]' placeholder='Enter answer for A'><br>
        <label for='" . $qT . $index . "b'>B</label>
        <input type='radio' name='" . $qT . "a[" . $index . "]' value='2'>
        <input type='text' name='" . $qT . "q[" . $index . "][]' placeholder='Enter answer for B'><br>
        <label for='" . $qT . $index . "c'>C</label>
        <input type='radio' name='" . $qT . "a[" . $index . "]' value='3'>
        <input type='text' name='" . $qT . "q[" . $index . "][]' placeholder='Enter answer for C'><br>
        <label for='" . $qT . $index . "d'>D</label>
        <input type='radio' name='" . $qT . "a[" . $index . "]' value='4'>
        <input type='text' name='" . $qT . "q[" . $index . "][]' placeholder='Enter answer for D'><br>
        </div>";

    }
    elseif ($qT == "FI"){
        return "<div class='qnas' index=$index>Fill in the Blank Question: <input type='text' name='" . $qT . "q[" . $index . "]' placeholder='Enter your question'><button class='Del' onclick='DelQ($index)'>X</button>
        <br><br> Answer: <input type='text' name='" . $qT . "a[" . $index . "]' placeholder='Enter an Answer'></div>";
    }
    elseif ($qT == "ES"){
        return "<div class='qnas' index=$index>Essay Question: <input type='text' name='" . $qT . "q[" . $index . "]' placeholder='Enter your question'><button class='Del' onclick='DelQ($index)'>X</button>
        </div>";
    }
}
?>