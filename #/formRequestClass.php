<?php
/*
O array request contem dados do $_GET $_REQUEST e do $_SERVER, priorizando os valores do get depois do Post e por fim do cookies.
*/

abstract class Metodos{
	protected static $request;
	abstract public static function getRequest();
	abstract public static function setRequest($param);
}

class Classe extends Metodos{
	public static function setRequest($param){
		parent::$request = $param;
		echo "<br>";
	}

	public static function getRequest(){
		return parent::$request["metodo"];
	}
	public static function show(){
		foreach(parent::$request as $key=>$req){
			echo "<br>Indice: ".$key;
			echo "<br>Valor: ".$req;
		}
	}
}

if(isset($_REQUEST['enviar']) && !empty($_REQUEST['enviar'])){
	Classe::setRequest($_REQUEST);
	Classe::getRequest();
	Classe::show();
}else{
?>

<html>
	<head><title>REQUEST</title></head>
	<body>
		<form id="formulario" method="<?php 
			if(!isset($_GET['s'])){echo 'get';}
			else if($_GET['s'] == 'POST'){echo 'post';}
			else if($_GET['s'] == 'COOKIE'){echo'cookie';}
			else if($_GET['s'] == 'GET'){echo'get';}
		?>" action="<?php echo $_SERVER['PHP_SELF']; ?>">
			<input type="text" name="valor" />
			<select name="metodo" onchange="window.location.href='formRequestClass.php?s='+this.value;">
				<option value="GET">GET</option>
				<option value="POST">POST</option>
				<option value="COOKIE">COOKIE</option>
			</select><br>
			<input type="submit" value="enviar" name="enviar"/>
		</form>
	<body>
</html>

<?php } ?>
