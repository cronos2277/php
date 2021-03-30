@extends('template')
@section('section')  
<div class="mt-5 bg-dark text-white">
    <div class="row">
        <h1 class="text-center mt-3">Motoristas</h1>        
    </div>
    <table class="table table-bordered border-white text-white">
        <thead class="bg-dark">
            <th>ID</th>
            <th>NOME</th>
            <th>CPF</th>
            <th>AÇÕES</th>
        </thead>
        <tbody id="motoristas">
            
        </tbody>        
    </table>
    <div class="row">
        <button 
            type="button" 
            class="btn btn-secondary border-dark border-5" 
            data-bs-toggle="modal" 
            data-bs-target="#modal" 
            onclick="add({'type':'motorista','action':'create'})">Adicionar Motorista</button>
    </div>
</div>
<div class="mt-5 bg-dark text-white">
    <h1 class="text-center mt-3">Veiculos</h1>
    <table class="table table-bordered border-white text-white">
        <thead class="bg-dark">
            <th>ID</th>
            <th>PLACA</th>
            <th>COR</th>
            <th>LUXO</th>
            <th>AÇÕES</th>
        </thead>
        <tbody id="veiculos">
            
        </tbody>
    </table>
    <div class="row">
        <button 
            type="button"
            class="btn btn-secondary border-dark border-5"
            data-bs-toggle="modal"
            data-bs-target="#modal"
            onclick="add({'type':'veiculo','action':'create'})">Adicionar Veiculo</button>
    </div>
</div>
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearModal()"></button>
        </div>
        <div class="modal-body" id="frame">
            
        </div>
        <div class="modal-footer" id="buttons">
            <button 
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
                onclick="clearModal()">Close</button>            
        </div>
        </div>
    </div>
