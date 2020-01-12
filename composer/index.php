<?php
require 'vendor/autoload.php';
//Carregando do classmap
$objeto = new SEU_NAME_SPACE\Classe();
$objeto->exibir();
echo "<br>";
//PSR4
$objeto2 = new App\Index();
$objeto2->exiba();
echo "<br>";
$objeto3 = new App\Subdir\SubIndex();
$objeto3->exiba();
echo "<br>";
