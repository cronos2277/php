# PHP Basico
## Habilitando erros no PHP.

**Ao colocar esse comando no arquivo php, assim que carregado, os erros serão exibidos, desabilite depois de necessário em ambiente de produção.**

    `ini_set('display_errors',1);
    ini_set('display_startup_erros',1);
    error_reporting(E_ALL);`

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

## Array

`$meuArray = [0,1,2,3,4,5,6,7,8,9];` *O Array a ser usado no exemplo.*

*o operador "..." ele tem duas funções, ou junta tudo ou separa tudo.*

`function somarTudo(int ...$valores){` *Aqui tudo é juntado, ou seja todos os parametros dentro de um array.*

    `$resultado = 0;`

    `foreach($valores as $valor){`

        `$resultado += $valor;`    

    `}`

    `return $resultado;`   

`}`

*Aqui é pego o array acima e espalhado ele, no caso ao invés de ser passado um array, se é passado cada valor individualmente, no caso eh passado 10 parametros separados ao inves de um único array com esse operador abaixo, se ele vai espalhar um array, ou juntar valores em um array, como no exemplo acima, tudo depende do contexto.*

`echo somarTudo(...$meuArray);`

## Funções

### Função Anonima
Aqui abaixo temos um exemplo de uma funcao anonima, podendo atribuir a mesma dentro de uma variavel.

    `$anonima = function($a="valor Padrao"){` //Nesse caso o argumento tem um valor padrao.

        `echo "Exemplo de funcao Clousure, com $a";`

    `};`

    `$anonima();` //A funcao anonima deve ser chamada dessa forma.

### Função Tipada

*voce pode definir o tipo de dados de entrada e ou o tipo de dado de saida, a sintaxe eh semelhante ao do Typescript. Caso o valor de entrada nao seja do tipo especificado, o PHP fara um cast transformando-a no tipo especificado, nesse exemplo o PHP converterá o valor para inteiro quando entrar e convertera o valor para float na saida, a garantia existe e caso o dado de saida ou entrada nao seja esse, havera um cast.*

    `function comParametros(int $a, int $b):float{`
        `return $a/$b;`
    `}`

    `echo comParametros(4,3);` //Chamando a funcao acima

### Array Map e Filter

 `$meuArray = [0,1,2,3,4,5,6,7,8,9];` *Esse é o array que será analisado.*

 **Função Par.**

    `$par = function($arg){
        if($arg % 2 == 0){
            return true;
        }else{
            return false;
        }
    };`

**Usando o array_filter.**

`$pares = array_filter($meuArray,$par);` *Nessa função você passa o array e a função nessa ordem.*

**Saida com o print_r() do array_filter, repare que a mesma retorna apenas os valores selecionados.**

    `Array
    (
        [0] => 0
        [2] => 2
        [4] => 4
        [6] => 6
        [8] => 8
    )`

**Agora a função Impar.**

    `$impar = function($arg){
        if($arg % 2 != 0){
            return true;
        }else{
            return false;
        }
    };`

**Usando o array_map**

`$impares = array_map($impar,$meuArray);` *Nessa função os parametros são invertidos se comparado com o array_filter, no caso a função e o array como parametro como parametros nessa ordem.*

**Saida com o print_r() do array_filter, repare que a função retorna retorna o exato mesmo valor do return.**

    `Array
    (
        [0] => 
        [1] => 1
        [2] => 
        [3] => 1
        [4] => 
        [5] => 1
        [6] => 
        [7] => 1
        [8] => 
        [9] => 1
    )`

