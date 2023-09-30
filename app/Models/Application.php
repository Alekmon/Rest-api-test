<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'user',
        'message',
        'comment',
        'status',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user', 'id');
    }
}
