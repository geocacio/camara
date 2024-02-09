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

        // Verificar se $login existe e se os campos necessários estão definidos
        if (!$login) {
            $login = (object) [
                'background' => '#d9d9d9',
                'card_color' => '#ffffff',
                'button_color' => '#1c3992',
                'button_hover' => '#0d256e',
                'card_position' => 'center',
                'modal' => 1,
                'style_modal' => 'solid',
                'style_background' => 'solid',
                'show_logo' => '0',
            ];
        }

        return view('panel.login.index', compact('login'));
    }

    public function showLogin()
    {
        $login = LoginScreen::first();
        return response()->json($login);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validateData = $request->validate([
            'card_color' => 'required',
            'button_color' => 'required',
            'button_hover' => 'required',
            'card_position' => 'required',
            'modal' => 'required',
            'style_background' => 'required',
            'style_modal' => 'required',
            'show_logo' => 'required',
            
        ], [
            'card_color.required' => 'O campo cor do cartão é obrigatório.',
            'button_color.required' => 'O campo cor do botão é obrigatório.',
            'button_hover.required' => 'O campo cor do botão ao passar o mouse é obrigatório.',
            'card_position.required' => 'O campo posição do cartão é obrigatório.',
            'modal.required' => 'O campo modal é obrigatório.',
            'style_background.required' => 'O campo Estilo do fundo é obrigatório.',
        ]);

        if ($request->button_color == $request->button_hover || $request->button_color == $request->card_color || $request->button_hover == $request->card_color) {
            return redirect()->route('login.page')->with('error', 'Os campos de cores devem ser diferentes entre si.');
        }

        if ($request->card_color == $request->background) {
            return redirect()->route('login.page')->with('error', 'A cor do cartão não pode ser igual ao fundo sólido.');
        }

        $login = LoginScreen::first();

        if ($request->style_background == 'image' && $request->hasFile('background')) {
            if (Storage::disk('public')->exists($login->background)) {
                Storage::disk('public')->delete($login->background);
            }
        
            $image = $request->file('background');
            $extension = $image->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $filePath = 'login/background/public' . $fileName;
        
            Storage::disk('public')->put($filePath, file_get_contents($image));
            $validateData['background'] = $filePath;

        } else if ($request->style_background == 'solid') {
            if (Storage::disk('public')->exists($login->background)) {
                Storage::disk('public')->delete($login->background);
            }
        
            $validateData['background'] = $request->background;
        }
        
        if ($request->hasFile('logo')) {
            // Remove o logo existente
            if ($login->logo && Storage::disk('public')->exists($login->logo)) {
                Storage::disk('public')->delete($login->logo);
            }
        
            $image = $request->file('logo');
            $extension = $image->getClientOriginalExtension();
            $fileName = time() . '_' . uniqid() . '.' . $extension;
            $filePath = 'login/logo/public' . $fileName;
        
            Storage::disk('public')->put($filePath, file_get_contents($image));
            $validateData['logo'] = $filePath;
        }        
        
        if ($login->update($validateData)) {
            return redirect()->route('login.page')->with('success', 'Página login atualizada com sucesso!');
        }
        return redirect()->route('login.page')->with('error', 'Por favor tente novamente!');
    }
}
