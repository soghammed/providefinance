<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price'
    ];

    // static public function generateSlug($name)
    // {
    //     $slug = \Str::slug($name);
    //     $slugCounts = Product::where('slug', $slug)->count();
    //     $slug .= ($slugCounts ? "-".$slugCounts + 1 : '');
    //     return $slug;
    // }
}
