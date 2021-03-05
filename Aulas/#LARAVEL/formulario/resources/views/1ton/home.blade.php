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
        </main>
        <script>
            var produtos;
            var categorias;             
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
                .then(afterCat)
                .catch(_ => alert('Erro ao carregar o site, verifique a conexão com o banco de dados!'));                
            };
            
            function afterCat(){
                const options = document.getElementsByClassName('all_categories');
                Array.from(options).forEach(
                    el => {
                        let font = Array.from(categorias).filter(c => el.getAttribute('category') == c.id); 
                        font = font[0];
                        if(font && font.nome){
                            el.innerText = font.nome;
                        }else{
                            el.innerText = 'N/A';
                        }                        
                    }
                )
            }

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
                Array.from(categorias)
                .forEach(
                        e => categoria.appendChild(
                            createCategoria(e.id,e.nome)
                        )
                    );
            }

            function setProdutos(){
                function createProduto(key,name,estoque,cat){
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

                    const td_catid = document.createElement('td');
                    td_catid.innerText = estoque;
                    tr.appendChild(td_catid);

                    const td_cat = document.createElement('td');
                    td_cat.setAttribute('id',`prod-${key}`);
                    td_cat.setAttribute('class','all_categories');               
                    td_cat.setAttribute('category',cat);
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
                Array.from(produtos)
                .forEach(
                        e => produto.appendChild(
                            createProduto(e.id,e.nome,e.estoque,e.categoria_id)
                        )
                    );

            }

            window.onload = getAll();
            
        </script>
@endsection