<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'login_id', 'name', 'comment'
    ];

    protected $guarded = [
        'create_at', 'update_at'
    ];
}
