<?php
namespace App\Http\Controllers\Main\Admin;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:admin', ['except' => ['login']]);
	}

	public function login(Request $request)
	{
		$request->validate([
			'username'    => 'required|string',
			'password' => 'required|string',
			'remember_me' => 'boolean',
		]);

		$Admin = Admin::where('username', $request->username)->first();

		if ($Admin) {

			$credentials = $request->only(['username', 'password']);

			if ($token = auth('admin')->attempt($credentials)) {

				$tokenAdmin = Str::random(60);
				$Admin->forceFill([
					'remember_token' => hash('sha256', $token),
					'admin_token' => $tokenAdmin
				])->save();

				return response()->json([
					'auth' => [
						'token' => $this->generateToken($token),
						'admin_token' => $this->generateTokenAdmin($tokenAdmin),
					],
					'id' => $Admin->id,
					'username' => $Admin->username,
				]);
			}
			else {
				auth('admin')->invalidate(true);
				return response()->json(['error' => 'Unauthorized'], 401);
			}
		}
		else {
			auth('admin')->invalidate(true);
			return response()->json(['error' => 'Email not exist'], 401);
		}

	}

	public function getAdmin()
	{
		return response()->json(auth('admin')->user());
	}

	public function getSession()
	{
		if (auth('admin')->check()) {
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
		auth('admin')->logout();

		return response()->json(['message' => 'Successfully logged out']);
	}

	public function refresh()
	{
		$Admin = auth('admin')->user();
		$token = $Admin->refresh();
		$Admin->forceFill([
			'remember_token' => hash('sha256', $token)
		])->save();

		return $this->respondWithToken($token);
		return response()->json([
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('admin')->factory()->getTTL() * 60
		]);
	}

	protected function generateToken($token)
	{
		return [
			'access_token' => $token,
			'token_type' => 'bearer',
			'expires_in' => auth('admin')->factory()->getTTL() * 60
		];
	}

	protected function generateTokenAdmin($token)
	{
		return [
			'access_token' => $token,
			'token_type' => 'toadmin',
		];
	}
}
