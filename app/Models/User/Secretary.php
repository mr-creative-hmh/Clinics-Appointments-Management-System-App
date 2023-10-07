<?php

namespace App\Models\User;

use App\Models\Common\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretary extends Model
{
    use HasFactory;

    protected $with = ["user"];
    protected $fillable = [
        'user_id',
        'additional_info'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
