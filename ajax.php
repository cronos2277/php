<?php
header("Access-Control-Allow-Origin: *");
//Você precisa desse código acima, para que uma pagina PHP possa se comunicar com o ajax.

//mude esses dois valores abaixo para que o PHP comece a mostrar os erros.
 //1 to enable
 ini_set('display_errors',0);
 //1 to enable
 ini_set('display_startup_erros',0);
 error_reporting(E_ALL);

$defaultValue = "Default Value";
$callback = "Callback Value";
$nome_arquivo = 'text.txt';	
if(!isset($_POST['callback']) && empty($_POST['callback']) && isset($_GET['callback']) && !empty($_GET['callback'])){
	echo ($_GET['callback'] == 'callback') ? $callback : $defaultValue;
}

if(isset($_POST['callback']) && $_POST['callback'] == 'write'){	
	//a função fopen('nome do arquivo','modo de abertura') do PHP retorna um ponteiro para um arquivo.  
	$ponteiro_arquivo = fopen($nome_arquivo,'a+');
	//fwrite é a função que escreve os dados no arquivo. fwrite($ponteiro_arquivo,'dados a ser escrito');
	$escrita = fwrite($ponteiro_arquivo,$_POST['mensagem']);
	$result['mensagem']	= $escrita;
	//Após aberto com o fopen o mesmo deve ser fechado, para que os dados sejam salvos. fclose($ponteiro_arquivo);
	fclose($ponteiro_arquivo);
	if($result['mensagem']){
		$result['sucesso'] = "Escrita feito com sucesso!";
		$result['erro'] = '';
	}else{
		$result['erro'] = "Erro ao escrever!";
		$result['sucesso']= '';
	}
	//json_encode($objetoPHP) transforma um objeto em uma String com toda a estrutura em JSON.
	echo json_encode($result);
	
}

