<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\ContactUsPage;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactUsData = ContactUsPage::first();
        return view('pages.contact-us.index', compact('contactUsData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'required|email|max:100',
            'phone' => 'nullable|string|max:20',
            'organ' => 'nullable|string|max:255',
            'nature' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
        ],
        [
            'name.required' => 'Por favor, insira seu nome.',
            'email.required' => 'Por favor, insira seu email',
            'email.email' => 'E-mail inválido',
            'subject.required' => 'Por favor, insira o assunto da mensagem.',
        ]);

        if(ContactUs::create($request->all())) {
            return redirect()->route('faleconosco.index')->with('success', 'Mensagem enviada com sucesso!');
        }else {
            return redirect()->route('faleconosco.index')->with('error', 'Erro ao enviar mensagem!');
        }
    }

    public function contactUsPage()
    {
        $contactUsPage = ContactUsPage::first();

        if($contactUsPage) {
            return view('panel.contact-us.edit', compact('contactUsPage'));
        }else {
            return view('panel.contact-us.index');
        }
    }

    public function contactUsPageStore(Request $request)
    {
        $request->validate([
            'telefone' => 'required|string|max:255',
            'opening_hours' => 'nullable|string|max:255',
            'email' => 'required|email|max:100',
        ],
        [
            'telefone.required' => 'Por favor, insira o telefone.',
            'email.required' => 'Por favor, insira o email',
            'email.email' => 'E-mail inválido',
        ]);
    
        ContactUsPage::updateOrCreate(
            ['email' => $request->email],
            [
                'telefone' => $request->telefone,
                'opening_hours' => $request->opening_hours,
                'status' => $request->status ? 1 : 0,
            ]
        );

        return redirect()->back()->with('success', 'Informações atualizadas com sucesso!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
