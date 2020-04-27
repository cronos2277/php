<html>
    <head>
        <title>
            UPLOADS
        </title>
    </head>
    <body>
    <?php
        if(isset($_FILES) && !empty($_FILES)){
            $arquivoNoLocalTemporario = $_FILES['arquivo']['tmp_name'];
            $nomeDoArquivoEnviado = $_FILES['arquivo']['name'];
            $aondeSerEnviado = __DIR__."\\".$nomeDoArquivoEnviado;
            echo $arquivoNoLocalTemporario,"<br>";
            if(move_uploaded_file($arquivoNoLocalTemporario,$aondeSerEnviado)){
                echo "<span>upload de <b> ${nomeDoArquivoEnviado} </b> feito com sucesso! </span>";
            }else{
                echo "<span>Erro no upload! </span>";                
            }            
            
        }else{
            echo "<h1>Exemplo de Upload de arquivos no PHP</h1>";
        }

        function criarLink(string $fileName):string{
            return "<a href=$fileName target='_black'>$fileName</a>";
        }
    ?>
    <?php if(isset($_FILES) && !empty($_FILES)){ ?>
        <hr>
            <table>
                <tr>
                    <td>Nome do arquivo: </td>
                    <td><?= $_FILES['arquivo']['name']; ?></td>
                </tr>
                <tr>
                    <td>Local do arquivo: </td>
                    <td><?= criarLink($aondeSerEnviado); ?></td>
                </tr>
                <tr>
                    <td>Tipo do arquivo: </td>
                    <td><?= $_FILES['arquivo']['type']; ?></td>
                </tr>
                <tr>
                    <td>Tamanho do arquivo: </td>
                    <td><?= $_FILES['arquivo']['size']; ?></td>
                </tr>
                <tr>
                    <td>Armazenamento temporário: </td>
                    <td><?= criarLink($_FILES['arquivo']['tmp_name']); ?></td>
                </tr>
            </table>
        <hr>
    <?php } ?>
        <form accept-charset="UTF-8" enctype="multipart/form-data" method="POST">
            <input type="file" name="arquivo" />
            <br />
            <input type="submit" name="sbmt" />
        </form>
    </body>
</html>