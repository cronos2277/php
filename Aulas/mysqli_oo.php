<?php
$dados = [
    "127.0.0.1",
    "root",
    "",
    "test"
];
$mysqli = new mysqli(...$dados);

// Verifica se ocorreu algum erro
if (mysqli_connect_errno()) {
    die('Não foi possível conectar-se ao banco de dados: ' . mysqli_connect_error());
    exit();
}

if($tbl = $mysqli->prepare('CREATE TABLE if not exists teste (id integer primary key auto_increment, valor varchar(30) not null)')){
    $tbl->execute(); //Toda vez que voce for fazer uma query com o prepare, nao esqueca de executa-la com o metodo execute().
}else{
    echo "<br>","Erro ao se conectar a tabela:".$mysqli->error; //O Atributo error eh aonde fica a descricao do erro.
    exit;
}

//Executa uma consulta caso seja encontrado o parametro 's' no GET.
if(isset($_GET['s']) && !empty($_GET['s'])){
    // Prepara uma consulta SQL
    if ($sql = $mysqli->prepare("SELECT `id`,`valor` FROM `teste` WHERE `id` = ?")) {

        /*
            usando o método bind_param(), o primeiro parâmetro traz os tipos dos valores,                    
            eles se referem ao valor que o metodo espera encontrar.
            i para integer (inteiro)
            s para string
            d para double (decimal)
            b para blob
        */

        // Atribui valores às variáveis da consulta
        $sql->bind_param('i', $_GET['s']); // Coloca o valor de $_GET['s'] no lugar da primeira interrogação (?)

        // Executa a consulta
        $sql->execute();

        // Atribui o resultado encontrado a variáveis
        /*
            Aqui se atribui o valor de cada coluna no resultado para as variaveis. No caso a consulta acima 
            retorna dados em tabela, no caso uma coluna contendo todos os ids e outra contendo valores.
            Nesse exemplo a bind_result criara dois arrays, um contendo os IDS, e outra os valores, nesse
            caso como a query so retorna um valor, sera um array de um unico elemento.
            Para cada variavel do metodo abaixo, deve ter uma coluna equivalente no retorno da query, nesse
            caso como sao retornado duas colunas, deve ter no minimo uma variavel e no maximo 2, se colocar
            tres variavel a terceira nao pega nada, a nao ser que a query tenha uma terceira coluna.
            O numero de variaveis criadas aqui deve ser compativel com a quantidade de colunas que a 
            query vai retornar.
        */
        $sql->bind_result($ids, $valores);

        // Para cada resultado encontrado...
        while ($sql->fetch()) {
            echo "<h1>".$ids, " - ";
            echo $valores,"</h1>";      
        } 

        // Total de registros encontrado na query acima.
        echo "<b>".'Total de ocorrencias: ' . $sql->num_rows."</b><br>";

        // Fecha a consulta
        $sql->close();
    }else{
        echo "<br>","<b>Erro ao Selecionar:".$mysqli->error."</b>";
    }
}

//Executa a insercao.
if(isset($_GET['v']) && !empty($_GET['v'])){
    if ($inserir = $mysqli->prepare("INSERT INTO TESTE(VALOR) VALUES(?)")){
        $inserir->bind_param('s', $_GET['v']);
        $inserir->execute();
        echo "<h1>".$_GET['v']." - Inserido com Sucesso!</h1>";
        $inserir->close();
    }else{
        echo "<br>","<b>Erro ao Inserir:".$mysqli->error."</b>";
        exit;
    }
}

if(isset($_GET['d']) && !empty($_GET['d'])){
    if ($excluir = $mysqli->prepare("DELETE FROM TESTE WHERE ID = ?")){
        $excluir->bind_param('i', $_GET['d']);
        $excluir->execute();
        echo "<h1>".$_GET['d']." - Excluido com Sucesso!</h1>";
        $excluir->close();
    }else{
        echo "<br>","<b>Erro ao excluir:".$mysqli->error."</b>";
        exit;
    }
}


echo "<br>","Executado sem problemas!";
echo "<hr>",var_dump($mysqli); //Aqui eh exibido detalhes do Objeto mysqli
// Fecha a conexão com o banco de dados
$mysqli->close();