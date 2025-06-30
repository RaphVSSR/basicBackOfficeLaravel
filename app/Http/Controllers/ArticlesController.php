<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Articles;

class ArticlesController extends Controller
{
    //public function index(Request $request)
	//{
	//	$categories = Categories::all();
	//	$query = Articles::query()->with('categorie');

	//	if ($request->filled('categorie')) {
	//		$query->where('categorie_id', $request->categorie);
	//	}
	//	if ($request->filled('q')) {
	//		$query->where('nom', 'like', '%'.$request->q.'%');
	//	}
	//	$articles = $query->get();

	//	return view('index', compact('categories', 'articles'));
	//}

	public function index($id = null)
	{
		$categories = Categories::all();
		$articles = $id
			? Articles::where('categorie_id', $id)->orderByDesc('id')->get()
			: Articles::orderByDesc('id')->get();

		return view('index', [
			'categories' => $categories,
			'articles' => $articles,
			'selected' => $id,
		]);
	}
}
