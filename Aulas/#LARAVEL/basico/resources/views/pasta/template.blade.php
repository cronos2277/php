@extends('pasta.extensao_template')
@section('secao')
    <!-- Executa codigo php-->
    @php
        $arr = [1,2,3,4,5,6,null]
    @endphp 

    <!-- laço for each igual ao PHP. -->
    @foreach ($arr as $item)
        {{ $item }}
    @endforeach

    <!-- Switch igual ao PHP -->
    @switch(0)
        @case(1)
            <p>Não vai ser exibido.</p>
            @break
        @case(2)
            <p>Não vai ser exibido.</p>
            @break
        @default
            <p>Vai se exibir esse valor.</p>
    @endswitch

    <!-- forelse imprime o array, ou executa o empty se vazio -->
    @forelse ([] as $item)
        <p>forelse: {{$item}}</p>
    @empty
        <p>caso de array vazio imprimirá isso</p>
    @endforelse

    <!-- Comando equivalente ao dd do Laravel, que é um var_dump mais bonito e organizado. -->
    @dump($arr)

    <!-- Impressao crua -->
    @{{ arr[3] }}

    <!-- o equivalente ao echo -->
    {!! $arr[1] !!}

    <!-- verifica se variavel existe -->
    @isset($arr)
        <p>Variável $arr está setada </p>
    @endisset

    <!-- verifica se a variavel está vazia. -->
    @empty(!$arr)
        <p>Variável $arr não está vazia </p>
    @endempty    
    
@endsection
