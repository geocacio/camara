<?php

namespace App\Services;

use App\Generators\PDFGenerator;
use App\Models\Category;
use App\Models\ConfigureOfficialDiary;
use App\Models\Councilor;
use App\Models\Legislature;
use App\Models\LegislatureRelation;
use App\Models\officehour;
use App\Models\Setting;
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

        // pega dados da mesa diretora atual
        $councilors = [];
        $legislature = (new Legislature)->getCurrentLegislature();
        // Pega dados da mesa diretora atual
        if ($legislature) {
            $cargo = [1, 2, 3, 4];
            $getcouncilorID = LegislatureRelation::whereIn('office_id', $cargo)->where('legislature_id', $legislature->id)->get();
            if ($getcouncilorID->isNotEmpty()) {
                $councilors = Councilor::whereIn('id', $getcouncilorID->pluck('legislatureable_id'))->get();
                // Encontrar a posição da legislatura atual
                $currentLegislaturePosition = $legislature->fresh()->getOriginal('created_at');
                $currentLegislaturePosition = Legislature::where('created_at', '<=', $currentLegislaturePosition)->count();
                // Seu código para lidar com os conselheiros e a posição da legislatura atual aqui
            }
        }

        // pega dados da camara
        $sistem = Setting::first();

        $officeHour = officehour::first();
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
        
        $result = $pdf->generate($official_diary, $headerData, $footerData, $summaryGroup, $officeHour, $councilors, $sistem);

        $official_diary->files()->create(['file_id' => $result->id]);

        return $result;
    }
}
