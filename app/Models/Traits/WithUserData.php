<?php

namespace App\Models\Traits;

use App\Models\UserDataToSend;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait WithUserData {
    public function userData(): BelongsTo{
        return $this->belongsTo(UserDataToSend::class, 'user_data_id', 'id');
    }
}
