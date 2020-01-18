<?php
namespace Modulo\Controller;

use Modulo\Form\ModuloForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Modulo\Model\Modelo;
//Recomenda-se extender AbstractActionController ou alguma classe
//como essa ou implementar uma interface com essa funcionalidade, 
//para que seja feito coisas como tratamento de errose etc... 
/*
    O nome desse arquivo se chama ModuloController.php, logo
    o nome que vem antes do sufixo Controller, eh o que determina
    a nomeacao da pasta, se fosse por exemplo AplicacaoController,
    a pasta das view estaria em modulo/src/view/modulo/aplicacao, 
    lembrando que esse view esta no mesmo nivel hierarquico de diretorio
    que a pasta src, ambos dentro da pasta do modulo. 
*/
class ModuloController extends AbstractActionController{
    /* 
        Todo o metodo controller deve retornar uma view.
        Esse eh o metodo que esta la nas configuracoes de rotas,
        mencionado como index.
    */

    private $table;

    public function __construct($table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {         
        
        //rota http://URL:porta/modulo
        //regras de negocio...   
        /*
            Aqui temos um exemplo de como passar parametro, quando
            for instanciado uma view, o mesmo deve seguir o padrão
            de array, no caso temos o modelo, que vai passar todos
            os valores retornado com o metodo getAll();
            A chave desse array estará disponível como variável
            lá no view, para pode ser usado como objeto la no
            phtml, contendo os valores passados aqui no array.
            Logo lá na view terá um objeto chamado $modulo, que
            terá os valores de: $this->table->getAll();
        */     
        return new ViewModel(['modulo' => $this->table->getAll()]);
        /*
            Quando voce nao passa nenhum parametro dentro
            desse novo objeto ViewModel acima, o Zend
            entende que o View a ser renderizado tem o 
            mesmo nome do metodo, subtraindo do Action,
            nesse caso index.
        */
    }
    public function addAction()
    {
        //rota http://URL:porta/modulo/add
        // Arquivo de view: modulo/src/view/modulo/modulo/add.phtml
        /*
            Aqui esta o add action, que pode ser acessado
            na seguinte URL, localhost:porta/modulo/add,
            repare que esta sub-rota nao esta cadastrada
            no 'module.config.php', justamente por ser uma 
            sub-rota nao se faz necessario cadastrar a 
            sub-rota la, e repare tambem que abaixo existe 
            a chamada para view tambem. No caso como tambem
            nao eh passado parametro, sera procurado um arquivo
            chamado add.phtml dentro de 
            /view/[pasta-modulo-nome]/[pasta-controller-nome]
            seguindo essa ordem claro. Lembrando que como 
            o nome desse arquivo eh ModuloController.php, logo
            a pasta que o mesmo espera receber na pasta de
            controller, se chama Modulo.

        */
        //Instanciando um formulario, No caso ModuloForm();
        $form = new ModuloForm(); 
        //Aqui eh pego um elemento com o id informado no get, e seta um novo valor chamado 'add'.
        $form->get('submit')->setValue('Add');
        //Aqui eh pego uma requisicao, as classes ou metodos superiores a esse tratam a requisicao,
        //e o AbstractActionController te permite acesso a requisicao através desse metodo abaixo.
        $request = $this->getRequest();        
        if(!$request->isPost()){ //O metodo isPost() verifica se o array $_POST[] esta vazio.
            //Caso o array post esteja vazio, será renderizado o formulario. aqui e codigo para de ser executado aqui.
            //O ViewModel vai criar uma variavel form, colocando nela os valores do $form daqui.
            return new ViewModel(['form' => $form]);
        }
        $modulo = new Modelo();
        //Caso o codigo continue, a requisicao sera inserida dentro do objeto $form usando o metodo setData(),
        //Pegando os valores da requisicao, tendo um metodo abaixo que peda dados do metodo Post, com o getPost();
        $form->setData($request->getPost());
        //O metodo isValid() faz as verificacoes para ver se o formulario eh valido do dados inserido através do metodo
        //setData() acima. A validacao verica se os dados sao validos com os tipos de dados definidos no ModuloForm.        
        if(!$form->isValid()){ 
        //Caso os dados nao sejam validos, entramos novamente no formulario, enterrompendo o codigo aqui.
        //O ViewModel vai criar uma variavel form, colocando nela os valores do $form daqui.
            return new ViewModel(['form' => $form]);
        }
        $modulo->exchangeArray($form->getData());
        $this->table->save($modulo);
        //Aqui estamos trabalhando com rotas. Se tudo certo o usuario eh redirecionado para a rota 'modulo',
        //Essas rotas são definidos no arquivo 'modulo.config.php'
        return $this->redirect()->toRoute('modulo');
    }
    public function saveAction(){
    //rota http://URL:porta/modulo/save   
    // Arquivo de view: modulo/src/view/modulo/modulo/save.phtml
        return new ViewModel();
    }
    public function editAction(){
    //rota http://URL:porta/modulo/edit    
    // Arquivo de view: modulo/src/view/modulo/modulo/edit.phtml
        return new ViewModel();
    }
    public function removeAction(){
    //rota http://URL:porta/modulo/remove    
    // Arquivo de view: modulo/src/view/modulo/modulo/remove.html
        return new ViewModel();
    }
    public function confirmAction(){
    //rota http://URL:porta/modulo/confirm    
    // Arquivo de view: modulo/src/view/modulo/modulo/confirm.phtml
        return new ViewModel();       
    }
}
/*
    Essa eh a classe que eh mencionada nas rotas padrao la no 
    module.config.php. Novamente segue o padrao PSR4 no Zend 3.
*/