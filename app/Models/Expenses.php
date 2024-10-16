<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_id',
        'payment_number',
        'creditor_number',
        'date',
        'exercise',
        'fase',
        'valor',
        'organ',
        'text_button',
        'url',
    ];
}
