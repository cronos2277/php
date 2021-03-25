@extends('template')
@section('section')  
<div class="mt-5">
    <h1 class="text-center mt-3">Motoristas</h1>
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
</div>
<div class="mt-5">
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
</div>
@endsection
<script>
    var motoristas = null;
    var veiculos = null;
    const headers = {'X-CSFR-TOKEN':'{{csrf_token()}}'};
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
        td_rem.setAttribute('onclick',`remove({type:'motorista',id:${id},name:'${nome}'})`);     
        td_btns.appendChild(td_rem);

        const span_val = document.createElement('span');
        span_val.setAttribute('class','mx-2')
        span_val.innerText = `${veiculos.length} veiculo(s)`;
        td_btns.appendChild(span_val);    

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
        console.log(args);
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
                vei_des.setAttribute('onclick',`uncouple({type:'veiculo',m_id:${args.id},v_id:${v.id}})`);
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
                vei_des.setAttribute('onclick',`uncouple({type:'motorista',m_id:${m.id},v_id:${args.id}})`);
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

    function uncouple(args){
        console.log(args);
    }

    window.onload = getall;    
</script>