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
                echo "<td class='td-edit'><a href='./$key/edit' class='td-link'/>Editar</a></td>";                
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
        //
    }

    /**
     * Mostra o formulário para editar o recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
