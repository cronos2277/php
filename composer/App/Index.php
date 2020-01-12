namespace App;
class Index{
    private $mensagem = "Exibindo usando o PSR4 como load, dentro do diretorio PSR4, o arquivo index.php";
    public function exiba(){
        echo $this->mensagem;
    }
} 
