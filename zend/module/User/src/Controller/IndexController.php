<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function registerAction()
    {
        return new ViewModel();
    }
    public function recoveredPasswordAction()
    {
        return new ViewModel();
    }
    public function newPasswordAction()
    {
        return new ViewModel();
    }
    public function confirmedEmailAction()
    {
        return new ViewModel();
    }
}
/*
    Todas as acoes deve terminar com action, 
    do contrario o Zend ira interpretar como
    um metodo comum. Toda a acao eh referente
    a uma view, ou seja cada acao aqui vai ter
    a sua propria view. Outra coisa, o zend vai 
    procurar pelos seguintes arquivos: 
    'confirmed-email.phtml','new-password.phtml',
    'recovered-password','register.phtml', repare
    que o zend ele coloca um hifen no nome dos 
    arquivos quando tem camel case, ou seja 
    uma action aqui chamado de minhaZendAction,
    se transforma no arquivo 'minha-zend.phtml'.
*/