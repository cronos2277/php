<?php

namespace App\Http\Controllers;

use App\Models\formulario;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formularios = formulario::all();
        return view('page.index', compact('formularios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nome_form' => ['required','min:3','max:99'],
                'email_form' => 'required|email|unique:formularios,email',
                'idade_form' => 'required'                
            ]
        );

        $formulario = new formulario();
        $formulario->nome = $request->input('nome_form');
        $formulario->email = $request->input('email_form');
        $formulario->idade = $request->input('idade_form');
        $formulario->salario = $request->input('sal_form');
        $formulario->save();
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function show(formulario $formulario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function edit(formulario $formulario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formulario $formulario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formulario  $formulario
     * @return \Illuminate\Http\Response
     */
    public function destroy(formulario $formulario)
    {
        //
    }
}
