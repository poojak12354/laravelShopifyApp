<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $fillable = [
        'qid',
        'amount',
        'currency',
        'billing_info',
        'comment_note',
        'straighten',
        'resize'
      ];
}
