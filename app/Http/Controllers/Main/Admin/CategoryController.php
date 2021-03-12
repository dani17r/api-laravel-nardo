<?php
namespace App\Http\Controllers\Main\Admin;

use App\Models\Type;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin', ['except' => []]);
	}

	public function getAll(Category $Category)
	{
		$categories = $Category->all();

		foreach ($categories as $Category) {
			$types = $Category->types;
			foreach ($types as $type) {
				unset($type->pivot);
			}
		}

		return $categories;
	}

	public function createOne(Category $Category, Request $request)
	{
		$newCategory = $Category->create($request->all());
		$newCategory->save();

		return response()->json([
			'id' => $newCategory->id
		]);
	}

	public function assignOneType(Category $Category, Request $request)
	{
		$category = $Category->find($request->id);
		$category->types()->attach($request->type_id);
		// return $request;
	}

	public function removeAssignedOneType(Category $Category, Request $request)
	{
		$category = $Category->find($request->id);
		$category->types()->detach($request->type_id);
	}


	public function updateOne(Request $request, Category $Category, $id)
	{
		$Category::where('id', $id)->update([ 'title' => $request->title]);
	}

	public function destroyOne(Category $Category, $id)
	{
		$Category->where('id', $id)->delete();
	}
}
