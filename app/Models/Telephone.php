<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;


class Telephone extends Model
{
    use HasFactory;
    protected $table = 'telephones';
    protected $fillable = [
        'name',
        'price',
        'number',
        'brandId',
        'image',
        'description',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
