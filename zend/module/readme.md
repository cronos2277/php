<h1>Criando modulos no Zend</h1>
<p>Para se criar modulos no zendo, inicialmente voce precisa criar uma pasta aqui dentro, lembrando que a primeira letra
da pasta aqui dentro deve ser em caixa alta, nesse caso temos como exemplo o <b>Application</b>, <b>Core</b>.</p>
<p>Dentro dessa pasta contendo o modulo, nesse caso o core, precisaremos importar o <b>module.config.php</b> dentro da 
pasta config, que tanto o arquivo como a pasta deve ser criado, nesse caso foram dentro do modulo Core que foi
criado agora.</p>
<p>
E entao criamos a pasta source que deve ter o arquivo '<b>Module.php</b>'. Ambos tanto a pasta como o arquivo devem
ser criados, o module.php eh o que vai fazer a chamada para o nosso modulo, a funcao getConfig() ira carregar o arquivo
'<b>module.config.php</b>' dentro da pasta '<b>conig</b>' dentro desse mesmo modulo.
</p>
<p>
Apos tudo isso o modulo deve ser registrado dentro do arquivo <b>modules.config.php</b> dentro da pasta '<b>config</b>'
dentro do diretorio raiz do Zend framework.
</p>
<p>Depois que voce fizer tudo isso, voce deve ir no '<b>composer.json</b>' e definir no autoload dentro psr-4,
primeiro o namespace e depois o diretorio src, ficaria algo assim: ' <b>"NAMESPACE\\PATH/PATH"</b> ', nesse caso: <br>
<img src="core-psr-4.png" /></p>
<p>
Toda vez que voce atualiza o autoload do arquivo composer.json, eh necessario dar um comando de terminal ou fazer uma
alteracao no arquivo de autolad do composer, o comando de terminal em questao eh:'<b>composer dumpautoload</b>', ira
incluir, nesse caso em especifico a seguinte entrada no arquivo de loader referente ao psr-4:<br>
<img src="autoload" />
<br>
Esse arquivo esta no diretorio '<b>/vendor/composer/</b>' sendo o seu nome '<b>autoload_psr4.php</b>'
</p>
