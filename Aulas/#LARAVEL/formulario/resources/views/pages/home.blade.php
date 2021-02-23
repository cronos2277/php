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
        <tbody id="tbl">            
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
            <button type="button" class="btn btn-dark" onclick="submit(true)">Save changes</button>
            </div>
        </div>
        </div>
    </div>     
    
    <script>
        function submit(isNeedToClearId){
            if(isNeedToClearId) document.getElementById('id').value = null;
            const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};     
            const element = attr => document.getElementById(attr).value || null;   
            const id = element('id');    
            console.log(id);
            if(!id){
                //Inserção
                const arr = [element('nome'),element('email'),element('rua'),element('cidade'),element('estado')];
                fetch('/api/um-para-um/',{method:'post',headers}).then(console.log).catch(console.error).finally(getAll());                            
            }else{
                //Atualização
                const arr = [id,element('nome'),element('email'),element('rua'),element('cidade'),element('estado')];
                fetch('/api/um-para-um/',{method:'put',headers}).then(console.log).catch(console.error).finally(getAll());       
            }
            
        }
    </script>
    <!-- get All -->
    <script>
        function getAll(){
            function create(args){
                const fnTd = el =>  {
                    const x = document.createElement('td');
                    x.innerText = el;                
                    return x;
                };           
                
                const tr = document.createElement('tr');           
                args.forEach(e => tr.appendChild(fnTd(e)));
                return tr;            
            }
            
            function setData(json){
                const data = JSON.parse(json);                   
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

        window.onload = () => getAll();
    </script>    
@endsection