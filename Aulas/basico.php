<?php 
//PHP Com valores Inteiros.
echo PHP_INT_MAX; #Valor maximo para um inteiro.
echo "<br>";
echo PHP_INT_MIN; #Valor minimo para um inteiro.
echo "<br>";
echo 77; # Sem zero a esquerda, o numero eh decimal, valor "77".
echo "<br>";
echo 077; # Com zero a esquerda, o numero eh em base Octal, valor "63".
echo "<br>";
echo 0b1111; #Com 0b o numero esta em base binaria, valor "15".
echo "<br>";
echo 0x1ABcafe9; #com 0x o PHP interpreta como hexadecimal, o valor eh: "448573417"
echo "<br>";

//PHP Com valores Float.
echo PHP_FLOAT_MAX; #Valor maximo para um float.
echo "<br>";
echo PHP_FLOAT_MIN; #Valor minimo para um float.
echo "<br>";

# A Notacao E informa quantos zeros tem a esquerda ou a direita de um numero de ponto flutuante.
echo 1e4; #notacao "e", nesse caso 4 zeros a direita, logo temos: Dez mil.
echo "<br>";
echo 1e-4; #notacao "e", nesse caso 4 zeros a esquerda, logo temos: 0.0001.
echo "<br>";

# Aqui abaixo temos um exemplo de uma funcao anonima, podendo atribuir a mesma dentro de uma variavel.
$anonima = function($a="valor Padrao"){  # Nesse caso o argumento tem um valor padrao.
    echo "Exemplo de funcao Clousure, com $a";
};
$anonima(); # A funcao anonima deve ser chamada dessa forma.