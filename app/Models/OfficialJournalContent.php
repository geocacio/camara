<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialJournalContent extends Model
{
    use HasFactory;
    
    protected $table = 'official_journal_contents';

    protected $fillable = [
        'official_journal_id',
        'publication_id',
    ];

    public function officialJournal()
    {
        return $this->belongsTo(OfficialJournal::class);
    }

    public function publication()
    {
        return $this->belongsTo(SecretaryPublication::class);
    }
}
