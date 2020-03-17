<?php
class Form{
	private $nome;
	private $idade;
	private $email;
	public function __construct($nome,$idade,$email){
		$this->nome = $nome;
		$this->idade = $idade;
		$this->email = $email;
	}
	public function __destruct(){
		echo "<br>";
		echo $this->nome." foi salvo. Idade = ".$this->idade.", email = ".$this->email;
	}
}

/*
	"filter_input(INPUT_METODO,'O elemento do array $_POST $_GET ou do $_REQUEST','O Tipo de sanatização a ser feito')"
	essa função, passado os devidos parametros ele sanitiza os dados que o usuário insere, evitando ataques do tipo SQL Injection, por exemplo.
	"filter_var($variavel, Enum do filtro)"
	essa função retorna booleano analizando se a variavel contem valor válido de acordo com o filtro analisado.
*/

if(isset($_POST['envio']) && !empty($_POST['envio'])){
	$nome = filter_input(INPUT_POST,'nome',FILTER_SANITIZE_SPECIAL_CHARS); //Sanitiza o valor recebido pelo post do elemento name, aceita caracteres validos para uma string normal tirando delas qualquer caracter inválido que possa dar um SQL Injection.
	$idade = filter_input(INPUT_POST,'idade',FILTER_SANITIZE_NUMBER_INT); //Saniza para um inteiro, devolve um inteiro válido.
	$email = filter_input(INPUT_POST,'email',FILTER_SANITIZE_EMAIL); //Devolve um email válido.
	if(!filter_var($idade,FILTER_VALIDATE_INT)){echo "<br>IDADE INVÁLIDA!";} //Verifica se a idade informado pelo usuário é um inteiro.
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){echo "<br>E-MAIL INVÁLIDO!";} //Verifica se o e-mail é válido.
	$form = new Form($nome,$idade,$email);

}else{
?>
<html>
	<head><title>Form</title></head>
	<body>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
			<div><label for='nome'>Nome</label> <input id='nome' name='nome' type='text' style='margin-left:1%'></div><br>
			<div><label for='idade'>Idade</label><input id='idade' name='idade' type='text' style='margin-left:1%'></div><br>
			<div><label for='email'>Email</label><input id='email' name='email' type='text' style='margin-left:1%'></div><br>
			<div><input type="submit" name="envio" value="Enviar!" style='margin-left:5%'/></div>
		</form>
	</body>
</html>
<?php } ?>
