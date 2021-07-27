<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_product',
        'name',
        'image',
        'quantity',
        'price',
        'unit',
        'description',
    ];

    public function getImageAttribute($value) {
        $path = 'storage/product/' . $value;
        return $value ? asset($path) : 'https://www.riobeauty.co.uk/images/product_image_not_found.gif';

    }

}
