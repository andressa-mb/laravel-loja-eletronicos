<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\UserDataToSend;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'status', 'user_id', 'user_data_id'
    ];

    public function users(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userData(): BelongsTo{
        return $this->belongsTo(UserDataToSend::class, 'user_data_id', 'id');
    }

}
