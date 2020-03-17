# PHP Basico
## Integer
### PHP Com valores Inteiros.
`echo PHP_INT_MAX;` *Valor maximo para um inteiro.*

`echo PHP_INT_MIN;` *Valor minimo para um inteiro.*

`echo 77;` *Sem zero a esquerda, o numero eh decimal, valor "77".*

`echo 077;` *Com zero a esquerda, o numero eh em base Octal, valor "63".*

`echo 0b1111;` *Com 0b o numero esta em base binaria, valor "15".*

`echo 0x1ABcafe9;` *Com 0x o PHP interpreta como hexadecimal, o valor eh: "448573417".*


## Float
### PHP com valores Inteiros
`echo PHP_FLOAT_MAX;` *Valor maximo para um float.*

`echo PHP_FLOAT_MIN;` *Valor minimo para um float.*


#### A Notacao E.
_informa quantos zeros tem a esquerda ou a direita de um numero de ponto flutuante._

`echo 1e4;` *notacao "e", nesse caso 4 zeros a direita, logo temos: Dez mil.*

`echo 1e-4;` *notacao "e", nesse caso 4 zeros a esquerda, logo temos: 0.0001.*

_Repare que o que difere a notacao "e" do valor 14, é justamente a presença do valor 0x na frente do numero._

`0xee` *=> Número 237.*

`echo 12.34e5;` *=> 1234000.*
