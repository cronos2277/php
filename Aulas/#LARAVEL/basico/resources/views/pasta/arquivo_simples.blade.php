<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Arquivo Blade Simples</title>
</head>
<body>
<!-- Criando desvio condicional -->
    @if (true)
        <h3>Será exibido</h3>
    @else
        <h3>Não será exibido</h3>
    @endif 

<!-- criando laço for -->
    @for ($i = 0; $i < 0; $i++)
        <p>Não será exibido</p>
    @endfor

<!-- Criando laço while -->
    @while (false)
        <p>Não será exibido</p>
    @endwhile

<!-- Exibindo valores php -->
    <p>Exibindo o parametro passado: {{ $parametro }}</p>
</body>
</html>