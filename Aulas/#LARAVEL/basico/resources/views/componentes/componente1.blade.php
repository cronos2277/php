<div>
    {{$slot}}
    @php
        $arr = [0,1,2,3,4,5,6,7,8,9];    
    @endphp

    @foreach ([1] as $item)
        <h3>Conteudo da $loop dentro de um array</h3>
    @dump($loop)
    @endforeach
</div>