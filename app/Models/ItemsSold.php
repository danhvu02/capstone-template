<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsSold extends Model
{
    use HasFactory;

    public $table = 'items_sold';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'order_id',
        'item_id',
        'item_price',
        'quantity',
    ];
}
