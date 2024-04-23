<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\seance;

class emploi extends Model
{

    use HasFactory;
    protected $fillable=[
        'date_debu',
        'date_fin'
    ];
    public function seance():HasMany
    {
       return $this->hasMany(seance::class);
    }
}