</div>
@endsection
<script>
    var motoristas = null;
    var veiculos = null;
    const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};
    const clearModal = () => document.getElementById('frame').innerHTML = "";
    const ullist = document.createElement('tr');
    ullist.setAttribute('id','ullist');
    ullist.setAttribute('class','bg-primary py-5');    
    function cleanTables(){
        document.getElementById('motoristas').innerHTML = "";
        document.getElementById('veiculos').innerHTML = "";
    }    
    function getall(){
        fetch('http://127.0.0.1:8000/api/muitos-para-muitos/m')
            .then(data => data.text())
            .then(data => JSON.parse(data))
            .then(data => Array.from(data))
            .then(data => data.map(d => setMotorista(d.id,d.nome,d.cpf,d.veiculos)))

            .then(data => motoristas = data)            
            .catch(_ => console.error('Não foi possível carregar Motoristas'));

        fetch('http://127.0.0.1:8000/api/muitos-para-muitos/v')
        .then(data => data.text())
            .then(data => JSON.parse(data))
            .then(data => Array.from(data))
            .then(data => data.map(v => setVeiculos(v.id,v.placa,v.cor,v.luxo,v.motoristas)))

            .then(data => veiculos = data)            
            .catch(_ => console.error('Não foi possível carregar Veículos'));

            document.getElementsByTagName('body')[0]?.setAttribute('class','bg-dark');
    }

    function setMotorista(id,nome,cpf,veiculos){
        const data = {id,nome,cpf};                
        const motoristas = document.getElementById('motoristas'); 
        motoristas.setAttribute('class','bg-secondary');       
        const out = document.createElement('tr'); 
        out.setAttribute('id',`m-${id}`);       
        const td_id = document.createElement('td');
        td_id.innerText = id;
        td_id.setAttribute('width','5%');        
        const td_nome = document.createElement('td');
        td_nome.setAttribute('width','50%');
        const input_nome = document.createElement('input');
        input_nome.setAttribute('class','form-control');
        input_nome.setAttribute("value",nome);
        input_nome.setAttribute('onchange',`change({type:'nome',data:{id:${id},nome:'${nome}',cpf:'${cpf}'},payload:this.value})`);
        td_nome.appendChild(input_nome);
        const td_cpf = document.createElement('td');
        td_cpf.setAttribute('width','20%');
        const input_cpf = document.createElement('input');
        input_cpf.setAttribute('onchange',`change({type:'cpf',data:{id:${id},nome:'${nome}',cpf:'${cpf}'},payload:this.value})`);
        input_cpf.setAttribute('value',cpf);
        input_cpf.setAttribute('class','form-control');
        td_cpf.appendChild(input_cpf);

        const td_btns = document.createElement('td');
        const td_veic = document.createElement('button');
        td_veic.innerText = 'Veiculos';        
        td_veic.setAttribute('onclick',`show({type:'motorista',name:'${nome}',id:${id}})`);
        td_veic.setAttribute('class','btn btn-info mx-1');   
        td_btns.appendChild(td_veic);             

        const td_rem = document.createElement('button');
        td_rem.innerText = 'Remover';
        td_rem.setAttribute('class','btn btn-danger');   
        td_rem.setAttribute('onclick',`remove({type:'motorista',id:${id},nome:'${nome}'})`);     
        td_btns.appendChild(td_rem);        

        const span_val = document.createElement('span');
        span_val.setAttribute('class','mx-2')
        span_val.innerText = `${veiculos.length} veiculo(s)`;
        td_btns.appendChild(span_val);    

        const assoc = document.createElement('button');
        assoc.innerText = '+ Veiculo';
        assoc.setAttribute('class','mx-3 p-1 btn btn-success');
        assoc.setAttribute('onclick',`relationship({action:'assoc',type:'veiculo',id:${id}})`);  
        assoc.setAttribute('data-bs-toggle','modal');
        assoc.setAttribute('data-bs-target','#modal');
        td_btns.appendChild(assoc);

        out.appendChild(td_id);
        out.appendChild(td_nome);
        out.appendChild(td_cpf);
        out.appendChild(td_btns);        
        motoristas.appendChild(out);
        return {id,nome,cpf,veiculos};
    }

    function setVeiculos(id,placa,cor,isLuxo,motoristas){
        const data = {id,placa,cor,isLuxo};
        const veiculos = document.getElementById('veiculos');
        veiculos.setAttribute('class','bg-secondary');
        const out = document.createElement('tr');        
        out.setAttribute('id',`v-${id}`);
        const td_id = document.createElement('td');
        td_id.innerText = id;
        td_id.setAttribute('width','5%');
        const td_placa = document.createElement('td');
        const input_placa = document.createElement('input');
        input_placa.setAttribute('value',placa);
        input_placa.setAttribute('class','form-control');
        input_placa.setAttribute('onchange',`change({type:'placa',data:{id:${id},placa:'${placa}',cor:'${cor}',luxo:'${isLuxo}'},payload:this.value})`);
        td_placa.appendChild(input_placa);

        const td_cor = document.createElement('td');
        td_cor.setAttribute('width','10%');
        const input_cor = document.createElement('input');
        input_cor.setAttribute('type','color');        
        input_cor.setAttribute('value',cor);
        input_cor.setAttribute('onchange',`change({type:'cor',data:{id:${id},placa:'${placa}',cor:'${cor}',luxo:'${isLuxo}'},payload:this.value})`);
        const span_cor = document.createElement('span');
        span_cor.innerText = cor;
        span_cor.setAttribute('class','mx-2');
        td_cor.appendChild(input_cor);
        td_cor.appendChild(span_cor);

        const td_luxo = document.createElement('td');
        td_luxo.setAttribute('width','5%');
        const input_luxo = document.createElement('input');
        input_luxo.setAttribute('type','checkbox');
        input_luxo.setAttribute('class','form-check-input');
        input_luxo.setAttribute('onchange',`change({type:'luxo',data:{id:${id},placa:'${placa}',cor:'${cor}',luxo:'${isLuxo}'},payload:this.checked})`);
        if(isLuxo === 1){
            input_luxo.setAttribute('checked',true);
        }
        td_luxo.appendChild(input_luxo);
        
        const td_btns = document.createElement('td');
        const btn_mot = document.createElement('button');
        btn_mot.innerText = 'Motoristas';
        btn_mot.setAttribute('class','btn btn-info mx-2');
        btn_mot.setAttribute('onclick',`show({type:'veiculo',placa:'${placa}',id:${id}})`);

        td_btns.appendChild(btn_mot);
        const btn_rem = document.createElement('button');
        btn_rem.setAttribute('class','btn btn-danger');
        btn_rem.setAttribute('onclick',`remove({type:'veiculo',id:${id},placa:'${placa}'})`);
        btn_rem.innerText = 'Remover';
        td_btns.appendChild(btn_rem);
        

        const span_val = document.createElement('span');
        span_val.setAttribute('class','mx-2')
        span_val.innerText = `${motoristas.length} motorista(s)`;
        td_btns.appendChild(span_val);            

        const assoc = document.createElement('button');
        assoc.innerText = '+ Motorista';
        assoc.setAttribute('class','mx-3 p-1 btn btn-success');
        assoc.setAttribute('onclick',`relationship({action:'assoc',type:'motorista',id:${id}})`);
        assoc.setAttribute('data-bs-toggle','modal');
        assoc.setAttribute('data-bs-target','#modal');
        td_btns.appendChild(assoc);

        out.appendChild(td_id);
        out.appendChild(td_placa);
        out.appendChild(td_cor);
        out.appendChild(td_luxo);
        out.appendChild(td_btns);
        veiculos.appendChild(out);
        return{id,placa,cor,isLuxo,motoristas};
    }
    
    function change(arg){        
        let url = null;
        let body = new FormData();
        body.append('_method','PUT');
        if(arg.type === 'cpf' || arg.type === 'nome'){
            url = `http://127.0.0.1:8000/api/muitos-para-muitos/m/${arg.data.id}`;
            const cpf = (arg.type === 'cpf') ? arg.payload : arg.data.cpf;
            const nome = (arg.type === 'nome') ? arg.payload : arg.data.nome;
            body.append('cpf',cpf);
            body.append('nome',nome);            
        }else if(arg.type === 'placa' || arg.type === 'cor' || arg.type === 'luxo'){
            url = `http://127.0.0.1:8000/api/muitos-para-muitos/v/${arg.data.id}`;
            const placa = (arg.type === 'placa') ? arg.payload : arg.data.placa;
            const cor = (arg.type === 'cor') ? arg.payload : arg.data.cor;
            const luxo = (arg.type === 'luxo') ? arg.payload : arg.data.luxo;
            body.append('placa',placa);
            body.append('cor',cor);
            body.append('luxo',luxo);
        }else{
            throw new Error('operação inválida!')
        }            
        fetch(url,{body,headers,method:'POST'})      
        .then(e => (e.status == 401)? alert('Erro ao atualizar'):alert(`${arg.type} atualizado com sucesso!`))     
        .then(cleanTables)     
        .then(getall)
        .catch(e => alert(`Erro atualizar`));        
    }

    function remove(args){
        let url = `http://127.0.0.1:8000/api/muitos-para-muitos/`;
        if(args.type === "veiculo"){
            url += `v/${args.id}`;
        }else if(args.type === "motorista"){
            url += `m/${args.id}`;
        }else{
            throw new Error('Operação inválida!');
        }
        
        if(confirm(`Você deseja excluir o ${args.type} ${(args.nome)?args.nome:args.placa}`)){
            fetch(url,{method:'DELETE',headers})
            .then(e => {(e.status == 401) && alert(`Esse ${args.type} não pode ser excluído, devido a associações!`); return e;})
            .then(r => r.text())
            .then(getall)
            .then(cleanTables)
            .catch(console.error);
        }  
    }

    function show(args){            
        ullist.innerHTML = "";    
        if(args.type === "motorista"){
            let veiculos_motoristas = motoristas.filter(m => m.id === args.id);            
            veiculos_motoristas = veiculos_motoristas.flatMap(m => m.veiculos);
            const m_id = document.getElementById(`m-${args.id}`);                                    
            veiculos_motoristas.forEach(v => {                
                const uncouple = document.createElement('td');
                const span = document.createElement('span');
                span.innerText = `ID: ${v.id}`;
                span.setAttribute('class','mx-3')
                uncouple.setAttribute('width','10%');
                uncouple.setAttribute('colspan','1');
                const vei_des = document.createElement('button');
                vei_des.innerText = "Desassociar";
                vei_des.setAttribute('class','btn btn-warning');
                vei_des.setAttribute('onclick',`relationship({action:'uncouple',type:'motorista',m_id:${args.id},v_id:${v.id}})`);
                uncouple.appendChild(span);
                uncouple.appendChild(vei_des);
                ullist.appendChild(uncouple);
                const placa = document.createElement('td');
                placa.innerText = `Placa: ${v.placa}`;
                placa.setAttribute('width',"20%");
                placa.setAttribute('colspan','1');
                ullist.appendChild(placa);
                const cor = document.createElement('td');
                cor.setAttribute('width',"20%");
                cor.setAttribute('colspan','1');
                cor.innerText = `Cor: ${v.cor}`
                ullist.appendChild(cor);
                const luxo = document.createElement('td');
                luxo.setAttribute('width',"20%");
                luxo.setAttribute('colspan','1');
                luxo.innerText = `LUXO? ${(v.luxo)?'Sim':'Não'}`;
                ullist.appendChild(luxo);
            });
            m_id.parentNode.insertBefore(ullist,m_id.nextSibling);            
        }else if(args.type === "veiculo"){
            const v_id = document.getElementById(`v-${args.id}`);  
            let motoristas_veiculos = veiculos.filter(v => v.id === args.id);
            motoristas_veiculos = motoristas_veiculos.flatMap(v => v.motoristas);
            motoristas_veiculos.forEach(m => {
                const uncouple = document.createElement('td');
                const span = document.createElement('span');
                span.innerText = `ID: ${m.id}`;
                span.setAttribute('class','mx-3')
                uncouple.setAttribute('width','10%');
                uncouple.setAttribute('colspan','1');
                const vei_des = document.createElement('button');
                vei_des.innerText = "Desassociar";
                vei_des.setAttribute('class','btn btn-warning');
                vei_des.setAttribute('onclick',`relationship({action:'uncouple',type:'veiculo',m_id:${m.id},v_id:${args.id}})`);
                uncouple.appendChild(span);
                uncouple.appendChild(vei_des);
                ullist.appendChild(uncouple);
                const nome = document.createElement('td');
                nome.innerText = `Nome: ${m.nome}`;
                nome.setAttribute('width','50%');
                nome.setAttribute('colspan','2');
                ullist.appendChild(nome);
                const cpf = document.createElement('td');
                cpf.innerText = `CPF: ${m.cpf}`;
                cpf.setAttribute('colspan','2');
                ullist.appendChild(cpf);
            });
            v_id.parentNode.insertBefore(ullist,v_id.nextSibling);
        }else{
            throw new Error("Operação inválida")
        }        
    }

    function relationship(args){
        const method = (args.action === "assoc") ? 'POST' : 'DELETE';
        const frame = document.getElementById('frame');
        const title = document.getElementById('exampleModalLabel');
        const btns = document.getElementById('buttons');
        document.getElementById('sbtm')?.remove();
        if(args.action === "assoc"){
            title.innerText = `Associar ${args.type}`;
            const div = document.createElement('div');
            const label = document.createElement('label');
            label.setAttribute('class','form-label');
            const select = document.createElement('select');
            select.setAttribute('class','form-control');
            select.setAttribute('id','select');
            const dft = document.createElement('option');
            dft.setAttribute('value',null);
            dft.selected = true;
            dft.innerText = "Selecione uma opção";
            select.appendChild(dft);
            if(args.type === "motorista" && motoristas){
                motoristas.forEach(function(element){                                           
                    let opt = document.createElement('option');
                    opt.setAttribute('value',element.id);
                    opt.innerText = element.nome;                                  
                    select.appendChild(opt);
                });
            }else if(args.type === "veiculo" && veiculos){
                veiculos.forEach(function(element){
                    let opt = document.createElement('option');
                    opt.setAttribute('value',element.id);
                    opt.innerText = element.placa;
                    select.appendChild(opt);
                });
            }
            div.appendChild(label);
            div.appendChild(select);
            frame.appendChild(div);
            const submit = document.createElement('button');
            submit.innerText = "Associar!";
            submit.setAttribute('class','btn btn-primary');
            submit.setAttribute('onclick',`assoc({type:"${args.type}",id:${args.id}})`)
            submit.setAttribute('id','sbtm');
            btns.appendChild(submit);
        }else if(args.action === "uncouple"){
            let url = `http://127.0.0.1:8000/api/muitos-para-muitos/d`;
            const body = new FormData();            
            body.append('type',args.type);
            body.append('_method',method);              
            body.append('veiculo_id',args.v_id);
            body.append('motorista_id',args.m_id);      
            fetch(url,{method:"POST",body,headers})
                .then(r => r.text())
                .then(cleanTables)
                .then(getall)
                .catch(console.error);
        }else{
            throw new Error('Operação Inválida!');
        }              
    }  
    
    function assoc(args){
        
        const selected = document.getElementById('select');
        let url = `http://127.0.0.1:8000/api/muitos-para-muitos/`;        
        const body = new FormData();
        body.append('id',selected.value); 
        body.append('_method','PATCH');
        console.log(args.id,selected.value);       
        if(args.type === "motorista"){
            url += `v/${args.id}`;            
        }else if(args.type === "veiculo"){
            url += `m/${args.id}`;            
        }else{
            throw new Error('Operação Ilegal');
        }
        fetch(url,{method:"POST",body,headers})
        .then(r => r.text())
        .then(cleanTables)
        .then(getall)
        .catch(console.error);
    }

    function add(args){        
        const frame = document.getElementById('frame');
        const title = document.getElementById('exampleModalLabel');
        const btns = document.getElementById('buttons');
        document.getElementById('sbtm')?.remove();
        if(args.action === "create" && args.type === "motorista"){
            title.innerText = "Adicionar Motorista";
            const div = document.createElement('div'); 
            div.setAttribute('class','container');                     
            const nome_input = document.createElement('input');
            nome_input.setAttribute('id','nome');            
            nome_input.setAttribute('class','form-control');
            const nome_label = document.createElement('label');
            nome_label.setAttribute('class','form-label');
            nome_label.setAttribute('for','nome');
            nome_label.innerText = "Informe o nome: ";
            const cpf_input = document.createElement('input');
            cpf_input.setAttribute('class','form-control');
            cpf_input.setAttribute('id','cpf');
            const cpf_label = document.createElement('label');
            cpf_label.setAttribute('class','form-label');
            cpf_label.setAttribute('for','cpf');
            cpf_label.innerText = "Informe o CPF";
            div.appendChild(nome_label);
            div.appendChild(nome_input);
            div.appendChild(cpf_label);
            div.appendChild(cpf_input);
            frame.appendChild(div);
            const submit = document.createElement('submit');
            submit.innerText = "Enviar!";
            submit.setAttribute('class','btn btn-primary');
            submit.setAttribute('onclick',`
                    postSubmit({type:"${args.type}",
                    action:"${args.action}",
                    payload:['nome','cpf']
                })
            `);
            submit.setAttribute('id','sbtm');
            btns.appendChild(submit);
        }else if(args.action === "create" && args.type === "veiculo"){
            title.innerText = "Adicionar Veiculo";
            const div = document.createElement('div');
            div.setAttribute('class','container');
            placa_input = document.createElement('input');
            placa_input.setAttribute('id','placa');
            placa_input.setAttribute('class','form-control');
            const placa_label = document.createElement('label');
            placa_label.setAttribute('for','placa');
            placa_label.setAttribute('class','form-label');
            placa_label.innerText = "Informe a Placa:";
            div.appendChild(placa_label);
            div.appendChild(placa_input);
            frame.appendChild(div);
            const row = document.createElement('div');
            row.setAttribute('class','row');
            const col1 = document.createElement('td');
            col1.setAttribute('class','col-6');
            const cor = document.createElement('input');
            cor.setAttribute('type','color');
            cor.setAttribute('class','col-6');
            cor.setAttribute('id','cor');
            const label_cor = document.createElement('label');
            label_cor.innerText = "Cor do Veículo: ";
            label_cor.setAttribute('class','form-label');
            col1.appendChild(label_cor);
            col1.appendChild(cor);
            const luxo = document.createElement('input');
            luxo.setAttribute('type','checkbox');
            luxo.setAttribute('class','form-check-input p-2 mx-1');
            luxo.setAttribute('id','luxo');
            const isLuxo = document.createElement('label');
            isLuxo.setAttribute('class','form-check-label');
            isLuxo.innerText = 'É um veículo de luxo? ';
            const col2 = document.createElement('td');
            col2.setAttribute('class','col-6 p-3');            
            col2.appendChild(isLuxo);
            col2.appendChild(luxo);
            row.appendChild(col1);
            row.appendChild(col2);            
            div.appendChild(row);
            const submit = document.createElement('submit');
            submit.innerText = "Enviar!";
            submit.setAttribute('class','btn btn-primary');
            submit.setAttribute('onclick',`
            postSubmit({
                    type:"${args.type}",
                    action:"${args.action}",
                    payload:['placa','cor','luxo']
                })                
            `);
            submit.setAttribute('id','sbtm');
            btns.appendChild(submit);
        }
    }    

    function postSubmit(args){
        const body = new FormData();
        const method = (args.action === "create")?'POST':'PUT';
        let url = `http://127.0.0.1:8000/api/muitos-para-muitos/`;

        args.payload.forEach(function(element){
            let value = document.getElementById(element)?.value;                        
            body.append(element,value);
        });     

        if(args.type === "veiculo"){
            url += 'v';
        }else if(args.type === "motorista"){
            url += 'm';
        }else{
            throw new Error('Operação inválida!');
        }

        fetch(url,{method,headers,body})
        .then(r => {(r.status === 401) && alert('todos os campos devem ser válidos');return r})
        .then(r => r.text())
        .then(cleanTables)
        .then(getall)
        .catch(console.error);
    }

    window.onload = getall;    
</script>