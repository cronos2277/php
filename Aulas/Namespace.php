<?php
/* 
    Aqui temos um exemplo de namespaces, repare que o var é o mesmo para os três namespaces.
    O nome dos namespaces principais devem estar referenciado antes de qualquer código, 
    ou seja não pode ter nenhum algoritimo antes do namespace principal, lembrando que
    essa regra não se aplica aos comentários, como é o caso aqui.
*/

namespace Principal;
    const constante = 0;
    class ClasseNomeLongo{
        public $atributo = "Fim De codigo";
    }

namespace Principal\Sub1;
    const constante = 1;
    function soma($a,$b):float{
        return $a + $b;
    }

namespace Principal\Sub2;
    const constante = 2;
    $var1 = "Minha Variavel";

//Nesse caso é pego a variável da ultima namespace declarada, no caso o valor 2.
echo "Valor do Namespace: ",__NAMESPACE__," -> ".constante; 
echo "\n";
//Acessando do namespace principal, resultado 0. 
echo "Valor do Namespace: ","\Principal\constante"," -> ".\Principal\constante; 
echo "\n";

namespace Principal; //Aqui estamos voltando ao namespace principal.
echo "Valor do Namespace: ","\Principal\constante"," -> ".Sub1\constante; 
/*
"\" na frente do namespace, acessa o caminho absoluto, e a ausência do "\",
significa caminho relativo.
\Principal\Sub2\constante => Acessa a variável constante, dentro do subnamespace
Sub2, que por fim está dentro do Namespace "Principal".
Principal\Sub2\constante => Procura pela "constante" dentro da Sub2, que está
dentro do Principal, que por sua vez está dentro do namespace atual.
Resumindo o caminho absoluto acessa o exato namespace informado, já o caminho
relativo, coloca o Path do namespace atual na frente do namespace, quando for
procurar por esse valor, eis ai a diferença.
*/
echo "\n";
/*
Essa é a sintaxe ao qual você pode usar para usar um alias para um valor de outro
namespace, por padrão o PHP vai pegar o "constante" do ultimo namespace chamado,
porém quando você usa o "USE", você cria um alias para um valor que tenha o mesmo
nome em um namespace externo.
*/
use const \Principal\Sub2\constante as constante1; //Criando Alias para constante.
echo "Acessando o valor constante de namespace externa: ",constante1;
echo "\n";
use function \Principal\Sub1\soma as sunk; //Criando alias para função.
echo "chamando uma função com um alias próprio: ",sunk(2,2);
echo "\n";
use \Principal\ClasseNomeLongo as Classe; //Criando alias para Classe.
$obj = new Classe();
echo $obj->atributo;
//ou
echo "\n";
$obj2 = new \Principal\ClasseNomeLongo();
echo $obj2->atributo;