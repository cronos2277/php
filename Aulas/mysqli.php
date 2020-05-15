<?php
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);
$dados = [
    "127.0.0.1", //=> IP e PORTA.
    "root", // Usuario
    "", // Senha
    "test" //Nome do Banco de dados.
];
/*
    Operador Spread de espalhar, ele pega um array 
    e transforma em varias variaveis, por exemplo:
    se voce tem um array com 2 valores, e usa esse
    operador em uma funcao ou metodo, o operador
    spread faz com que o primeiro valor do array
    seja o primeiro parametro da funcao ou metodo,
    o segundo indice o segundo parametro e por
    ai vai, ou seja voce espalha o array como
    parametros de uma funcao ou metodo. lembrando
    que os tres pontinhos tem essa funcao 
    dependendo do contexto, no contexto de funcao
    como eh o caso, temos o operador Spread.
    O primeiro parametro eh o IP com a porta,
    caso seja 3306 isso pode ser omitido,
    depois usuário, senha e o nome do banco de dados,
    respectivamente. Essa funcao soh eh compativel
    com o MySql exclusivamente.
*/    
$estruturado = mysqli_connect(...$dados); //Modo Estruturado
if($estruturado){
    echo "Conexao feita com sucesso!";
    /*
        a funcao mysqli_query executa uma query, retornando falso caso de erros, esse tipo de query pode ser usada quando
        nao se faz necessario o retorno de valores, quando for a manipulacao de dados e estruturas. Essa funcao eh estruturada,
        podendo ser usada caso voce nao queira usar a orientacao a objetos, sendo o primeiro parametro a variavel de conexao
        e o segundo a query, nao recomenda-se o uso caso seja necessario entrada de dados, pois do contrario estara vulneravel
        a sql injection.
    */
    if(mysqli_query($estruturado,'CREATE TABLE if not exists teste (id integer primary key auto_increment, valor varchar(30) not null)')){
        echo "<br>","<b>criado a tabela, senão existe</b>";
        //Inserindo dados vindo do GET. Para funcionar passe o novo valor no parametro V na url
        if(isset($_GET['v']) && !empty($_GET['v'])){
            $sql_insert = "insert into teste(valor) values('";            
            $sql_insert .= $_GET['v'];
            $sql_insert .= "')";
            if(mysqli_query($estruturado,$sql_insert)){
                echo '<br>',"Dados inseridos com sucesso!";
            }else{
                echo "<br>","Erro ao inserir na tabela!","<br>",$estruturado->error;                
            }
        } 

        //Excluido dados via GET. Para funcionar passe o novo valor no parametro d na url
        if(isset($_GET['d']) && !empty($_GET['d'])){
            $sql_delete = "DELETE FROM teste where id = ";            
            $sql_delete .= $_GET['d'];            
            if(mysqli_query($estruturado,$sql_delete)){
                echo '<br>',"Dados excluídos com sucesso!";
            }else{
                echo "<br>","Erro ao excluir na tabela!","<br>",$estruturado->error;                
            }
        }
    }else{        
        echo "<br>","Erro ao criar tabela!","<br>",$estruturado->error;
    }    
}else{
    echo "<br>";
    //mysqli_connect_errno() => Retorna um codigo de erro.
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "<br>";
    //mysqli_connect_error() => Retorna a descricao do erro
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    echo "<br>";
    exit;
}

echo "<hr>";
var_dump($estruturado);