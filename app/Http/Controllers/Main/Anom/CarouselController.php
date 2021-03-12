<?php
namespace App\Http\Controllers\Main\Anom;

use App\Models\Carousel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{

	public function viewImage($dir, $filename)
	{
		return Storage::disk('public')->get($dir.'/'.$filename);
	}

	public function getAll()
	{
		$carousel = Carousel::orderBy('order', 'asc')->get('url');
		return response()->json($carousel);
	}

}
