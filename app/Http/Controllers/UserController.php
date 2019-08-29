<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Variables
        $limit = ($request->has('limit') ? $request->get('limit') : '100');

        //Consulta
        $results = User::filter($request->all())->orderBy('name')->paginate($limit);

        //Fix
        $request->flashOnly(['limit', 'filter_search']);

        //Vista
        return view('users.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Datos
        $roles = Role::all()->pluck('name','id');

        //Vista
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //Validacion
        $this->validation($request);
        $this->validate($request, [
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8',
        ], [
            'username.required' => __('Debes ingresar un nombre de usuario'),
            'username.unique' => __('El nombre de usuario ya se encuentra en uso'),
            'email.required' => __('Debes ingresar un correo electrónico'),
            'email.email' => __('El formato de correo electrónico es incorrecto'),
            'email.unique' => __('El correo electronico ya se encuentra registrado'),
            'password.*' => __('Debes ingresar una contraseña de 8 carateres como mínimo'),
            'password_confirmation.*' => __('Debes ingresar la confirmación de contraseña'),
        ]);

        //Lógica

        //Setear datos
        $request->merge(['password' => bcrypt($request->password)]);
        $request->merge(['status' => 1]); //Por default activo

        //Si suben una imagen
        if ($request->hasFile('file_avatar')) {
            $image = Helper::uploadFileImage('file_avatar', User::PATH_AVATARS);
            $request->merge(['avatar' => $image]);
        }

        //Guardar
        //---Registro principal
        $user = User::create($request->input());

        //Guardar los roles
        if (!empty($request->roles)) {
            $user->roles()->sync($request->roles);
        }else{
            $user->roles()->sync([]);
        }

        //Mensaje
        flash(__('Datos guardados correctamente'))->success();

        //Redireccion
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //Redireccion
        return redirect()->route('users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //Datos
        $roles = Role::all()->pluck('name','id');

        //Vista
        return view('users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        //Validacion
        $this->validation($request);
        $this->validate($request, [
            'username' => [
                'required',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'password' => 'nullable|min:8|confirmed',
            'password_confirmation' => 'nullable|min:8',
        ], [
            'username.required' => __('Debes ingresar un nombre de usuario'),
            'username.unique' => __('El nombre de usuario ya se encuentra en uso'),
            'email.required' => __('Debes ingresar un correo electrónico'),
            'email.email' => __('El formato de correo electrónico es incorrecto'),
            'email.unique' => __('El correo electronico ya se encuentra registrado'),
            'password.*' => __('Debes ingresar una contraseña de 8 carateres como mínimo'),
            'password_confirmation.*' => __('Debes ingresar la confirmación de contraseña'),
        ]);

        //Lógica

        //Setear datos
        $request->merge(['status' => !empty($request->status) ? 1 : 0]);
        $user->fill($request->only([
            'updated_uid',
            'name',
            'username',
            'email',
            'status',
        ]));

        //Validar si se actualiza la contraseña
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        //Si suben una imagen
        if ($request->hasFile('file_avatar')) {
            //Si ya tenia un archivo lo eliminamos
            if (!empty($user->avatar)) {
                \Storage::delete(User::PATH_AVATARS . '/' . $product->image);
            }
            $avatar = Helper::uploadFileImage('file_avatar', User::PATH_AVATARS);
            $user->avatar = $avatar;
        } else {
            $user->avatar = $request->avatar; //si no tiene archivo sobreescribimos elque tenia
        }

        //Guardar los roles
        if (!empty($request->roles)) {
            $user->roles()->sync($request->roles);
        }else{
            $user->roles()->sync([]);
        }

        //Guardar
        //---Registro principal
        $user->save();

        //Mensaje
        flash(__('Datos guardados correctamente'))->success();

        //Redireccion
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //Logica
        $user->status = 0;
        $user->save();

        //Mensaje
        flash('El usuario se desactivo correctamente')->success();

        //Redireccion
        return redirect()->route('users.index');
    }

    /**
     * Validacion de formulario
     *
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'file_avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'name.*' => __('Debes ingresar un nombre'),
            'file_avatar.*' => __('La imagen es inválida solo se permite (jpg,jpeg,png)'),
        ]);
    }
}
