<?php

namespace App\Models;

// use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	use HasFactory;

	protected $fillable = ['title', 'conjugations'];

	public $timestamps = false;

	// protected $hidden = [ ];

	protected $casts = [
		'conjugations' => 'array',
	];

	public function categories()
	{
		return $this->belongsToMany(Category::class);
	}
}
