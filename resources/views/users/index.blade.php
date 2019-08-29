@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Mensajes -->
            <div id="general_messages">
                @include('flash::message')
            </div>
            <!-- /Mensajes -->
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">USUARIOS</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    {!! Form::open(['route' => 'users.index','method' => 'GET','class' => 'form-inline','role' => 'form','id'=>'form']) !!}
                                    <div class="form-group">
                                        <label for="filter_search" class="sr-only">@lang('general.text_search')</label>
                                        <div class="input-group">
                                            {!! Form::text('filter_search', old('filter_search'), ['class' => 'form-control', 'placeholder' => __('Buscar') . '...']) !!}
                                            <div class="input-group-append">
                                                {!! Form::button('<i class="fa fa-search"></i>',['type' => 'submit', 'class' => 'btn btn-secondary']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="col-sm-8">
                                    <div class="text-sm-right">
                                        <a href="{{route('users.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center text-primary" scope="col">Avatar</th>
                                        <th scope="col">@sortablelink('name', __('Nombre'))</th>
                                        <th class="text-center" scope="col">@sortablelink('username', __('Usuario'))</th>
                                        <th class="text-center" scope="col">@sortablelink('email', __('Correo'))</th>
                                        <th class="text-center" scope="col">@sortablelink('status', __('Estatus'))</th>
                                        <th class="text-center text-primary" scope="col">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($results as $result)
                                    <tr>
                                        <th class="text-center align-middle" scope="row">
                                                <img style=""
                                                     class="rounded-circle"
                                                     src="{{!empty($result->avatar) ? $result->pathAvatar() : asset('img/logged-user.jpg')}}"
                                                     alt="{{$result->name}}"
                                                     width="50px"/>
                                        </th>
                                        <td class="align-middle">{{$result->name}}</td>
                                        <td class="text-center align-middle">{{$result->username}}</td>
                                        <td class="text-center align-middle">{{$result->email}}</td>
                                        <td class="text-center align-middle">
                                            @if($result->status)
                                                <span class="badge badge-success">Activo</span>
                                            @else
                                                <span class="badge badge-secondary">Inactivo</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <!-- form -->
                                            {!! Form::open(['route' => ['users.destroy', $result->id],'method' => 'DELETE','class' => 'hidden','role' => 'form','id' => 'form' . $result->id ]) !!}
                                            {!! Form::close() !!}
                                            <!-- /form -->
                                            <a href="{{ route('users.edit',['id' => $result->id]) }}" class="btn btn-info btn-sm">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="$('#form{{$result->id}}').submit();">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"
                                                class="text-center">@lang('No se encontraron usuarios')
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if($results->total() > 0)
                        <div class="row mb-2">
                            <div class="col-md-4">
                                {{ $results->firstItem() }} - {{ $results->lastItem() }} @lang('de') {{ $results->total() }}
                            </div>
                            <div class="col-md-8">
                                <ul class="pagination pagination-sm mb-0">
                                    {{ $results->appends(request()->except('page'))->links() }}
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
