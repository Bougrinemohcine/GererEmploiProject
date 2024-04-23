<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\seance;
class salle extends Model
{
    use HasFactory;
    protected $fillable=[
        'nom_salle'
    ];
    public function seance():HasMany
    {
      return  $this->hasMany(seance::class,'id_salle');
    }
}
