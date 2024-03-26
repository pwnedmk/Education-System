<?php
$type = $_GET["qType"];
$index = $_GET["index"];
$questionHtml = typeCase($type, $index);
echo $questionHtml;
function typeCase($qT, $index){
    if ($qT == "MC"){
        return "<div class='qnas'> " . $index . ". Multiple Choice Question: <input type='text' name='" . $qT . "fq[" . $index . "]' placeholder='Enter your question'>
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
        </div><br><br>";

    }
    elseif ($qT == "FI"){
        return "<div class='qnas'> " . $index . ". Fill in the Blank Question: <input type='text' name='" . $qT . "q[" . $index . "]' placeholder='Enter your question'>
        <br><br> Answer: <input type='text' name='" . $qT . "a[" . $index . "]' placeholder='Enter an Answer'></div><br><br>";
    }
    elseif ($qT == "ES"){
        return "<div class='qnas'> " . $index . ". Essay Question: <input type='text' name='" . $qT . "q[" . $index . "]' placeholder='Enter your question'>
        </div><br><br>";
    }
}
?>