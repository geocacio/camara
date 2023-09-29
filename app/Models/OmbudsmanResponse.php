<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmbudsmanResponse extends Model
{
    use HasFactory;
    
    protected $fillable = ['ombudsman_survey_id', 'ombudsman_question_id', 'note', 'legend'];

    public function survey()
    {
        return $this->belongsTo(OmbudsmanSurvey::class, 'ombudsman_survey_id');
    }

    public function question()
    {
        return $this->belongsTo(OmbudsmanQuestion::class, 'ombudsman_question_id');
    }
}
