<?php

namespace App\Models;

use App\Models\module;
use App\Models\seance;
use App\Models\filiere;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_groupe',
        'Mode_de_formation',
        'Niveau',
        'filiere_id',
        'stage',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function seances(): HasMany
    {
        return $this->hasMany(Seance::class, 'id_groupe');
    }

    public function formateurs(): BelongsToMany
    {
        return $this->belongsToMany(Formateur::class);
    }

    public function modules(): BelongsToMany
{
    return $this->belongsToMany(module::class, 'groupe_module');
}

}
