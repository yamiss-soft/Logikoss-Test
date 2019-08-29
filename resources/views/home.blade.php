@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <pre>
                        Autor: Fidel Angel Hernandez Cruz
                        Fecha: 28/08/2019
                        Descripción: Proyecto de pruebas Logikoss
                        Puesto: Coordinador de desarrollo Backend
                    </pre>
                </div>
                <div class="card-footer text-center">
                    <a href="{{route('users.index')}}" class="btn btn-primary" style="min-width: 100px;">Usuarios</a>
                    &nbsp;&nbsp;
                    <a href="{{route('posts.index')}}" class="btn btn-primary" style="min-width: 100px;">Posts</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
