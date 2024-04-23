<?php

namespace App\Models;

use App\Models\salle;
use App\Models\emploi;
use App\Models\groupe;
use App\Models\module;
use App\Models\formateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class seance extends Model
{
    use HasFactory;
    protected $fillable=[
        'day',
        'order_seance',
        'id_salle',
        'id_formateur',
        'id_groupe',
        'id_emploi',
        'type_seance',
        'module_id',
];

public function formateur():BelongsTo
{
    return $this->belongsTo(formateur::class,"id_formateur");
}

        public function salle():BelongsTo
        {
           return $this->belongsTo(salle::class,"id_salle");
        }
        public function emploi():BelongsTo
        {
            return $this->belongsTo(emploi::class,"id_emploi");
        }
        public function groupe():BelongsTo
        {
          return  $this->belongsTo(groupe::class,"id_groupe");
        }
        public function module()
        {
        return $this->belongsTo(module::class); // Assuming the module relationship is defined in a Module model
        }
}
