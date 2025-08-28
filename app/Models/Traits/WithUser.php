<?php

namespace App\Models\Traits;

use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithUser {
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
