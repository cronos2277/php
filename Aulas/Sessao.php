<?php
session_start();//Toda vez que você for usar uma Sessao, você deve chamar essa função antes de começar.
//session_id('hash da session'). //Se tiver parametro, a mesmo substuirá a sessão atual por essa.
$_SESSION['teste'] = "Valor Guardado: ".session_id(); //A função pode ser usada sem parametro, nesse contexto ela passa o ID para uma variavel.
session_regenerate_id(); //Dessa forma é criada uma nova seção, ou seja é gerado um novo hash para o Session ID.
echo "Sessao antiga: ", $_SESSION['teste'], ".\nSessao nova: ", session_id(), "\n";
//unset($_SESSION['teste']); //unset Destroi valores, use-a caso você queira destruir algum valor do array $_SESSION.
session_destroy(); //Destoi Session ID apenas, sem mexer no valor do Array $_SESSION.
var_dump($_SESSION);
