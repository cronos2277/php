@extends('layout.app',['current' => 'produtos'])
@section('body')
<div class="card border">
    <div class="card-body">
        <h5 class="card-title">Cadastro de produtos</h5>
        @if (count($prods) > 0)          
            <table class="table table-ordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Estoque</th>
                        <th>Preço</th>
                        <th>Nome da Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($prods as $prod)
                        <tr>
                            <td>{{$prod->id}}</td>
                            <td>{{$prod->nome}}</td>
                            <td>{{$prod->estoque}}</td>
                            <td>{{$prod->preco}}</td>
                            <td>
                                @foreach ($cats as $cat)
                                    @if($cat->id == $prod->categoria_id)
                                        {{$cat->nome}}
                                    @endif    
                                @endforeach
                            <td>
                                <a href="/produtos/editar/{{$prod->id}}" class="btn btn-sm btn-warning">Editar</a>
                                <a href="/produtos/apagar/{{$prod->id}}" class="btn btn-sm btn-danger">Apagar</a>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <div class="card-footer d-flex justify-content-center">
        <a href="/produtos/novo" class="btn btn-sm btn-primary" role="button">Novo Produto</a>
    </div>
</div>
@endsection