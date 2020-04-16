<?php
trait Trait1{
    public $var1 = "Variavel 1";    
}

trait Trait2{
    public $var2 = "Variavel 2";    
    public function exiba(){
        echo "\n","Chamando a função Exibir da Trait2","\n";
    }    
}

trait Trait3{
    public $var3 = "Variavel 3";      
    public function exiba(){
        echo "\n","Chamando a função Exibir da Trait3","\n";
    }
}
class Classe {
    //use Trait3; //Voce pode importar dessa forma, caso não tenha conflitos.
    use Trait1,Trait2,Trait3{
        //Tanto Trait2 assim como o Trait3, possuem o método exiba(). 
        //Aqui estamos dizendo, quando exibir for chamado, chame a do Trait2.
        Trait2::exiba insteadOf Trait3; 
        //E aqui damos um novo apelido a exiba do Trait3
        Trait3::exiba as metodoRedefinida;       
    }
    public function exemplo(){
        echo "A Classe está instanciando...";
    }
}
//Repare que apenas a Classe está sendo instanciada.
$objeto = new Classe;
//$var1 e $var2 não variáveis pegas das traits.
echo $objeto->var1, "\n",$objeto->var2,"\n",$objeto->var3,"\n";
$objeto->exiba(); //Aqui chama a função preferida na resolução de conflitos.
$objeto->metodoRedefinida(); //Essa função foi criada na hora que o conflito foi resolvido.
$objeto->exemplo();

/*
    Traits é uma forma de reuso do código, alternativo a Herança, enquanto a Herança
    serve para questões do tipo é um, ou seja a classe filha é do tipo classe Pai, 
    o Traits lida com a questão do contem. No exemplo, a classe contem o
    Traits1, Traits2 e Traits3. Você os implementa usando o use e resolve
    os conflitos caso tenha, colocando as regras dentro das chaves. Como por exemplo.
    --------------------------------------------------------------------------------
    Trait2::exiba insteadOf Trait3;  //Essa é a sintaxe
    ClasseFavorita::metodo insteadOf ClassePreterida;
    --------------------------------------------------------------------------------
    Após a sintaxe acima, voce pode ou não definir um outro Alias para o método preterido.
    --------------------------------------------------------------------------------
    Trait3::exiba as metodoRedefinida; //Essa é a sintaxe que pode ou não vir logo em seguida.
    ClassePreterida::metodo as novoNomeParaMetodo;
    --------------------------------------------------------------------------------
*/