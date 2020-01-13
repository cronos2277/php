<?php
namespace PSR4\Subdir;
class SubIndex{
    private $mensagem = "Exibindo usando o PSR4 como load, dentro do subdiretorio subdir, o arquivo index.php";
    public function exiba(){
        echo $this->mensagem;
    }
}
