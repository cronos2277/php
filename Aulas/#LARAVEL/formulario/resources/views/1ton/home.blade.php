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
                <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProd">ADICIONAR PRODUTO</a>
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

            <!-- Adicionar categorias -->     
            <div class="modal fade" id="addCat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Categoria</h5>
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

            <!-- Adicionar produtos -->     
            <div class="modal fade" id="addProd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating mb-3">                            
                            <input type="nome" class="form-control" id="produtoNome" placeholder="NOME" value="">
                            <label for="categoriaNome">Nome</label>
                        </div>
                    </div>
                    <div class="modal-body row">
                        <div class="form-floating mb-3 col-6">                            
                            <input type="number" class="form-control" id="produtoEstoque" placeholder="QUANTIDADE" value="">
                            <label for="categoriaNome">Estoque</label>
                        </div>

                        <div class="form-floating mb-3 col-6">                            
                            <select type="nome" class="form-select" id="produtoCategoria" value=null>
                                <option value=null selected>NENHUM</option>
                            </select>
                            <label for="categoriaNome">Nome</label>
                        </div>
                    </div>
                    <div class="modal-body">
                        
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-info" onclick="addProd()">Adicionar</button>
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

            function addProd(){
                const nome = document.getElementById('produtoNome').value;
                const estoque = document.getElementById('produtoEstoque').value;
                let categoria = document.getElementById('produtoCategoria').value;
                categoria = (categoria && categoria > 0) ? categoria : null;
                const body = new FormData();
                body.append('nome',nome);
                body.append('estoque',estoque);
                body.append('categoria_id',categoria);
                fetch('/api/um-para-muitos/p',{method:'post',headers,body})
                .then(e => (e.status == 401)? alert('Erro ao inserir'):alert(`${nome} adicionado com sucesso!`))
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

            function remProd(id){
                const body = new FormData();
                body.append('_method','DELETE');
                if(confirm('Deseja Excluir?')){
                    fetch(`/api/um-para-muitos/p/${id}`,{method:'post',headers,body})
                    .then(e => (e.status == 401) && alert('Erro ao excluir o produto!'))
                    .then(getAll)
                    .catch(console.error)
                }
            }

            function editCat(id,value){
                const body = new FormData();
                body.append('_method','PUT');
                body.append('nome',value);
                if(confirm(`Deseja alterar para ${value}?`)){
                    fetch(`/api/um-para-muitos/c/${id}`,{method:'post',headers,body})
                    .then(e => (e.status == 500) && alert('Erro ao atualizar'))
                    .then(getAll)
                    .catch(console.error);
                }else{
                    const old = (categorias) && categorias.filter(e => e.id == id);                    
                    document.getElementById(`catName-${id}`).value = old[0].nome;
                }
            }

            function prodCat(prodId,catId){
                const body = new FormData();
                body.append('_method','PUT');
                const cat = (catId) ? catId : null;
                body.append('categoria_id',cat);
                if(confirm(`Deseja alterar a categoria?`)){
                    fetch(`/api/um-para-muitos/p/c/${prodId}`,{method:'post',headers,body})
                    .then(e => (e.status == 500) && alert('Erro ao atualizar'))
                    .then(getAll)
                    .catch(console.error);
                }else{
                    const old = (produtos && prodId) ? produtos.filter(e => e.id == prodId) : 0; 
                    document.getElementById(`select_cat_prod-${prodId}`).value = old[0].categoria_id;
                }
            }

            function setEstoque(id,quantity){
                const body = new FormData();
                body.append('_method','PUT');
                const qtd = (quantity > 0)?quantity:0;
                body.append('estoque',qtd);
                if(confirm(`Deseja alterar o estoque para "${qtd}"`)){
                    fetch(`/api/um-para-muitos/p/e/${id}`,{method:'post',headers,body})
                    .then(e => (e.status == 500) && alert('Erro ao atualizar'))
                    .then(getAll)
                    .catch(console.error);
                }else{
                    const old = (produtos) && produtos.filter(e => e.id == id);                    
                    document.getElementById(`estoque-${id}`).value = old[0].estoque;
                }
            }

            function setProdNome(id,value){
                const body = new FormData();
                body.append('_method','PUT');
                body.append('nome',value);
                if(confirm(`Deseja alterar o nome do produto para "${value}"`)){
                    fetch(`/api/um-para-muitos/p/n/${id}`,{method:'post',headers,body})
                    .then(e => (e.status == 500) && alert('Erro ao atualizar'))
                    .then(getAll)
                    .catch(console.error);
                }else{
                    const old = (produtos) && produtos.filter(e => e.id == id);                    
                    document.getElementById(`nomeProd-${id}`).value = old[0].nome;
                }
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
                .then(setCategoriasProducts)                
                .catch(_ => alert('Erro ao carregar o site, verifique a conexão com o banco de dados!'))
                .finally(produtoCategoria);                
            };

            function produtoCategoria(){
                const cats = document.getElementById('produtoCategoria');
                cats.innerHTML = document.createElement('select');
                cats.setAttribute('type','nome');
                cats.setAttribute('class','form-select');
                cats.setAttribute('id','produtoCategoria');
                cats.value=null;
                const anyopt = document.createElement('option');
                anyopt.value = null;
                anyopt.innerText = "NENHUM";
                anyopt.setAttribute('selected',true);
                cats.appendChild(anyopt);                
                if(categorias){
                    categorias.forEach(
                        function(element){
                            let opt = document.createElement('option');
                            opt.value = element.id;
                            opt.innerText = element.nome;
                            cats.append(opt);
                        }
                    );
                }
            }

            function setCategoriasProducts(){
                if(produtos){
                    produtos.forEach(function(prod){
                        const element = document.getElementById(`select_cat_prod-${prod.id}`);
                        const index = element.value;
                        categorias.forEach(function(cat){
                            if(cat.id != index){
                                const opt = document.createElement('option');
                                opt.value = cat.id;
                                opt.innerText = cat.nome;
                                element.appendChild(opt);
                            }
                        });
                    });
                }
            }

            function setCategorias(){
                function createCategoria(key,name){

                    const tr = document.createElement('tr');
                    tr.setAttribute('key',key);

                    const td_id = document.createElement('td');
                    td_id.innerText = key;                    

                    const td_nome = document.createElement('td');                           
                    input_name = document.createElement('input');
                    input_name.setAttribute('id',`catName-${key}`);
                    input_name.setAttribute('class','form-control');
                    input_name.value = name;
                    input_name.setAttribute('onchange',`editCat(${key},this.value)`);
                    td_nome.append(input_name);
                    td_nome.setAttribute('width','80%');  
                    td_nome.setAttribute('align','center');                  

                    const remove = document.createElement('button');
                    remove.setAttribute('onclick',`remCat(${key})`);
                    remove.className = "mx-4 btn btn-danger btn-sm";
                    remove.innerText = 'Remover';
                    
                    const container = document.createElement('td');                    
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
                    const input_nome = document.createElement('input');
                    input_nome.value = name;
                    input_nome.setAttribute('id',`nomeProd-${key}`);
                    input_nome.setAttribute('class','form-select');
                    input_nome.setAttribute('onchange',`setProdNome(${key},this.value)`);
                    td_nome.appendChild(input_nome)
                    td_nome.setAttribute('width','35%');  
                    td_nome.setAttribute('align','center');                      
                    tr.appendChild(td_nome);

                    const td_estoque = document.createElement('td');
                    const input_estoque = document.createElement('input');
                    input_estoque.value = estoque;
                    input_estoque.setAttribute('type','number');
                    input_estoque.setAttribute('class','form-select');
                    input_estoque.setAttribute('onchange',`setEstoque(${key},this.value)`);
                    input_estoque.setAttribute('id',`estoque-${key}`);
                    td_estoque.appendChild(input_estoque);
                    tr.appendChild(td_estoque);

                    const select_cat = document.createElement('select');                    
                    const opt = document.createElement('option');
                    opt.value = (categoria && categoria.id) ? categoria.id:0;
                    opt.innerText = (categoria && categoria.nome) ? categoria.nome:'NENHUM';
                    if(categoria){
                        const anyopt = document.createElement('option');
                        anyopt.value = 0;
                        anyopt.innerText = 'NENHUM';
                        select_cat.appendChild(anyopt);
                    }
                    select_cat.appendChild(opt);
                    select_cat.value = (categoria && categoria.id) ? categoria.id : 0;
                    select_cat.setAttribute('class','all_categories form-select');                                   
                    select_cat.setAttribute('width','35%');  
                    select_cat.setAttribute('align','center'); 
                    select_cat.setAttribute('id',`select_cat_prod-${key}`); 
                    select_cat.setAttribute('onchange',`prodCat(${key},this.value)`);
                    const td_select = document.createElement('td');
                    td_select.appendChild(select_cat);
                    tr.appendChild(td_select);
                    
                    
                    const remove = document.createElement('button');
                    remove.setAttribute('onclick',`remProd(${key})`);
                    remove.className = "mx-4 btn btn-danger btn-sm";
                    remove.innerText = 'Remover';
                    
                    const container = document.createElement('td');
                    container.setAttribute('width','20%');                    
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