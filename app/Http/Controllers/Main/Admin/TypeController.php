<?php

namespace App\Http\Controllers\Main\Admin;

use App\Models\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth:admin', ['except' => ['']]);
	}

	public function getAll(Type $type)
	{
		$types = $type->all();

		foreach ($types as $type) {
			$categories = $type->categories;
			foreach ($categories as $category) {
				unset($category->pivot);
			}
		}

		return $types;
	}

	public function createOne(Type $Type, Request $request)
    {
 	   $newType = $Type->create($request->all());
 	   $newType->save();

 	   return response()->json([
 		   'id' => $newType->id
 	   ]);
    }

    public function assignOneType(Type $Type, Request $request, $id)
    {
 	   $category = $Type->find($id);
 	   $category->types()->attach($request->type_id);
    }


    public function updateOne(Request $request, Type $Type, $id)
    {
 	   $Type::where('id', $id)->update([ $request->value => $request->change]);
    }

    public function destroyOne(Type $Type, $id)
    {
 	   $Type->where('id', $id)->delete();
    }
}
