<?php
function fatorial(int $numero):int {
    if($numero < 2){
        return 1;
    }else{        
        return $numero * fatorial($numero - 1);
    }
}

echo fatorial(3);