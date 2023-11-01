<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('panel.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $employees = Employee::whereDoesntHave('user')->get();
        $roles = Role::all();
        $employees = Employee::all();
        return view('panel.users.create', compact('employees', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'employee_id' => 'nullable',
            'email' => 'required|email',
            'status' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = User::create($validatedData);
        if ($user) {
            $user->roles()->attach($validatedData['role_id']);
            return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
        }

        return redirect()->route('users.index')->with('error', 'Erro, por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // $employees = Employee::whereDoesntHave('user')->get();
        $roles = Role::all();
        $employees = Employee::all();
        return view('panel.users.edit', compact('user', 'employees', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'employee_id' => 'nullable',
            'email' => 'required|email',
            'status' => 'required',
            'password' => 'nullable|confirmed',
        ]);

        // Verificar se o usuário deseja trocar a senha
        $passwordChanged = isset($validatedData['password']) && !empty($validatedData['password']);

        // Remover o campo de confirmação de senha, pois não é necessário mais
        unset($validatedData['password_confirmation']);

        // Se a senha foi alterada, hash a nova senha
        if ($passwordChanged) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Se a senha não foi alterada, remova o campo da validação
            unset($validatedData['password']);
        }

        $user->update($validatedData);
        
        $user->roles()->detach();
        $user->roles()->attach($validatedData['role_id']);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
