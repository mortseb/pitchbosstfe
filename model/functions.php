<?php 
function getRatingColor($rating) {
    if ($rating >= 1 && $rating <= 19) {
        return '#FF3131';
    } elseif ($rating >= 20 && $rating <= 39) {
        return '#FF5757';
    } elseif ($rating >= 40 && $rating <= 59) {
        return '#FFBD59';
    } elseif ($rating >= 60 && $rating <= 69) {
        return '#C1FF72';
    } elseif ($rating >= 70 && $rating <= 79) {
        return '#7ED957';
    } elseif ($rating >= 80 && $rating <= 89) {
        return '#00BF63';
    } elseif ($rating >= 90 && $rating <= 100) {
        return '#5CE1E6';
    } else {
        return '#ccc';
    }
}

?>