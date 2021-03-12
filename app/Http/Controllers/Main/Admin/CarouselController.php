<?php
namespace App\Http\Controllers\Main\Admin;

use App\Models\Carousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:admin', ['except' => ['']]);

	}

	public function getAll()
	{
		$carousel = Carousel::orderBy('order', 'asc')->get();
		return response()->json($carousel);
	}

	public function createOne(Request $request)
	{
		$url = 'http://nardo-api.test/';
		$carousel = new Carousel();
		$request->validate(['image' => 'image|mimes:jpeg,png,jpg|max:8780']);

		if ($request->hasfile('image')) {

			// $path = 'carousel/mC7vWXABxgZapMEEbbu6SDsC2dtDW0A7y0M4bkYT.jpeg';
			$path = Storage::disk('public')->putFile('carousel', $request->file('image'));
			$carousel->path = $path;
			$carousel->order = $request->order;
			$carousel->url = $url.'public/'.$path;
		}

		$listo = $carousel->save();

		$response = Carousel::where('path', $path)->first();

		if ($listo) {
			return response()->json($response);
		}
		else {
			return response()->json(['error' => 'Upload fail!'], 401);
		}
	}


	public function updateOne(Request $request, $id)
	{
		$carousel = Carousel::find($id);
		$carousel->fill($request->all());
		$listo = $carousel->save();
		//
		if ($listo) {
			return response()->json(['message' => 'Carousel success update']);
		}
		else {
			return response()->json(['error' => 'Carousel fail update'], 401);
		}
	}

	public function destroyOne(Request $request)
	{
		$ids = $request->ids;
		foreach ($ids as $id)
		{
			$carousel = Carousel::where('id', $id)->first();
			Storage::disk('public')->delete($carousel->path);
			Carousel::where('id', $id)->delete();
		}
		// return response()->json([
		// 	'menssage' => 'Success carousel'
		// ]);
	}

	public function destroyAll()
	{
		Storage::disk('public')->deleteDirectory('/carousel');
		Carousel::truncate();
	}
}
