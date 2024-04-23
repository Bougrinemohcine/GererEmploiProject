<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormateurGroupe extends Model
{
    use HasFactory;

    protected $table = 'formateur_groupe';

    protected $fillable = [
        'formateur_id',
        'groupe_id',
    ];

    public function formateur()
    {
        return $this->belongsTo(Formateur::class);
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }
}
