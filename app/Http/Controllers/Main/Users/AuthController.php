<?php
namespace App\Http\Controllers\Main\Users;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:users', ['except' => ['login']]);
	}

	public function login(Request $request)
	{
		$request->validate([
			'email'    => 'required|string',
			'password' => 'required|string',
			'remember_me' => 'boolean',
		]);

		$user = User::where('email', $request->email)->first();

		if ($user) {

			$credentials = $request->only(['email', 'password']);

			if ($token = auth('users')->attempt($credentials)) {

				$tokenUser = Str::random(60);
				$user->forceFill([
					'remember_token' => hash('sha256', $token),
					'user_token' => $tokenUser
				])->save();

				return response()->json([
					'auth' => [
						'token' => $this->generateToken($token),
						'user_token' => $this->generateTokenAdmin($tokenUser),
					],
					'id' => $user->id,
					'email' => $user->email,
				]);
			}
			else {
				auth('users')->invalidate(true);
				return response()->json(['error' => 'Unauthorized'], 401);
			}
		}
		else {
			auth('users')->invalidate(true);
			return response()->json(['error' => 'Email not exist'], 401);
		}

	}

	public function getUser()
	{
		return response()->json(auth('users')->user());
	}

	public function getSession()
	{
		if (auth('users')->check()) {
			return response()->json([
				'session' => 'Active',
			]);
		}
		else {
			return response()->json([
				'session' => 'Inactive',
			], 401);
		}
	}


	public function logout()
	{
		auth('users')->logout();

		return response()->json(['message' => 'Successfully logged out']);
	}

	public function refresh()
	{
		$Admin = auth('users')->user();
		$token = $Admin->refresh();
		$Admin->forceFill([
			'remember_token' => hash('sha256', $token)
		])->save();

		return $this->respondWithToken($token);
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('users')->factory()->getTTL() * 60
		]);
	}

	protected function generateToken($token)
	{
		return [
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('users')->factory()->getTTL() * 60
		];
	}

	protected function generateTokenAdmin($token)
	{
		return [
			'access_token' => $token,
			'token_type' => 'touser',
		];
	}
}
