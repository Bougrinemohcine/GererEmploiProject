<?php

namespace App\Models;

use App\Models\module;
use App\Models\formateur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormateurModule extends Model
{
    use HasFactory;
    protected $table = 'formateur_module';

    protected $fillable = [
        'formateur_id',
        'module_id',
        'status',
    ];
    public function formateur()
    {
        return $this->belongsTo(formateur::class);
    }

    public function module()
    {
        return $this->belongsTo(module::class);
    }

}
