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
### PHP com valores Flutuantes.
`echo PHP_FLOAT_MAX;` *Valor maximo para um float.*

`echo PHP_FLOAT_MIN;` *Valor minimo para um float.*


#### A Notacao E.
**informa quantos zeros tem a esquerda ou a direita de um numero de ponto flutuante.**

`echo 1e4;` *notacao "e", nesse caso 4 zeros a direita, logo temos: Dez mil.*

`echo 1e-4;` *notacao "e", nesse caso 4 zeros a esquerda, logo temos: 0.0001.*

**Repare que o que difere a notacao "e" do valor 14, é justamente a presença do valor 0x na frente do numero.**

`0xee` *=> Número 237.*

`echo 12.34e5;` *=> 1234000.*

## Strings
**O PHP tem problemas com a codificacao UTF-8 e pode acontecer de fazer as contagens de Strings de maneira errada.**

`$valor="qualquer String é";` *A variavel usada de referencia aqui.*

`var_dump($valor);` *O vardump pode contar uma string a mais para cada acento colocado, por exemplo "é" pode ser contado como 2 caracteres devido o acento, resultado:* `string(18);`

`strlen($valor)` *conta uma quantidade de string, mas usando a codificação antiga, podendo ocorrer o problemas acima, o resultado será "18".*

`mb_strlen($valor);` ou `mb_strlen($valor,"UTF-8")` *Por padrao usa uma codificação mais moderna evitando esse erro de contagem, o resultado será "17". Você pode estipular o padrão de codificação na contagem.*

`strtolower($valor);` *Coloca todas os caracteres para minusculos, podendo ter algum problema com acentos, resultado: "qualquer string �".*

`strtoupper($valor);` *Coloca todos os caracteres em maiusculo, podendo dar algum problema dependendo do caso com os acentos. Resultado: "QUALQUER STRING é" .*

`ucfirst($valor)` *Todos os primeiro caractere de cada palavra em maiusculo, resultado: "Qualquer String é"*

`ucwords($valor)` *Apenas o primeiro caractere da primeira palavra em maiusculo, resultado: "Qualquer String é"*

**Para resolver qualquer problemas com codificacao do UTF-8 use o "mb_" na frente da funcao, colocando como segundo parametro a codificacao, dessa forma evita esse problema.**

**Ao invés de "strlen($valor)" use "mb_strlen($valor), assim como ao inves de strtolower($valor) e strtoupper($valor), use mb_strtolower($valor) e mb_strtoupper($valor)". Em termos gerais as funcões com mb_ na frente são modernizações dessas funções.**

Lembrando que o segundo parametro sao opcionais para as 3 funcoes, e por padrao elas usam a codificacao moderna, porem se quiser garantir use informe a codificacao no segundo paremetro.

## Booleano
**No caso do boleano você pode transformar qualquer valor um boleano de três formas básicas, dando um cast, negando ou dupla negação.**

### Exemplos
`echo (bool) 1;` *Vai imprimir true. CAST*

`echo !1;` *Vai imprimir false. NegaçãoS*

`echo !!1` *Vai imprimir true, pois está negando a negação, logo esta afirmando. dupla negação.*

Zero é o unico numero seja ele em formato de ponto flutuante ou não que quando String vira falso, qualquer outro número é verdadeiro quando convertido.

Strings vazias(String com espaço não é vazia, digo "" ou ''), são falsas, ou strings contendo um e apenas um zero, por exemplo "0" ou '0', no caso "00" seria verdadeiro.

Existe as funções "is_" que verificam, retornando um verdadeiro caso o dado seja daquele tipo, por exemplo is_bool($dado) se  conteudo de $dado for booleano retornará true, senão false.
assim como temos o is_bool, temos o is_int, is_string, is_array, etc...




