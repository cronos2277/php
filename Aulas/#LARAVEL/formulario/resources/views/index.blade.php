@extends('template')
@section('section')  
    <div class="accordion mt-5" id="accordionExample">        
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Formulário
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body p-3">
                    Exemplo de como funciona um formulário no laravel    
                    <br>                
                    <a class="btn btn-primary mt-3" href="{{route('index')}}"><strong>IR</strong></a>
                </div>
            </div>
        </div>    
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Relacionamento 1 para 1 no Laravel
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Ir para relacionamento 1 para 1
                    <br> 
                    <a class="btn btn-primary mt-3" href="{{route('1to1')}}"><strong>IR</strong></a>
                </div>
            </div>
        </div>
    </div>
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                Relacionamento 1 para N no Laravel
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    Ir para relacionamento 1 para N
                    <br> 
                    <a class="btn btn-primary mt-3" href="{{route('1toN')}}"><strong>IR</strong></a>
                </div>
            </div>
        </div>
    </div>
    
@endsection