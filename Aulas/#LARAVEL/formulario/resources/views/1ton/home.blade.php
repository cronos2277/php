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
                <a class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#addCat">ADICIONAR CATEGORIA</a>
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
                        <tbody id="categoria">                            
                        </tbody>                        
                    </table>
                </div>
            </div>
            <div class="collapse mt-3" id="collapseExample2">
                <div class="card card-body bg-primary bg-gradient">
                    <table class="table table-striped table-primary">
                        <thead>
                            <td align="center"><b>ID</b></td>
                            <td width="35%" align="center"><b>NOME</b></td>
                            <td align="center"><b>ESTOQUE</b></td>
                            <td width="35%" align="center"><b>CATEGORIA</b></td>
                            <td colspan="2" align="center"><b>Ações</b></td>
                        </thead>
                        <tbody id="produto">                            
                        </tbody>
                    </table>
                </div>
            </div>            
            <div class="modal fade" id="addCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">                            
                            <input type="nome" class="form-control" id="categoriaNome" placeholder="CATEGORIA" value="">
                            <label for="categoriaNome">Categoria</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-info" onclick="addCat()">Adicionar</button>
                    </div>
                </div>
                </div>
            </div>
        </main>
        <script>
            var produtos = null;
            var categorias = null; 
            const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};

            function addCat(){                
                const categoriaNome = document.getElementById('categoriaNome').value;
                const body = new FormData();
                body.append('nome',categoriaNome);                
                fetch('/api/um-para-muitos/c',{method:'post',headers,body})
                .then(e => (e.status == 401)? alert('Erro ao inserir'):alert(`${categoriaNome} adicionado com sucesso!`))
                .then(getAll)
                .catch(console.error)                
            }

            function remCat(id){
                const body = new FormData();
                body.append('_method','DELETE');
                if(confirm('Deseja Excluir?')){
                    fetch(`/api/um-para-muitos/c/${id}`,{method:'post',headers,body})
                    .then(e => (e.status == 401) && alert('Essa categoria tem produto(s) associados e não pode ser excluída!'))
                    .then(getAll)
                    .catch(console.error)
                }
            }

            function editCat(id){
                                
            }

            function getAll(){
                //produtos
                fetch('/api/um-para-muitos/p')                
                .then(data => data.text())
                .then(data => JSON.parse(data))
                .then(data => produtos = data)                
                .then(setProdutos)
                .catch(_ => console.error('Não foi possível carregar Produtos'));

                //categorias
                fetch('/api/um-para-muitos/c')                
                .then(data => data.text())
                .then(data => JSON.parse(data))
                .then(data => categorias = data)
                .then(setCategorias)                
                .catch(_ => alert('Erro ao carregar o site, verifique a conexão com o banco de dados!'));                
            };           

            function setCategorias(){
                function createCategoria(key,name){

                    const tr = document.createElement('tr');
                    tr.setAttribute('key',key);

                    const td_id = document.createElement('td');
                    td_id.innerText = key;                    

                    const td_nome = document.createElement('td');
                    td_nome.innerText = name;       
                    td_nome.setAttribute('width','80%');  
                    td_nome.setAttribute('align','center');                  

                    const edit = document.createElement('button');
                    edit.setAttribute('onclick',`editCat(${key})`);
                    edit.className = "btn btn-warning btn-sm";
                    edit.innerText = 'Editar';
                    
                    const remove = document.createElement('button');
                    remove.setAttribute('onclick',`remCat(${key})`);
                    remove.className = "mx-4 btn btn-danger btn-sm";
                    remove.innerText = 'Remover';
                    
                    const container = document.createElement('td');
                    container.appendChild(edit);
                    container.appendChild(remove);

                    tr.appendChild(td_id);
                    tr.appendChild(td_nome);
                    tr.appendChild(container);
                    return tr;
                }

                const categoria = document.getElementById('categoria');
                categoria.innerHTML = '';
                Array.from(categorias)
                .forEach(
                        e => categoria.appendChild(
                            createCategoria(e.id,e.nome)
                        )
                    );
            }

            function setProdutos(){
                function createProduto(key,name,estoque,categoria){
                    const tr = document.createElement('tr');
                    tr.setAttribute('key',key);

                    const td_id = document.createElement('td');
                    td_id.innerText = key;
                    tr.appendChild(td_id);

                    const td_nome = document.createElement('td');
                    td_nome.innerText = name;       
                    td_nome.setAttribute('width','35%');  
                    td_nome.setAttribute('align','center');                      
                    tr.appendChild(td_nome);

                    const td_estoque = document.createElement('td');
                    td_estoque.innerText = estoque;
                    tr.appendChild(td_estoque);

                    const td_cat = document.createElement('td');
                    td_cat.innerText = categoria && categoria.nome;
                    td_cat.setAttribute('class','all_categories');                                   
                    td_cat.setAttribute('width','35%');  
                    td_cat.setAttribute('align','center');  
                    tr.appendChild(td_cat);

                    const edit = document.createElement('button');
                    edit.setAttribute('onclick',`editProd(${key})`);
                    edit.className = "btn btn-warning btn-sm";
                    edit.innerText = 'Editar';
                    
                    const remove = document.createElement('button');
                    remove.setAttribute('onclick',`remProd(${key})`);
                    remove.className = "mx-4 btn btn-danger btn-sm";
                    remove.innerText = 'Remover';
                    
                    const container = document.createElement('td');
                    container.setAttribute('width','20%');
                    container.appendChild(edit);
                    container.appendChild(remove);
                    tr.appendChild(container);

                    return tr;
                }
                const produto = document.getElementById('produto');  
                produto.innerHTML = '';              
                Array.from(produtos)
                .forEach(
                        e => produto.appendChild(
                            createProduto(e.id,e.nome,e.estoque,e.categoria)
                        )
                    );

            }

            window.onload = getAll();
            
        </script>
@endsection