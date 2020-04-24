<?php
$indice = 0;
$str[$indice++] = "Dias da semana: %A"; //vai exibir algo do tipo: Thursday
$str[$indice++] = "Dias da semana: %a"; //vai exibir algo do tipo: thu
$str[$indice++] = "Dia do mes: %d"; //vai exibir algo do tipo: 24
$str[$indice++] = "Mes/Dia/Ano: %D"; //vai exibir algo do tipo:  04/24/20
$str[$indice++] = "Ano completo: %F"; //vai exibir a data, sendo algo do tipo: 2020-04-24;
$str[$indice++] = "Mes: %m"; //vai exibir algo do tipo (04 seria Abril): 04
$str[$indice++] = "Mes com nome: %B"; //vai exibir algo do tipo: April
$str[$indice++] = "Ano completo: %Y"; //vai exibir o ano, sendo algo do tipo: 2020;
$str[$indice++] = "Ano completo: %y"; //vai exibir o ano, sendo algo do tipo: 20;

foreach($str as $value){
    /*
        strftime => Essa função serve para exibir uma data mais costumizável, essa função
        permite formatação de String interpolando os caracteres com "%", nesse laço será
        exibido de maneira sequencial o array acima, com as devidas interpolações, e o 
        time() pega a hora atual, se dado o echo ele exibe quantos segundos se passo depois
        da data de 1/1/1970 que é o marco zero na linguagem PHP.
    */
    echo strftime($value,time()),"\n";
}

echo "\n","------------------","\n";
// Modifica a zona de tempo a ser utilizada. Desde o PHP 5.1
date_default_timezone_set('UTC');

// Exibe alguma coisa como: Monday
echo date("l"),"\n";

// Exibe alguma coisa como: Monday 8th of August 2005 03:12:46 PM
echo date('l jS \of F Y h:i:s A'),"\n";

// Exibe: July 1, 2000 is on a Saturday
echo "July 1, 2000 is on a " . date("l", mktime(0, 0, 0, 7, 1, 2000)),"\n";

/* utiliza as constantes do parâmetro de formato */
// Exibe alguma coisa como: Mon, 15 Aug 2005 15:12:46 UTC
echo date(DATE_RFC822),"\n";

// Exibe alguma coisa como: 2000-07-01T00:00:00+00:00
echo date(DATE_ATOM, mktime(0, 0, 0, 7, 1, 2000)),"\n";

/*
mktime cria uma data especifica, sendo os parametros:
mktime($horaInt,$minutoInt,$segundosInt,$mesInt,$diaInt,$anoInt);
A ordem dos parametros deve ser: Hora,Minuto,Segundos,Mes,Dia,Ano.
O Date tambem cria datas, porem nao da meneira que o strftime() cria,
porem caso voce queira usar algo mais customizavel na funcao date,
use o caracter de escape "\", quando voce nao quiser interpolar.
O date funciona assim date("formatacao",$data);
*/
echo date('l jS \of F Y h:i:s A',mktime(1,2,3,12,31,1999)); //Friday 31st of December 1999 01:02:03 AM
echo "\n","------------------","\n";
$todasAsDatas['dia'] = strtotime('+1 day'); //Pega a data de amanha.
$todasAsDatas['semana'] = strtotime('-1 week'); //Pega a semana retrasada.
$todasAsDatas['mes'] = strtotime('+2 month'); //Pegar daqui a dois meses.
$todasAsDatas['ano'] = strtotime('-3 year'); //Pegar data de 3 anos atras
foreach($todasAsDatas as $key=>$cada){    
    echo $key,": ",strftime('%D',$cada),"\n";  
}

//Datas avançada

echo "\n","------------------","\n";
//Datas apenas com dia, mes e ano.
$dataV1 = new DateTime("1970-01-01"); //primeiro de janeiro de 1970.
$dataV2 = new DateTime("1970-01-01"); //primeiro de janeiro de 1970.
echo ($dataV1 == $dataV2)?"Igual":"Diferente","\n"; //Resultado: Igual.

//Data com dia, mes, ano, hora, minuto, segundo.
$dataV3 = new DateTime("1970-01-01 06:30:30"); //O mesmo dia que o de cima, mas com o horario.
$dataV4 = new DateTime("1970-01-01 11:34:29"); //Repare que aqui o horario ja eh diferente.
echo ($dataV3 == $dataV4)?"Igual":"Diferente","\n"; //Resultado: Diferente.

$dataV5 = new DateTime("+7 day"); //Voce pode criar datas dessa forma tambem nesse objeto.
$dataV6 = new DateTime("+1 week"); //Aqui tambem vale a mesma regra do strtotime(), citado acima.
echo ($dataV5 == $dataV6)?"Igual":"Diferente","\n"; //Resultado: Diferente. Comparando objetos diretamente
echo ($dataV5->getTimestamp() == $dataV6->getTimestamp())?"Igual":"Diferente","\n"; //Resultado: Igual.
echo "Data5: ",strftime("%D",$dataV5->getTimestamp()),"\n"; //Exibindo a data 5.
echo "Data6: ",strftime("%D",$dataV6->getTimestamp()),"\n";//Exibindo a data 6.
$dataV6->modify("-3 day"); //Diminuindo 3 dias.
echo "Data6, tres dias atras: ",strftime("%D",$dataV6->getTimestamp()),"\n";//Exibindo a data 6 novamente.
$dataV5->setDate(2050,12,31); //Alterando a data para o ultimo dia do ano de 2050.
echo "Data5, data futura: ",strftime("%D",$dataV5->getTimestamp()),"\n";//Exibindo a data 5 novamente.
echo $dataV4->format("D, d M Y"),"\n"; //Imprimindo a data formatada, atraves do metodo format().
echo $dataV3->getOffset(),"\n"; //Retorna o UTC, zero eh o UTC do meridiano de greenwich
$timezone = new DateTimeZone("America/Sao_Paulo");
$dataV3->setTimezone($timezone);
echo $dataV3->getOffset(),"\n"; //Retorna o UTC, aqui exibe o UTC alterado, no caso: -10800;
