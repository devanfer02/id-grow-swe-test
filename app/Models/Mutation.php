<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mutated_by',
        'mutated_item',
        'mutation_type',
        'description',
        'created_at'
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mutated_by', 'id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'mutated_item', 'id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(MutationTypes::class, 'mutation_type', 'id');
    }
}
