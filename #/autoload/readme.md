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
a função precisa ter o exato mesmo nome do que a imagem, assim sendo você escreve as regras de negócios
quando for dado um require nesse arquivo ao qual a função está contida, nesse caso é o '<b>autoload.php</b>',
lembrando que essa função apenas será executada quando for instanciado um objeto, quando o mesmo for instanciado,
ai será executado essa função. Uma vez executado a função __autoload é carregada, apenas sendo executado quando
você for instanciar algum objeto, caso esse objeto não esteja dentro do arquivo, o php irá executar essa função,
passando o nome da classe como parametro para essa função, ou seja o $classname representa justamente o nome da classe
quando for executado a função na hora da instanciação, se o arquivo for carregado no require e se a classe não estiver
no mesmo arquivo.
</p>
<p>
Logo, é dessa forma engenhosa que o PHP consegue carregar as classes que precisa na hora certa, evitando com que as
mesmas estejam na memória sem a necessidade delas estarem em uso. No caso é usado o padrão PSR4, ou seja uma classe
por arquivo e com esse arquivo tendo o nome da classe e o seu PATH sendo usado como namespace.
</p>