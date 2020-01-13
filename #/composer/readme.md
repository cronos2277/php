<h1>Composer</h1>
<h2>Como usar?</h2>
<h3>Preparando o ambiente</h3>
Uma vez feito o download dos arquivos desse diretorio, execute o seguinte
comando '<b>composer install</b>', depois de terminado a execucao, execute o seguinte script customizado para que seja o codigo executado na porta 8090, '<b>composer run</b>' 
<h3>Instrucoes de uso.</h3>
coloque isso ao inicio do seu codigo '<b>require 'vendor/autoload.php';</b>'. Uma vez que voce coloque isso no seu PHP o composer sera carregado. O composer gerencia os includes que voce da nas classes de maneira automatica, apenas chamando-as quando voce for instanciar uma classe.
<h2>Comandos Basicos</h2>
<h3>composer init </h3>
<p>Inicia um novo projeto no diretorio corrente.</p><br />
<h3>composer install </h3>
<p>Esse comando instala todas as dependencias do composer.json</p><br />
<h3>composer update </h3>
<p>Atualiza as alteracoes feitas no composer.json refletindo-as nos diretorios.</p><br />
<h3>composer require <b>[nome do pacote ou como o pacote esta registrado]</b> </h3>
Voce pode apenas digitar o nome do pacote e ele mostrara uma lista, ou voce pode colocar
o diretorio exato do pacote, como ele esta registrado.
<h3>composer dump-autoload</h3>
Toda vez que voce atualizar o autoload ou o autoload-dev se faz necessario executar esse comando, no caso esse comando faz com que as alteracoes feitas nessa propriedade seja refletiva nos include internos do composer. 
