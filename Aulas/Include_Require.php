<?php
//Você pode colocar o valor retornado de algum arquivo importado dentro de uma variável.
$retorno = include_once('.support/example_aux.php');
echo $retorno;

/*
    O require_once, assim como o include_once importam o arquivo apenas uma vez, e caso
    a importação ja tenha sido feita o mesmo não é feito, diferente da outra função sem  
    o once que faz novamente a importação, setando as variaveis para os valores padrões
    que está definindo no arquivo original e podendo dar erro, uma vez que o PHP tentará
    redeclara métodos. Se usar o sem _once no arquivo a ser importado, ou use a função 
    "function_exists('NomeDoMetodoASerAvaliadoSeExisteOuNao')" para evitar redeclaração,
    de método e consequentemente um erro devido a isso, ja com variáveis não tem problema
    redeclarar, lembrando: Função com o _once não importa duas vezes, a sem importa e redeclara,
    por redeclarar, isso pode dar erro nos métodos se não houver um tratamento e variáveis com
    valores padrões.
*/
function carregar(){
    require_once('.support/example_aux.php');
    /*
        Você pode importar dentro de uma função ou método, nesse caso as variáveis terão o
        escopo local e as funções terão um escopo global. Lembrando que essa importação
        apenas ocorrerá quando a função ou método for invocada.
    */
}
carregar(); //imports dentro de funções e métodos, ocorrem após a invocação.
/*
    Require => da uma falha critica e interrompe a execução do código posterior.
    Include => da apenas um aviso de que o arquivo não foi encontrado, sem interromper a execução.
    Se o arquivo a ser carregado for crítico a aplicação, vale a pena usar o require,
    caso não convém usar o include. Lembrando que o require não retorna valor quando não
    encontra o arquivo, ou seja para armazenar o valor retornado de um import pode ser
    interessante usar o include. Exemplo: 
    $retorno = include_once('.support/example_aux.php'); //Se não existir o arquivo retorna um false.
    $retorno = require_once('.support/example_aux.php'); //Se não existir o arquivo, lança um erro.
    Agora, se o arquivo existir, caso haja algum return no escopo global ele retorna o valor que o
    return do escopo global está retornando, ou se não ele retorna o número 1, caso o include ou
    o require não tenham um retorno e consigam sem problemas incluir arquivos, então ele retorna 1,
    que significa também verdadeiro no PHP 
    */