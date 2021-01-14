@extends('layout.app',["current" => "categoria"])
@section('body')
<div class="card border">
    <div class="card-body">
        <form action="/categorias/{{$cat->id}}" method="post">
            @csrf
            <div class="form-group mb-3">
                <label for="nomecategoria">Nome Categoria</label>
                <input type="text" name="nomecategoria" id="nomecategoria" 
                class="form-control" placeholder="Categoria" value="{{$cat->nome}}">                
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
            <button type='cancel' class="btn btn-outline-secondary">Cancelar</button>
        </form>
    </div>
</div>
@endsection