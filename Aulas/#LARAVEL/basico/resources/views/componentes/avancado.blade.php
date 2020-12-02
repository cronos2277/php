<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exemplo Avançado</title>    
</head>
<body>
    <nav>
        <ul>
            <li><a href="{{route('avancado',1)}}" class="{{(request()->is('view_avancado/1'))?'selected-item':'unselected'}}">Componente 1 </a></li>
            <li><a href="{{route('avancado',2)}}" class="{{(request()->is('view_avancado/2'))?'selected-item':'unselected'}}">Componente 2 </a></li>
            <li><a href="{{route('avancado',3)}}" class="{{(request()->is('view_avancado/3'))?'selected-item':'unselected'}}">Componente 3 </a></li>
            <li><a href="{{route('avancado',4)}}" class="{{(request()->is('view_avancado/4'))?'selected-item':'unselected'}}">Componente 4 </a></li>
        </ul>
    <nav>
    @switch($param)
        @case(1)
            @component('componentes.componente1')
            <h1>Componente 1</h1>    
            @endcomponent
            @break
        @case(2)
            @component('componentes.componente2',['param1' => 'Parametro1', 'param2' => 'parametro2'])
                <h1>Componente 2</h1> 
            @endcomponent 
            @break        
        @case(3)
            @component('componentes.componente3')
                <h1>Componentes 3</h1>
            @endcomponent
            @break
        @case(4)
            @component('componentes.componente4')
                <h1>Componentes 4</h1>
            @endcomponent
            @break
        @default
            <h1>Página Padrão </h1>
    @endswitch
</body>
</html>