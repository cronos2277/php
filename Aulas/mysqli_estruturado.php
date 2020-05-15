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

        //Consultando com SQL
        if(isset($_GET['s']) && !empty($_GET['s'])){            
            /*
                Essa seria a outra forma de voce lidar com o Mysql, sem concatenar String, apesar
                de ser mais complexo, é mais seguro. O Statement recebe o resultado de uma query.
                $statement = mysqli_prepare($variavelConexao, "QUERY com ? para sinalizar 
                aonde deve colocar os parametros.")
            */                       
            if($statement = mysqli_prepare($estruturado, "SELECT * FROM teste WHERE id=?")){     
                /*
                    Aqui voce prepara a string para ser executada, como so tem um parametro,
                    voce so faz uma preparacao, voce deve fazer 1 preparacao para cada parametro.
                    mysqli_stmt_bind_param(
                        $statement, <-- Aqui voce passa o Statement.
                        "i", <-- Aqui voce informa o tipo de dado. Sendo:{
                            i 	corresponde a uma variável de tipo inteiro
                            d 	corresponde a uma variável de tipo double
                            s 	corresponde a uma variável de tipo string
                            b 	corresponde a uma variável que contém dados para um blob e enviará em pacotes
                        }
                        $_GET['s'] <-- aqui voce passa o valor.
                    );
                */                           
                mysqli_stmt_bind_param($statement,"i",$_GET['s']);
                mysqli_stmt_execute($statement); //Aqui voce executa a Query, junto com os parametros.                
                $result = mysqli_stmt_get_result($statement); //Aqui voce pega o resultado da query acima.
                echo "<h1>Resultado: {";
                /*
                    Com um auxilio do While voce pode pegar cada linha do resultado do result acima.
                    No primeiro parametro voce passa um objeto pego pelo: mysqli_stmt_get_result($statement);
                    O segundo arqumento, que é opcional, resulttype é uma constante indicando qual tipo de matriz 
                    deve ser produzido da linha atual do resultado. Os valores possíveis para este parâmetro
                    são as constantes MYSQLI_ASSOC, MYSQLI_NUM, ou MYSQLI_BOTH. Pos padrão,
                    a função mysqli_fetch_array() irá assumir MYSQLI_BOTH para este parâmetro.
                    Usando a constante MYSQLI_ASSOC esta função irá funcionar de modo identico a mysqli_fetch_assoc(),
                    enquando MYSQLI_NUM irá funcionar de modo identico a função mysqli_fetch_row(). 
                    A opção final MYSQLI_BOTH irá criar uma única matriz com os atributos de ambas. 
                */    
                while ($row = mysqli_fetch_array($result, MYSQLI_NUM))
                {
                    foreach ($row as $r)
                    {
                        print "$r ".';';
                    }
                    print "\n";
                } 
                echo "}</h1>";               
                mysqli_stmt_close($statement);               
            }else{
                echo "<br>","Erro ao consultar tabela!","<br>",$estruturado->error;                
            }
        }
        
    }else{        
        echo "<br>","Erro ao criar tabela!","<br>",$estruturado->error;
    }
    echo "<hr>";
    var_dump($estruturado);
    mysqli_close($estruturado);    //Fecha a conexao com o Banco de dados.
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
