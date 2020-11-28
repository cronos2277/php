<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class resource extends Controller
{
    public $clientes = [
        1 => 'João',
        2 => 'Paulo',
        3 => 'Pedro'
    ];

    public function __construct()
    {
        if(!isset($_SESSION['clientes'])){
            session(['clientes' => $this->clientes]); 
        }
        
    }

    /**
     * Mostra uma lista do recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        echo '<a href="./controller/create">adicionar novo</a>';
        echo "<table id='resource' class='resource'border=2px width=50% height=10% align=center>";
        foreach(session('clientes') as $key=>$value){
            echo "<tr class='tr-resource'>";
                echo "<td class='td-key'>".$key."</td>";
                echo "<td class='td-value'>".$value."</td>";
                echo "<td class='td-edit'><a href='./controller/$key' class='td-link'/>Detalhes</a></td>";                
                echo "<td class='td-edit'><a href='./controller/$key/edit' class='td-link'/>Editar</a></td>";                
            echo "</tr>";
        }
        echo "</table>";
    }

    /**
     * Mostra o formulário de criação de um novo recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        echo "   
            <h1>Adicionar Cliente</h1>       
            <form method='post' action='/controller'>
            <input type='hidden' name='_token' value=".csrf_token().">
                <input name='nome' />
                <input type='submit' value='enviar' />
            </form>
        ";
    }

    /**
     * Armazene um recurso recém-criado no armazenamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $clientes = session('clientes');
        $id = count($clientes) +1;        
        $clientes[$id] = $request->nome;
        session(['clientes' => $clientes]);
        return redirect()->route('controller.index');        
    }

    /**
     * Exibe o recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $clientes = session('clientes');        
        echo "<h1> O cliente selecionado é: {$id} => {$clientes[$id]} </h1>";
        echo "<a href='/controller'>voltar</a>";
    }

    /**
     * Mostra o formulário para editar o recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $clientes = session('clientes');
        echo "<h1>Edição de {$clientes[$id]}";
        echo "                  
            <form method='post' action='/controller/{$id}'>            
            <input type='hidden' name='_token' value=".csrf_token().">
                <input type='hidden' name='_method' value='PUT' />
                <input name='nome' value='{$clientes[$id]}'/>
                <input type='submit' value='enviar' />
            </form>
        ";
        echo '<br>';
        echo "<a href='/controller'>voltar</a>";
    }

    /**
     * Atualize o recurso especificado no armazenamento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $clientes = session('clientes');               
        $clientes[$id] = $request->nome;
        session(['clientes' => $clientes]);
        return redirect()->route('controller.index'); 
    }

    /**
     * Remova o recurso especificado do armazenamento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
