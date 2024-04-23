<?php

namespace App\Models;

use App\Models\groupe;
use App\Models\module;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupeModule extends Model
{
    protected $table = 'groupe_module';

    protected $fillable = [
        'groupe_id',
        'module_id',
        // Add additional fields if needed
    ];

    public function groupe(): BelongsTo
    {
        return $this->belongsTo(groupe::class, 'groupe_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(module::class, 'module_id');
    }

}
