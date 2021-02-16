@extends('template')
@section('section')  
  <main class="container mt-5"> 
    <h1 class="display-3">Editar</h1> 
    <hr>
    <form class="row g-3 mt-3" action="/api/{{$user->id}}" method="POST" onsubmit="return confirm('Deseja realmente remover o {{$user->nome}}?')">
      @csrf
      @method('DELETE')
      <input type="hidden" value="{{$user->id}}" name="id_form" readonly />
        <div class="col-md-6">
          <div class="input-group">
            <span class="input-group-text">Nome</span>
            <input type="text" class="form-control @if($errors->has('nome_form')) is-invalid @endif" placeholder="Nome" aria-label="Nome" name="nome_form" value="{{$user->nome}}" readonly>
            <div class="invalid-feedback">@if($errors->has('nome_form')) {{$errors->first('nome_form')}} @endif</div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="input-group">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control @if($errors->has('email_form')) is-invalid @endif"" placeholder="E-mail" aria-label="E-mail" name="email_form" value="{{$user->email}}" readonly>
              <div class="invalid-feedback">@if($errors->has('email_form')) {{$errors->first('email_form')}} @endif</div>
          </div>
        </div>
        <div class="col-md-2 col-6">
          <div class="input-group">
            <span class="input-group-text">Idade</span>
            <input type="text" class="form-control @if($errors->has('idade_form')) is-invalid @endif"" placeholder="Idade" aria-label="Idade" name="idade_form" value="{{$user->idade}}" readonly>
            <div class="invalid-feedback">@if($errors->has('idade_form')) {{$errors->first('idade_form')}} @endif</div>
          </div>  
        </div>
        <div class="col-md-3 col-6">
          <div class="input-group">
            <span class="input-group-text">R$</span>
            <input type="text" class="form-control @if($errors->has('sal_form')) is-invalid @endif"" placeholder="salario" aria-label="salario" name="sal_form" value="{{$user->salario}}" readonly>
            <div class="invalid-feedback">@if($errors->has('sal_form')) {{$errors->first('sal_form')}} @endif</div>
          </div>
        </div>                
        <button type="submit" class="btn btn-danger col-md-2 col-5 mx-2">Remover</button>        
    </form>
        @if ($errors->any())
          <div class="alert alert-danger p-5 mt-5">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
  </main>  
@endsection