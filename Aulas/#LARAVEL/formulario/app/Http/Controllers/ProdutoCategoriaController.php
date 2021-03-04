<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutoCategoriaController extends Controller
{
    
    public function index()
    {
        $title = 'One To One';
        return view('1ton.home',compact('title'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
