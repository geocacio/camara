<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{
    use HasFactory;

    protected $fillable = ['voucher_id', 'liquidation_date', 'invoice_number', 'fiscal_year', 'amount'];

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
