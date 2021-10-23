<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'pv',
        'title',
        'description',
        'productimagee',
        'productimagec',
        'main_components_image_eng',
        'main_components_image_chn',
        'effects_image_eng',
        'effects_image_chn',
        'method_image_eng',
        'method_image_chn',
        'galleryimagee',
        'galleryimagec',
        'shopbannere',
        'shopbannerc',
        'status',
        'category_id',
        'regularprice',
        'saleprice',
        'offerprice',
        'pagetitle',
        'metadescription',
        'metakeyword',
        'pageurl',
        'stock',
        'features',
        'videotitle',
        'videosource',
        'usemethod',
        'size',
        'shipping_charge'
    ];
}