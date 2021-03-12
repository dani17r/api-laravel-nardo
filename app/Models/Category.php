<?php

namespace App\Models;

// use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	use HasFactory;

	protected $fillable = ['title'];

	public $timestamps = false;

	// protected $hidden = [ ];

	// protected $casts = [ ];

	public function types()
	{
		return $this->belongsToMany(Type::class);
	}
}
