<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json($categories);
    }

    public function show($slug)
    {
        $category = Category::where("slug", $slug)->with("posts")->first();

        // 404
        if( empty($category) ) {
            return response()->json(["message" => "Category Not Found"], 404);
        }

        return response()->json($category);
    }
}
