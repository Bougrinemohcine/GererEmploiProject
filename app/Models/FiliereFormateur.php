<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FiliereFormateur extends Model
{
    use HasFactory;
    protected $table = 'filiere_formateur';
    protected $fillable = ['filiere_id', 'formateur_id']; // Add other fillable columns if needed

    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class);
    }

    public function formateur(): BelongsTo
    {
        return $this->belongsTo(Formateur::class);
    }
}
