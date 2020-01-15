<?php
namespace Modulo\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
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
    public function indexAction()
    { //rota http://URL:porta/modulo
        //regras de negocio...
        return new ViewModel();
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
        return new ViewModel();
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