<?php 
//Quando o php analizar esse arquivo, vai perceber que 
//existe uma função __autoload lá dentro.
require_once "autoload.php";

$exibir1 = new Exibir1();
$exibir1->exiba();
echo "<br>";
$exibir2 = new Exibir2();
$exibir2->exiba();
