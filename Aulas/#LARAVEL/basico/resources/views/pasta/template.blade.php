@extends('pasta.extensao_template')
@section('secao')
    @php
        $arr = [1,2,3,4,5,6]
    @endphp 

    @foreach ($arr as $item)
        {{ $item }}
    @endforeach
@endsection
