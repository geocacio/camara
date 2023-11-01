<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\SecretaryPublication;
use App\Models\User;
use App\Models\OfficialJournal;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Storage;
use TCPDF;
use App\Generators\PDFGenerator;
use App\Models\Category;
use App\Models\ConfigureOfficialDiary;

class PdfController extends Controller
{
    private $fileUploadService;
    private $timeLimit = '23:00';

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function gerarPDF()
    {
        $dados = User::all();
        $html = view('pdf.template', compact('dados'))->render();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'relatorio');

        $pdf->save($tempFilePath);

        // return $pdf->download('relatorio.pdf');

        return response()->file($tempFilePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="relatorio.pdf"'
        ]);
    }

    public function generateOfficialDiary(OfficialJournal $official_diary)
    {
        $summaryGroup = Category::where('slug', 'sumario')->with('children')->first();
        $summaryGroup = $summaryGroup->children->toArray();
        //Remove a versão atual...
        if (!empty($official_diary->files)) {
            foreach ($official_diary->files as $pdf) {
                Storage::disk('public')->delete($pdf->file->url);
                $pdf->delete();
                $pdf->file->delete();
            }
        }

        $configurations = ConfigureOfficialDiary::first();
        // dd($configurations->files->count());

        // Cria um novo objeto PDF usando a classe personalizada PDFGenerator
        $pdf = new PDFGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        $headerData = array(
            'logoPath' => !$configurations->files->isEmpty() ? $configurations->files[0]->url : '',
            'title' => $configurations->title,
            'subtitle' => $configurations->subtitle,
            'infoRight' => $configurations->text_one,
            'infoCenter' => $configurations->text_two,
            'textThree' => $configurations->text_three,
        );

        $footerData = array(
            'title' => 'Município de xxxxxxx – Estado do Maranhão',
            'description' => 'Diário Oficial assinado digitalmente conforme MP nº 2.200-2, de 2001, garantindo autenticidade, validade jurídica e integridade'
        );

        $result = $pdf->generate($official_diary, $headerData, $footerData, $summaryGroup);

        $official_diary->files()->create(['file_id' => $result->id]);

        return redirect()->route('official-diary.index')->with('success', 'Diário Oficial finalizado com sucesso!');
    }
}
