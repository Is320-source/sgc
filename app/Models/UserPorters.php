<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPorters extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_porters.id', 'user_porters.user_id', 'user_porters.status', 
        'user_porters.created_at', 'user_porters.updated_at', 'user_porters.deleted_at'
    ];
}