if(isset($_POST['callback']) && $_POST['callback'] == 'read'){	
	$content = false;
	//se existir o arquivo... file_exists($nome_arquivo) retorna se existe true, não existe false.
	if(file_exists($nome_arquivo)){	
		//se use o fopen para leitura também.	
		$leitura_ponteiro = fopen($nome_arquivo,"r");
		/*
		 * filesize($nome_arquivo) => retorna em bytes o tamanho do arquivo.
		 * A função fread le até a quantidade de bytes especificada no segundo parametro.
			a função fread($ponteiro, quantidade de bytes a serem lidos);
			* No caso a função lê o arquivo inteiro pois o segundo parametro é o tamnho do arquivo.
		 */
		$content = fread($leitura_ponteiro, filesize($nome_arquivo));
		//Leitura também precisa ser fechado depois de usado, lembre-se que enquanto esta aberto, isso fica na memória ram
		fclose($leitura_ponteiro);		
	}else{
		$result['erro'] = "Arquivo não existe!";		
	}
	
	$result['mensagem']	= $content;
	echo json_encode($result);
}
//Aqui você pega a url atual. $_SERVER[HTTP_HOST] => dominio, $_SERVER[REQUEST_URI] => Pagina.
$URL_ATUAL= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<?php if((!isset($_POST['callback']) && empty($_POST['callback'])) && (!isset($_GET['callback']) && empty($_GET['callback']))){?>
<html>
<head></head>
    <body>
            <script>
			/*
				XMLHTTPRequest é a maneira clássica de se criar um objeto ajax.
				No caso aqui a requisição é get, então o send vai sem valor, 
				com o open você passa os parametros sendo 
				open(metodo,url,e se é assincrono ou não), para formulários
				ajax é bom que não seja assincrono.
			*/
            let server = "<?php echo $URL_ATUAL; ?>";
            let xhr = new XMLHttpRequest();
            let callback = new XMLHttpRequest();    
            xhr.open("GET", server+"?callback=default",true);    
            callback.open("GET", server+"?callback=callback",true);
            xhr.send();
            callback.send();    
            </script>
        <div style="background-color:darkgray;height:10%;"><span id='values' style="color:black;font-size:24px"></span></div>
        <hr>
        
        <form id="formulario" method='POST' onsubmit='sbmt(event)'>
            <label>Mensagem: </label>
            <input type='textarea' id='mensagem' name='mensagem' />
            <input type='hidden' id='callback' name='callback' value='write' />
            <input type='submit' value='Escrever!' />
        </form>
        <hr>
        
        <script>
            function ajax(){
                let span = document.getElementById('values');
                span.innerHTML = xhr.response;
                leitura();
                this.onclick = callbackF;
            }
            
            function callbackF(){
                let span = document.getElementById('values');
                span.innerHTML = callback.response; 
                leitura();
                this.onclick = ajax;
            }
            
            function sbmt(evento){
				/*
					O método preventDefault() vem o objeto event, padrão de qualquer browser
					esse método tem por finalidade suspender o comportamento padrão de um evento, 
					no caso de um submit por exemplo é ir a pagina que está com o action por exemplo.
				*/
                let writer = new XMLHttpRequest();
                evento.preventDefault();                
                let params = 'mensagem='+document.getElementById('mensagem').value+'&callback='+document.getElementById('callback').value;
                writer.open("POST", server,false);       
                writer.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                
                writer.send(params);                        
                let resultado = JSON.parse(writer.responseText);                                
                console.log(resultado);
                alert(resultado['sucesso'] || resultado['erro']);               
                leitura();
            }
            
            
            function leitura(){  
				/*
					Aqui temos uma requisição ajax feita via POST, existe 
					2 diferenças básicas, primeiro o send() vai com os parametros
					do post e segundo é esse método aqui: 
					setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
					você precisa enviar um header em uma conexão tipo POST é obrigatório.
				*/      
                let reader = new XMLHttpRequest();
                let parametro = 'callback=read';
                reader.open("POST", server,false);       
                reader.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                
                reader.send(parametro);                  
                let resultado = JSON.parse(reader.responseText);                                
                ler = document.getElementById('ler');
                ler.innerHTML = resultado.mensagem;
            }
            
            
            window.document.body.onclick = ajax;            
            
        </script>     
        <div id='ler'></div>
        </body>
</html>
<?php 
	/*
	 Esse aqui é um arquivo hibrido de PHP com Javascript, que usa as bibliotecas do PHP
	 * para escrever os dados em um arquivo e o AJAX como método de envio. No caso do ajax
	 * quando o envio for GET os parametros ja vai na URL, e POST os parametros vai dentro
	 * da função send. Com ajax você consegue atualizar páginas sem precisar recarregar, 
	 * consegue pegar recursos sem sair da página, assim como enviar um formulário sem sair da página.
	 Sobre os métodos de abertura do fopen: 
	 
	 'r' 	Abre somente para leitura; coloca o ponteiro do arquivo no começo do arquivo.
	'r+' 	Abre para leitura e escrita; coloca o ponteiro do arquivo no começo do arquivo.
	'w' 	Abre somente para escrita; coloca o ponteiro do arquivo no começo do arquivo e reduz o comprimento do arquivo para zero. 
		Se o arquivo não existir, tenta criá-lo.
		
	'w+' 	Abre para leitura e escrita; coloca o ponteiro do arquivo no começo do arquivo e reduz o comprimento do arquivo para zero. 
		Se o arquivo não existir, tenta criá-lo.
		
	'a' 	Abre somente para escrita; coloca o ponteiro do arquivo no final do arquivo. Se o arquivo não existir, tenta criá-lo.
	'a+' 	Abre para leitura e escrita; coloca o ponteiro do arquivo no final do arquivo. Se o arquivo não existir, tenta criá-lo.
	'x' 	Cria e abre o arquivo somente para escrita; coloca o ponteiro no começo do arquivo. Se o arquivo já existir, a chamada a fopen() falhará, 
		retornando FALSE e gerando um erro de nível E_WARNING. Se o arquivo não existir, tenta criá-lo.		
		Isto é equivalente a especificar as flags O_EXCL|O_CREAT para a chamada de sistema open(2).
	'x+' 	Cria e abre o arquivo para leitura e escrita; coloca o ponteiro no começo do arquivo. Se o arquivo já existir, a chamada a fopen() falhará, 
		retornando FALSE e gerando um erro de nível E_WARNING. Se o arquivo não existir, tenta criá-lo. Isto é equivalente a especificar as flags 
		O_EXCL|O_CREAT para a chamada de sistema open(2)
	 
	 */

} ?>
