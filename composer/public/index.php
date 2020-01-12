<?php
namespace SEU_NAME_SPACE;
class Classe{
   private $mensagem = "Classe carregou sem chamando o apelido do namespace";
    final public function exibir(){
        echo $this->mensagem;
    }
} 
