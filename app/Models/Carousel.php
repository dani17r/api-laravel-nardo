<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

	protected $hidden = [ 'path', 'updated_at' ];

	protected $fillable = ['order', 'url'];

}
