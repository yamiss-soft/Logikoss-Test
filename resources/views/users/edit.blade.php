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
                    <div class="card-header">EDITAR USUARIO</div>
                    {!! Form::model($user,['route' => ['users.update',$user->id],'method' => 'PUT','class' => 'form-horizontal','role' => 'form','id' => 'form','files' => true]) !!}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 offset-md-3">
                                <div class="card-box text-center" style="">
                                    <img src="{{!empty($user->avatar) ? $user->pathAvatar() : asset('img/logged-user.jpg')}}" class="rounded-circle img-thumbnail"
                                         alt="profile-image"
                                         data-placeholder="{{asset('img/logged-user.jpg')}}"
                                         style="height: 10rem; width: 10rem;"
                                         id="img_avatar">

                                    <div class="mt-1 was-validated">
                                        {!! Form::button(__('Editar'),['type' => 'button', 'class' => 'btn btn-success','id' =>'btn_edit_avatar']) !!}
                                        {!! Form::button(__('Borrar'),['type' => 'button', 'class' => 'btn btn-danger','id' =>'btn_delete_avatar']) !!}
                                        <div class="form-group">
                                            {!! Form::file('file_avatar', ['class'=> 'd-none']) !!}
                                            @error('file_avatar')
                                            <span class="invalid-feedback d-block" role="alert">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <p class="text-muted">&nbsp;</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('name', __('Nombre') . ' <span class="text-danger">*</span>', ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6">
                                        {!! Form::text('name', old('name'), ['class' => 'form-control ' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => __('Nombre'),'required','autofocus']) !!}
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('username', __('Usuario') . ' <span class="text-danger">*</span>', ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6">
                                        {!! Form::text('username', old('username'), ['class' => 'form-control ' . ($errors->has('username') ? ' is-invalid' : ''), 'placeholder' => __('Usuario'),'required','autofocus']) !!}
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('email', __('Correo electrónico') . ' <span class="text-danger">*</span>', ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6">
                                        {!! Form::email('email', old('email'), ['class' => 'form-control ' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => __('Correo electrónico'),'required']) !!}
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('password', __('Contraseña') . ' <span class="text-danger">*</span>', ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6">
                                        {!! Form::password('password', ['class' => 'form-control ' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => __('Contraseña')]) !!}
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('password_confirmation', __('Confirmar contraseña') . ' <span class="text-danger">*</span>', ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6">
                                        {!! Form::password('password_confirmation', ['class' => 'form-control ' . ($errors->has('password_confirmation') ? ' is-invalid' : ''), 'placeholder' => __('Confirmar contraseña')]) !!}
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('roles[]', __('Roles') . '', ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6">
                                        {!! Form::select('roles[]', $roles,old('roles'), ['class' => 'form-control ' . ($errors->has('roles') ? ' is-invalid' : ''),'multiple']) !!}
                                        @error('roles')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! html_entity_decode(Form::label('status', __('Estatus') , ['class' => 'col-3 col-form-label text-right'])) !!}
                                    <div class="col-6 pt-1">
                                            {!! Form::checkbox('status', '1',(!empty(old('status',$user->status)) ? true : false),[]); !!}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-9 offset-3">
                                {!! Form::button(__('Guardar'),['type' => 'submit', 'class' => 'btn btn-info']) !!}
                                &nbsp;
                                <a href="{{route('users.index')}}" class="btn btn-secondary">@lang('Descartar')</a>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {
            $("#form #btn_edit_avatar").on("click", function (e) {
                e.preventDefault();
                $("#form input[name='file_avatar']").trigger('click');
            });
            $("#form #btn_delete_avatar").on("click", function (e) {
                e.preventDefault();
                $("#form #img_avatar").attr('src', $("#form #img_avatar").attr('data-placeholder'));
                $("#form input[name='avatar']").val('');
            });
            $("#form input[name='file_avatar']").on("change", function () { //Precarga imagen para visualizar
                if ($(this)[0].files && $(this)[0].files[0]) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        $("#form #img_avatar").attr("src", e.target.result);
                    };
                    reader.readAsDataURL($(this)[0].files[0]);
                }
            });
        });
    </script>
@endsection
