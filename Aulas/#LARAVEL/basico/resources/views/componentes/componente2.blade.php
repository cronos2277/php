<div>
    {{$slot}}    
    <hr>
    <ul>
        <li>{{$param1}}</li>
        <li>{{$param2}}</li>
    </ul>
    <hr>    
        <h3>Conteúdo de $slot</h3>   
        {{dd($slot)}}    
</div>