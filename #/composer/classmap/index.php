<?php
namespace SEU_NAME_SPACE;
class Classe{
   private $mensagem = "Classe carregou atraves do classmap do composer.json, esse eh o arquivo index.php, dentro da pasta public";
    final public function exibir(){
        echo $this->mensagem;
    }
} 
