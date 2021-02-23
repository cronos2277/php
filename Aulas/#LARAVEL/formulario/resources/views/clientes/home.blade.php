@extends('template')
@section('section')
    <table class="table mt-5">
        <thead class="table-dark">
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Rua</th>
            <th>Cidade</th>
            <th>Estado</th>
        </thead>
        <tbody>
            <td>1</td>
            <td>Joao</td>
            <td>email@email</td>
            <td>Rua</td>
            <td>Cidade</td>
            <td>Estado</td>
        </tbody>
    </table>

    <button type="button" class="btn btn-dark mt-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Launch demo modal
    </button>

    <div id="exampleModal" class="modal" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            
                <form class="">
                    <div class="row">
                        <div class="col-auto col-6">
                            <label for="nome">NOME</label>
                            <input type="text" class="form-control" id="nome"/>
                        </div>
                        <div class="col-auto col-6">
                            <label for="email">E-MAIL</label>
                            <input type="text"id="email" class="form-control"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto col-5">
                            <label for="rua">RUA</label>
                            <input type="text" id="rua" class="form-control"/>
                        </div>
                        <div class=" col-auto col-5">
                            <label for="cidade">CIDADE</label>
                            <input type="text" id="cidade" class="form-control"/>
                        </div>
                        <div class="col-auto col-2">
                            <label for="estado">UF</label>
                            <input type="text" id="estado" class="form-control"/>
                        </div>
                    </div>
                </form>
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-dark">Save changes</button>
            </div>
        </div>
        </div>
    </div>


    
@endsection