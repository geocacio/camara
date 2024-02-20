<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplayOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'page',
        'item_id',
        'display_order',
    ];
}
