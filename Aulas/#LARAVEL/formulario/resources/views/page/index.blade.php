@extends('template')
@section('section')    
    <main role="main" class="container mt-5">        
        <div class="jumbotron">
            <h1 class="display-4">Formulários</h1>
            <p class="lead">Exemplo de uma lista de funcionários</p>                              
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Idade</th>
                    <th scope="col">Salario</th>
                    <th scope="col" colspan="2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($formularios as $formulario)
                        <tr>
                            <th scope="row">{{$formulario->id}}</th>
                            <td>{{$formulario->nome}}</td>
                            <td>{{$formulario->email}}</td>
                            <td>{{$formulario->idade}}</td>
                            <td>R$ {{($formulario->salario)?$formulario->salario:'0.00'}}</td>
                            <td>
                                <a type="button" class="btn btn-warning btn-sm" href="/edit/{{$formulario->id}}">Editar</a>
                            </td>
                            <td>
                                <a type="button" class="btn btn-danger btn-sm" href="/destroy/{{$formulario->id}}">Excluir</a>
                            </td>
                        </tr>    
                    @endforeach
                                        
                </tbody>
                </table>            
                <a class="btn btn-success btn-lg" href="/create" role="button">Adicionar Novo</a>
        </div>  

    </main>    
@endsection