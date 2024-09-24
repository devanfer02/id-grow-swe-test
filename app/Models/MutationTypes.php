<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MutationTypes extends Model
{
    use HasFactory;

    public function mutations(): HasMany
    {
        return $this->hasMany(Mutation::class, 'mutation_type', 'id');
    }
}
