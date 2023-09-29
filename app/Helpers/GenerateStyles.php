<?php

namespace App\Helpers;

use App\Models\Style;

class GenerateStyles
{

    public static function generate()
    {
        $getStyles = Style::select('classes', 'background_color', 'background_color_night', 'title_color', 'title_color_night', 'title_size', 'subtitle_color', 'subtitle_color_night', 'subtitle_size', 'description_color', 'description_color_night', 'description_size', 'button_text_color', 'button_text_color_night', 'button_text_size', 'button_background_color', 'button_background_color_night')->get();

        $nightStyle = [];
        $dayStyle = [];

        $propertyMappings = [
            'background_color' => 'background-color',
            'background_color_night' => 'background-color',
            'title_color' => 'color',
            'title_color_night' => 'color',
            'title_size' => 'font-size',
            'subtitle_color' => 'color',
            'subtitle_color_night' => 'color',
            'subtitle_size' => 'font-size',
            'description_color' => 'color',
            'description_color_night' => 'color',
            'description_size' => 'font-size',
            'button_text_color' => 'color',
            'button_text_color_night' => 'color',
            'button_text_size' => 'font-size',
            'button_background_color' => 'background-color',
            'button_background_color_night' => 'background-color',
        ];

        foreach ($getStyles as $styles) {
            $style = $styles->getAttributes();
            $classes = $style['classes'];
            unset($style['classes']);

            $nightSelector = '.night-mode ' . $classes;
            $daySelector = $classes;

            $nightStyle[$nightSelector] = [];
            $dayStyle[$daySelector] = [];

            $night = [];
            $day = [];            

            foreach ($style as $key => $value) {
                if ($value && $key !== 'classes') {
                    if (strpos($key, '_night') !== false) {
                        $night[$key] = $value;
                    } else {
                        if ($key === 'title_size' || $key === 'subtitle_size' || $key === 'description_size' || $key === 'button_text_size') {
                            $day[$key] = $value . 'px';
                        } else {
                            $day[$key] = $value;
                        }
                    }
                }
            }

            $nightStyle[$nightSelector] = $night;
            $dayStyle[$daySelector] = $day;
        }

        // Gerar arquivo SCSS
        $scss = '';

        foreach ($nightStyle as $selector => $styles) {
            $scss .= $selector . " {\n";

            foreach ($styles as $property => $value) {
                $mappedProperty = $propertyMappings[$property] ?? $property;
                $scss .= "    " . $mappedProperty . ": " . $value . ";\n";
            }

            $scss .= "}\n\n";
        }

        foreach ($dayStyle as $selector => $styles) {
            $scss .= $selector . " {\n";

            foreach ($styles as $property => $value) {
                $mappedProperty = $propertyMappings[$property] ?? $property;
                $scss .= "    " . $mappedProperty . ": " . $value . ";\n";
            }

            $scss .= "}\n\n";
        }

        // Salvar o conteúdo do SCSS em um arquivo
        $scssFilePath = base_path('resources/sass/automaticStyle.scss');

        if (file_exists($scssFilePath)) {
            unlink($scssFilePath); // Remove o arquivo se ele existir
        }

        file_put_contents($scssFilePath, $scss);
    }
}
