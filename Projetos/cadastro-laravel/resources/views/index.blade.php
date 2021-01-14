@extends('layout.app',['current' => 'home'])
@section('body')
    <div class="jumbotron border-secondary p-5 bg-light">
        <div class="row">
            <div class="col-sm-6">
              <div class="card p-5 border-primary">
                <div class="card-body align-self-center">
                  <h5 class="card-title">Cadastro de produto</h5>
                  <p class="card-text">Clique no botão abaixo para criar um produto.</p>
                  <a href="/produtos/novo" class="btn btn-primary">Criar Produto</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card p-5 border-success">
                <div class="card-body align-self-center">
                  <h5 class="card-title">Cadastro de categoria</h5>
                  <p class="card-text">Clique no botão abaixo para criar uma categoria.</p>
                  <a href="/categorias/novo" class="btn btn-success">Criar categoria</a>
                </div>
              </div>
            </div>
          </div>
    </div>
@endsection