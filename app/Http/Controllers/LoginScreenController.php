<?php

namespace App\Http\Controllers;

use App\Models\LoginScreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LoginScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $login = LoginScreen::first();

        return view('panel.login.index', compact('login'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            // 'background' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'card_color' => 'required',
            'button_color' => 'required',
            'button_hover' => 'required',
            'card_position' => 'required',
            'modal' => 'required',
        ], [
            // 'background.required' => 'O campo plano de fundo é obrigatório.',
            // 'background.mimes' => 'Formatos de imagem permitidos: jpeg, png, jpg, gif, svg.',
            'card_color.required' => 'O campo cor do cartão é obrigatório.',
            'button_color.required' => 'O campo cor do botão é obrigatório.',
            'button_hover.required' => 'O campo cor do botão ao passar o mouse é obrigatório.',
            'card_position.required' => 'O campo posição do cartão é obrigatório.',
            'modal.required' => 'O campo modal é obrigatório.',
        ]);

        $login = LoginScreen::first();

        if ($request->hasFile('background')) {

            $image = $request->file('background');
            $extension = $image->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $filePath = 'login/public' . $fileName;

            Storage::disk('public')->put($filePath, file_get_contents($image));

            $validateData['background'] = $filePath;
            // Agora, $filePath contém o caminho da imagem que você pode salvar no banco de dados.
            // Certifique-se de ajustar o código conforme necessário para salvar no banco de dados.
        }
    
        if ($login->update($validateData)) {
            return redirect()->route('login.page')->with('success', 'Página login atualizada com sucesso!');
        }
        return redirect()->route('login.page')->with('error', 'Por favor tente novamente!');
    }

}
