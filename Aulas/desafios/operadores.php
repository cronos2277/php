<?php
$terca = true;
$quinta = true;

if($terca && $quinta){
    echo "tomar sorvete e comprar TV de 50";
}else if($terca || $quinta){
    echo "tomar sorvete e comprar TV de 32";
}else{
    echo "ficar em casa mais saudavel";
}