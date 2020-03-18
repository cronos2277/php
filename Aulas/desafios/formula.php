<?php
/*
    $etapa1 = ((6*(3+2))**2)/(3*2); #certo
    $etapa2 = (((1-5)*(2-7))/2)**2; #certo
    $conjunto = (($etapa1 - $etapa2)**3)/(10**3);
    echo $conjunto;
*/

$a = 2; #padrao 2
$b = 3; #padrao 3
$c = 6; #padrao 6
$d = 1; #padrao 1
$e = 5; #padrao 5
$f = 7; #padrao 7
$g = 10; #padrao 10

$etapa1 = (($c*($b+$a))**$a)/($b*$a);
$etapa2 = ((($d-$e)*($a-$f))/$a)**$a;
$formula = (($etapa1 - $etapa2)**$b)/($g**$b);
echo $formula;