<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_number', 'voucher_date', 'amount', 'supplier', 'nature',
        'economic_category', 'organization', 'budget_unit', 'project_activity',
        'function', 'sub_function', 'resource_source', 'description'
    ];

    public function liquidations(): HasMany
    {
        return $this->hasMany(Liquidation::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Expenses::class);
    }
}
