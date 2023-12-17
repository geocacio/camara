<?php

namespace App\Http\Controllers;

use App\Models\SicUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SicUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        // dd('passou aqui no if', $request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = SicUser::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            // Faça o login manualmente usando o guard sicusers
            dd(Auth::guard('sicuser')->login($user));

            return redirect()->route('sic.show')->with('success', 'Bem vindo ' . $user->name);
        }

        return redirect()->back()->with('error', 'Credenciais inválidas. Por favor, tente novamente.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'cpf' => $request->person_type == 'fisica' ? 'required' : 'nullable',
            'cnpj' => $request->person_type == 'juridica' ? 'required' : 'nullable',
            'name' => 'required',
            'birth' => 'required|date',
            'sex' => 'required|in:male,female',
            'phone' => 'required',
            'email' => 'required|email|unique:sic_users,email',
            // 'schooling' => 'required',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ]
        ], [
            'cpf.required' => 'Insira o campo cpf é obrigatório',
            'cnpj.required' => 'Insira o campo cnpj é obrigatório',
            'name.required' => 'Insira o campo nome é obrigatório',
            'birth.required' => 'Insira o campo data de nascimento é obrigatório',
            'sex.required' => 'Insira o campo sexo é obrigatório',
            'email.required' => 'Insira o campo e-mail é obrigatório',
            // 'schooling.required' => 'Insira o campo escolaridade é obrigatório',
            'phone.required' => 'Insira o campo telefone é obrigatório',
            'password.required' => 'Insira o campo password é obrigatório',
            'confirmed' => 'As senhas não conferem.',
        ]);

        $validatedData['birth'] = Carbon::createFromFormat('d/m/Y', $request->birth)->format('Y-m-d');
        $validatedData['password'] = bcrypt($request->input('password'));
        $validatedData['slug'] = Str::slug($request->name);

        $sicUser = SicUser::create($validatedData);

        if ($sicUser) {
            return redirect()->route('sic.login')->with('success', 'Cadastro realizado com sucesso!');
        }
        return redirect()->back()->with('error', 'Por favor tente novamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SicUser $sicUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SicUser $sicUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SicUser $sicUser)
    {
        dd($sicUser);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SicUser $sicUser)
    {
        //
    }
}
