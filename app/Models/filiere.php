<?php

namespace App\Models;
use App\Models\groupe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class filiere extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom_filier',
        'niveau_formation',
        'mode_formation',
        'id'
    ];
    public function groupes():HasMany
    {
        return $this->hasMany(groupe::class);
    }
    public function formateurs(): BelongsToMany
    {
        return $this->belongsToMany(Formateur::class, 'filiere_formateur');
    }

}
