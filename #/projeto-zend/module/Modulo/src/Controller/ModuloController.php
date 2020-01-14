<?php
namespace Modulo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//Recomenda-se extender AbstractActionController ou alguma classe
//como essa ou implementar uma interface com essa funcionalidade, 
//para que seja feito coisas como tratamento de errose etc... 
class ModuloController extends AbstractActionController{
    /* 
        Todo o metodo controller deve retornar uma view.
        Esse eh o metodo que esta la nas configuracoes de rotas,
        mencionado como index.
    */
    public function indexAction()
    {
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
}
/*
    Essa eh a classe que eh mencionada nas rotas padrao la no 
    module.config.php. Novamente segue o padrao PSR4 no Zend 3.
*/