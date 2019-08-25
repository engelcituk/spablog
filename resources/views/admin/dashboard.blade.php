@extends('admin.layout')

@section('content')
    <h1>Dashboard</h1>
    <p>Usuario autentificado: {{auth()->user()->email}}</p>
@stop