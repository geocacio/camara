<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'date_proponent',
        'value_proponent',
        'date_concedent',
        'value_concedent',
    ];

    public function agreements()
    {
        return $this->belongsTo(Agreement::class);
    }
}
