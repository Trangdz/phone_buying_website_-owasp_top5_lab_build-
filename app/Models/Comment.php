<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telephone_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function telephone()
    {
        return $this->belongsTo(Telephone::class);
    }
}
