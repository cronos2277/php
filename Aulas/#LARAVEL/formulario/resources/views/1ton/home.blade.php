@extends('template')
@section('section')
    <main class="mt-5">
        <div class="row">
            <div class="col-6">
                <a class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample">
                    EXIBIR TODOS OS PRODUTOS
                </a>
                <a class="btn btn-info" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                    EXIBIR TODAS AS CATEGORIAS
                </a>
            </div>

            <div class="col-6">
                <a class="btn btn-outline-primary">ADICIONAR PRODUTO</a>
                <a class="btn btn-outline-info">ADICIONAR CATEGORIA</a>
            </div>
        </div>
            <div class="collapse mt-3" id="collapseExample">
                <div class="card card-body bg-info bg-gradient">
                    <table class="table table-striped table-info">
                        <thead>
                            <th>Código</th>
                            <td width='80%' align="center"><b>NOME</b></td>   
                            <th colspan="2">Ações</th>                         
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td width='80%' align="center">Nome</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </td>
                            </tr>
                        </tbody>                        
                    </table>
                </div>
            </div>
            <div class="collapse mt-3" id="collapseExample2">
                <div class="card card-body bg-primary bg-gradient">
                    <table class="table table-striped table-primary">
                        <thead>
                            <th>ID</th>
                            <th width="40%">NOME</th>
                            <th>ESTOQUE</th>
                            <th width="40%">CATEGORIA</th>
                            <th colspan="2">Ações</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td width="40%">Produto</td>
                                <td>2</td>
                                <td width="40%">Nome</td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Editar</button>
                                    <button class="btn btn-danger btn-sm">Excluir</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
@endsection