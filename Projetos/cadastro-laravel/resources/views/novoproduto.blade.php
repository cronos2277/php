@extends('layout.app',["current" => "produto"])
@section('body')
<div class="card border">
    <div class="card-body">
        <form action="/produtos" method="post">
            @csrf
            <div class="form-group mb-3">
                <label for="nomeproduto">Nome produto</label>
                <input type="text" name="nomeproduto" id="nomeproduto" 
                class="form-control" placeholder="produto">
                <div class="mt-3 d-flex justify-content-evenly">
                    <div class="col-12 col-lg-3">
                        <label for="estoque">Unidades nos estoques</label>      
                        <span class="input-group-text">
                            <input class="form-control mx-3" type="number" id="estoque" name="estoque" required/>
                            <span>unidades</span>
                        </span>          
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="preco">Preço do produto</label>          
                        <span class="input-group-text">
                            <span>R$</span>
                            <input class="form-control mx-3" type="decimal" id="preco" name="preco" required/>
                        </span>      
                    </div>
                    <div class="col-12 col-lg-3">
                        <label for="produto">Categoria do Produto</label>
                        <span class="input-group-text">
                            <span>Categoria:</span>
                            <select class="form-select mx-3" name="categoria_id" id="categoria_id" required>
                                @foreach ($cats as $cat)
                                    <option value="{{$cat->id}}">{{$cat->nome}}</option>
                                @endforeach
                            </select>
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-evenly border-dark">
                <button type="submit" class="btn btn-outline-primary">Salvar</button>
                <button type='cancel' class="btn btn-outline-secondary">Cancelar</button>
            </div>
        </form>
    </div>
</div>
@endsection