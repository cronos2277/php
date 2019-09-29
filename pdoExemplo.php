<?php
//Para a criação de um novo objeto PDO temos que passar 3 parametros para o construtor.
//para se conectar ao banco de dados, use esse padrão
$database ="mysql:host=localhost;dbname=test"; //"SGBD:host=IP;dbname=Nome do banco de dados
$user="root"; //Usuário.
$password=""; //senha
try{
	//Atributos para a criação de um novo PDO.
	$pdo = new PDO($database,$user,$password);
	
	//Esse modo ativa a exibição de qualquer erro de conexão envolvendo PDO.
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	//esse método recebe uma String e a executa quando conectado com o banco de dados da maneira que foi informado.
	$statement = $pdo->query('select * from test'); //esse método retorna um objeto statement.
	
	//Esse método do que o statement criado acima contém 
	$statement->execute();
	$rows = $statement->rowCount(); //esse método retorna o número de linhas.
	
	//Aqui a String é preparada para ser executada no banco de dados, porém aqui tem uma preparação, substituido :atributo pelo valor correspondente
	$insertNew = $pdo->prepare("insert into test values(:id,:nome)");
	$insertNew->bindValue(":id",$rows + 1); //substitui o :id pela quantidade total de emails + 1.
	$insertNew->bindValue(":nome",substr(md5(microtime()),1,rand(8,12))); //substitui :nome por strings aleatória.
	$insertNew->execute(); //executando
	//$statement->fetchAll() retorna um array contendo o resultado dessa query, $pdo->query('select * from test'); 
	print_r($statement->fetchAll());
}catch(PDOException $error){ //PDOException serve para tratar qualquer erro que o PDO gere.
	 echo $error->getMessage();
}


echo "<br>tudo certo até aqui!<br>";

?>
