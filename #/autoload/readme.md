<h1>Sobre a função de autoload do PHP</h1>
<img src="./.@imgs/img0.png" />
<p>
    Aqui temos um exemplo de funcionamento, para o uso da função
    basta você informar ao require o arquivo php que tem a função<br>
    '<b>__autoload($parametro)</b>'
    <br> Sendo a forma acima a assinatura dela.
</p>
<img src="./.@imgs/img0.png" /><br>
<p>
A função precisa ter o exato mesmo nome do que a imagem, assim sendo você escreve as regras de negócios
quando for dado um require nesse arquivo ao qual a função está contida. Nesse caso é o '<b>autoload.php</b>',
lembrando que essa função apenas será executada quando for instanciado um objeto, apenas sendo carregado no require.
Uma vez executado a função __autoload, ou seja quando alguma classe que não esta ali no arquivo for chamado,
o php irá executar essa função, passando o nome da classe como parametro para essa função, ou seja o $classname representa 
justamente o nome da classe. 
</p>
<p>
Logo, é dessa forma engenhosa que o PHP consegue carregar as classes que precisa na hora certa, evitando com que as
mesmas estejam na memória sem a necessidade delas estarem em uso. Assim o autoload só é chamado quando tiver uma classe
que o PHP não conhece e ali dentro nas regras de negócio, é verificado se o arquivo existe, se existe ele carrega o arquivo
com o mesmo nome que a própria classe.
</p>