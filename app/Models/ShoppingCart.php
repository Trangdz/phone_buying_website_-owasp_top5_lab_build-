<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Telephone;

class ShoppingCart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'telephone_id',
        'quantity',
        'status',
    ];

    public function telephone()
    {
        return $this->belongsTo(Telephone::class);
    }
}
