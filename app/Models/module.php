<?php

namespace App\Models;

use App\Models\seance;
use App\Models\formateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class module extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_module',
        'intitule',
        'formateur_id',
    ];

    public function formateur(): BelongsTo
    {
        return $this->belongsTo(Formateur::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class);
    }

    public function formateurs(): BelongsToMany
    {
        return $this->belongsToMany(Formateur::class)
            ->withPivot('status')  // Include the pivot column 'status'
            ->withTimestamps();    // Include the pivot timestamps (if needed)
    }

    public function groupes(): BelongsToMany
    {
        return $this->belongsToMany(Groupe::class, 'groupe_module');
    }

}
