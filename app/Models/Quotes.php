<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'currency',
        'image_complexity',
        'services',
        'file_type',
        'comment',
        'images_count',
        'total_amount'
      ];
}
