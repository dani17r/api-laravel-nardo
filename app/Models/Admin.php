<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements JWTSubject
{

	use HasFactory, Notifiable;

	protected $table = 'admin';

	/**
	* The attributes that are mass assignable.
	*
	* @var array
	*/
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	* The attributes that should be hidden for arrays.
	*
	* @var array
	*/
	protected $hidden = [
		'password',
		'remember_token',
		'admin_token',
	];

	/**
	* The attributes that should be cast to native types.
	*
	* @var array
	*/
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/**
	* Get the identifier that will be stored in the subject claim of the JWT.
	*
	* @return mixed
	*/
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}
	/**
	* Return a key value array, containing any custom claims to be added to the JWT.
	*
	* @return array
	*/
	public function getJWTCustomClaims()
	{
		return [];
	}
}
