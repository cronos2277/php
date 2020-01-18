<?php
/*
    Essa classe cria um formulário, é com uma classe desse tipo que o zend ja deixa
    prontinho um formulario para cadastro.
    Para mais informações: https://docs.zendframework.com/zend-form/
*/

namespace Modulo\Form;
use Zend\Form\Form; //Essa classe renderiza um <form>
use Zend\Form\Element\Hidden; //Cria um campo hidden.
use Zend\Form\Element\Text; //Cria um campo do tipo de texto.
use Zend\Form\Element\Submit; //Cria um botão submit.
class ModuloForm extends Form{
    public function __construct(){
        /*
            Pense nesse objeto como sendo o <form> o primeiro
            parametro eh o nome, ou seja como ele sera refenciado.
            e o segundo um array, estilo chave e valor contendo os
            atributos que tem um formulario, tipo ali voce poderia 
            colocar coisas como... 
            parent::__construct('modulo',['method'=>'post','action'=>'acao',onsubmit='true']);
            isso geraria
            <form method='post',action='acao',onsubmit='true'>
            </form>  
        */
        parent::__construct('modulo',[]);  
        //equivale a <input type='hidden' />
        $this->add(new Hidden('id')); //O ID aqui sera criando como um campo hidden
        //Tanto as data como o valor serao criado como String
        //equivale a <input type='text' label='valor'/>
        $this->add(new Text('valor',['label' => 'Valor']));  
        //equivale a <input type='text' label='Dados de Registro'/>
        $this->add(new Text('dataRegistro',['label' => 'Dados de Registro']));  
        //Aqui criamos um campo do tipo submit.
        $submit  = new Submit('submit');
        /*
            O metodo setAttributes permite setar varios atributos de uma so vez.
            o mesmo deve ser estruturado dentro de um array como o exemplo abaixo.
            Nao confundir o setAttributes() com o setAttribute(), o que tem um 's'
            no final permite um array para a configuracao de elementos criados, como
            o abaixo.
        */
        //equivale a <input type='submit' id='submitButton' value='Save'/>
        $submit->setAttributes(['value' => 'Save','id' => 'submitButton']);  
        //O metodo add eh adicionado ao formulario.      
        $this->add($submit);        
    }
}
/*
    Esse objeto equivale ao formulario, ou seja ele seria a tag <form>, e os atributos
    criado dentro do construtor, uma vez que o construtor seja executado os componentes
    sao montados. Ao instanciar cada componente, voce informa o nome do componente como
    um primeiro parametro e depois disso um array contendo a configuração de outros parametros,
    pense nesse parametros como sendo os parametros html, style, id, class, etc... todo
    o que estiver no array quando o objeto for instanciado, assim como o array passado como
    parametro do setAttibutes, ambos seguem a logica dos atributos do html.
    O metodo add(), adicione esse componente criado a esse objeto criado, repare que tudo acontece
    no construtor que eh um metodo estatico, chamado na hora da instanciacao de um objeto.  
*/