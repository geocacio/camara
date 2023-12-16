<?php

namespace App\Services;

use App\Generators\PDFGenerator;
use App\Models\Category;
use App\Models\ConfigureOfficialDiary;
use Illuminate\Support\Facades\Storage;

class PdfServices
{
    public function officialDiaryGenerate($official_diary)
    {
        // dd($official_diary);
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

        // Cria um novo objeto PDF usando a classe personalizada PDFGenerator
        $pdf = new PDFGenerator(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $configurations = ConfigureOfficialDiary::first();
        
            if (isset($configurations)) {
            $headerData = array(
                'logoPath' => !$configurations->files->isEmpty() ? storage_path('app/public/' . $configurations->files[0]->file->url) : '',
                'title' => $configurations->title,
                'subtitle' => $configurations->subtitle,
                'infoRight' => $configurations->text_one,
                'infoCenter' => $configurations->text_two,
                'textThree' => $configurations->text_three,
            );

            $footerData = array(
                'title' => $configurations->footer_title,
                'description' => $configurations->footer_text
            );
            
        } else {
            
            $headerData = array(
                'logoPath' => '',
                'title' => '',
                'subtitle' => '',
                'infoRight' => '',
                'infoCenter' => '',
                'textThree' => '',
            );

            $footerData = array(
                'title' => '',
                'description' => ''
            );
            
        }
        
        $result = $pdf->generate($official_diary, $headerData, $footerData, $summaryGroup);

        $official_diary->files()->create(['file_id' => $result->id]);

        return $result;
    }
}
