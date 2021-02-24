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
            <th>Ações</th>
        </thead>
        <tbody id="tbl">            
        </tbody>
    </table>

    <button id="lunch" type="button" class="btn btn-dark mt-5" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
            
                <form>
                    <input type="hidden" name="id" id="id" />
                    <div class="row">
                        <div class="col-auto col-6">
                            <label for="nome">NOME</label>
                            <input type="text" class="form-control" id="nome" name="nome" required/>
                        </div>
                        <div class="col-auto col-6">
                            <label for="email">E-MAIL</label>
                            <input type="text"id="email" class="form-control" name="email" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-auto col-5">
                            <label for="rua">RUA</label>
                            <input type="text" id="rua" class="form-control" name="rua" required/>
                        </div>
                        <div class=" col-auto col-5">
                            <label for="cidade">CIDADE</label>
                            <input type="text" id="cidade" class="form-control" name="cidade" required/>
                        </div>
                        <div class="col-auto col-2">
                            <label for="estado">UF</label>
                            <input type="text" id="estado" class="form-control" name="estado" required/>
                        </div>
                    </div>                                        
                </form>
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="create_btn" type="button" class="btn btn-dark" onclick="submit(true)">Create</button>
            <button id="update_btn" type="button" class="btn btn-dark" onclick="submit(false)" style="display:none">Update</button>
            
            </div>
        </div>
        </div>
    </div>     
    <!-- submit -->
    <script>
        function submit(isNeedToClearId){
            if(isNeedToClearId) document.getElementById('id').value = null;                
            const element = attr => document.getElementById(attr).value || null;   
            const id = element('id');    
            const body = new FormData();
            body.append('nome',element('nome'));
            body.append('email',element('email'));
            body.append('rua',element('rua'));
            body.append('cidade',element('cidade'));
            body.append('estado',element('estado'));
            if(!id){
                //Inserção       
                const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};         
                fetch('/api/um-para-um/',{method:'post',headers,body})
                    .then(console.log)
                    .catch(console.error)
                    .finally(getAll());                            
            }else{
                //Atualização  
                body.append('id',element('id'));
                body.append('_method','PUT')   
                const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};                              
                fetch(`/api/um-para-um/${id}`,{method:'post',headers,body})
                    .then(console.log)
                    .catch(console.error)
                    .finally(getAll());       
            }
            
        }

        function remove(id){
            let record = allData.filter(e => e.id == id);record = record[0];
            if(confirm(`Deseja Excluir ${record.nome}?`)){
                const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};
                fetch(`/api/um-para-um/${id}`,{method:'delete',headers})
                    .then(console.log)
                    .catch(console.error)
                    .finally(getAll());
            }
        }

    </script>    

    <!-- CRUD -->
    <script>
        function edit(num){
            const element = attr => document.getElementById(attr) || null;
            let record = allData.filter(e => e.id == num);record = record[0];
            
            element('id').value = num;
            element('nome').value = record.nome;
            element('email').value = record.email;
            element('rua').value = record.endereco.rua;
            element('cidade').value = record.endereco.cidade;
            element('estado').value = record.endereco.estado;                              
            element('create_btn').style.display = 'none';                              
            element('update_btn').style.display = 'inline';                              
            
        }

        document.getElementById('exampleModal')
        .addEventListener('hidden.bs.modal', function (event){
            const element = attr => document.getElementById(attr) || null;
            element('id').value = null;
            element('nome').value = null;
            element('email').value = null;
            element('rua').value = null;
            element('cidade').value = null;
            element('estado').value = null;  
            element('create_btn').style.display = 'inline';                              
            element('update_btn').style.display = 'none';              
        });        
    </script>

    <!-- get All -->
    <script>
        function getAll(){
            document.getElementById('tbl').innerHTML = '';
            function create(args){
                const fnTd = el =>  {
                    const x = document.createElement('td');
                    x.innerText = el;                
                    return x;
                };           
                
                const btnCreate = (id,className,name,fn) =>{
                    const btn = document.createElement('button');                    
                    btn.setAttribute('class',className);
                    btn.setAttribute('onclick',`${fn}(${id})`);
                    btn.innerText = name;
                    return btn;
                }

                const tr = document.createElement('tr');           
                args.forEach(e => tr.appendChild(fnTd(e)));
                const edit = btnCreate(args[0],'btn btn-outline-warning mx-3 btn-sm','Editar','edit');
                edit.setAttribute('data-bs-toggle','modal');
                edit.setAttribute('data-bs-target','#exampleModal');
                const delbtn = btnCreate(args[0],'btn btn-outline-danger btn-sm','Excluir','remove');
                tr.appendChild(edit);
                tr.appendChild(delbtn);
                return tr;            
            }
            
            function setData(json){
                const data = JSON.parse(json);  
                allData = data;                 
                for(let i = 0; i< data.length; i++){
                    let tr = create([
                        data[i].id,
                        data[i].nome,
                        data[i].email,
                        data[i].endereco.rua,
                        data[i].endereco.cidade,
                        data[i].endereco.estado
                    ]);                
                    document.getElementById('tbl').appendChild(tr);
                }           
                
            }
            
            fetch('/api/um-para-um/show/')        
            .then(response => response.text())
            .then(setData)
            .catch(console.error);
        }
        var allData = null;
        window.onload = () => getAll();
    </script>    
@endsection